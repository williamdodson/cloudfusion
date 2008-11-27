<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonEC2 object using the settings from the config.inc.php file.
 */
$ec2 = new AmazonEC2();


// Retrieve a list of public images owned by Amazon.
$images = $ec2->describe_images(array(
	'Owner.1' => 'amazon'
));

// Loop through the list...
foreach ($images->body->imagesSet->item as $image)
{
	// Check the location of each image for a specific filename -- Fedora 8 for i386.
	if (stripos((string) $image->imageLocation, 'fedora-8-i386-base-v1.07') !== false)
	{
		// Grab the id for the image.
		$image_id = (string) $image->imageId;

		// Launch a new instance of this image, and grab the id for the virtual machine instance.
		$run = $ec2->run_instances($image_id, 1, 1);
		$instance_id = $run->body->instancesSet->item->instanceId;

		// Allocate a new elastic IP address and grab it.
		$allocate = $ec2->allocate_address();
		$ip_addr = $allocate->body->publicIp;

		// Associate the elastic IP address with the running instance.
		$associate = $ec2->associate_address($instance_id, $ip_addr);

		// As long as the association was successful...
		if ($associate->body->return == 'true')
		{
			// Let's output some data that we've collected so far.
			echo '<h1>Report</h1>';
			echo '<p>Instance <strong>' . $instance_id . '</strong> was launched from AMI <strong>' . $image_id . '</strong> and is associated with <strong>' . $ip_addr . '</strong>.</p>';

			// Prepare to store some data
			$ips = array();

			// Describe the elastic IPs.
			$eips = $ec2->describe_addresses();

			// Loop through each IP address...
			foreach ($eips->body->addressesSet->item as $ip)
			{
				// Store the IP addresses in the aforementioned array.
				$ips[] = (string) $ip->publicIp;
			}

			// Display the in-use elastic IPs.
			echo '<p>Elastic IPs: ' . implode(', ', $ips) . '</p>';

			// Disassociate the address from the running instance.
			$disassociate = $ec2->disassociate_address($ip_addr);

			// As long as we were successful...
			if ($disassociate->body->return == 'true')
			{
				// Release the IP address back into the main pool.
				$ec2->release_address($ip_addr);

				// Terminate our EC2 instance.
				$ec2->terminate_instances(array(
					'InstanceId.1' => $instance_id;
				));
			}
		}

		// After we've found our Fedora 8 image and done some things with it, we'll stop looping through the list of images.
		break;
	}
}

?>
