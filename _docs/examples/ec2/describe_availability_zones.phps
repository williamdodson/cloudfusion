<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonEC2 object using the settings from the config.inc.php file.
 */
$ec2 = new AmazonEC2();


/**
 * Describe ALL availability zones.
 */
$describe = $ec2->describe_availability_zones();

print_r($describe);


/**
 * Describe SPECIFIC availability zones.
 */
$describe = $ec2->describe_availability_zones(array(
	'ZoneName.1' => 'us-east-1a',
	'ZoneName.2' => 'us-east-1b',
));

print_r($describe);

?>