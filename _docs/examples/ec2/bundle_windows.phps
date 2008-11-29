<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonEC2 object using the settings from the config.inc.php file.
 */
$ec2 = new AmazonEC2();


/**
 * Bundle a Windows instance.
 */
$bundle = $ec2->bundle_instance('1234567890', array(
	'Bucket' => 'warpshare_test',
	'Prefix' => 'test_'
));


/**
 * Bundle a Windows instance with a custom upload policy.
 * Re-creates the sample JSON upload policy provided in 
 * http://docs.amazonwebservices.com/AWSEC2/2008-08-08/DeveloperGuide/index.html?ApiReference-Query-BundleInstance.html
 * 
 * I can't say that I understand all of the available 
 * options, or how they're all called, but the Amazon S3 
 * HTTP POST docs do a decent job of explaining options.
 * http://docs.amazonwebservices.com/AmazonS3/latest/index.html?HTTPPOSTExamples.html
 */
$policy = array(
	'expiration' => gmdate(DATE_AWS_ISO8601, strtotime('+12 hours')), // Use some date magic.
	'conditions' => array(
		array('bucket' => 'bucket'), // Associative array
		array('acl' => 'ec2-bundle-read'), // Associative array
		array('starts-with', '$key', 'my-ami') // Indexed array
	)
);

/**
policy = {
	"expiration": "2008-08-08T09:41:01Z",
	"conditions": [
		{"bucket": "bucket"},
		{"acl": "ec2-bundle-read"},
		["starts-with", "$key", "my-ami"]
	]
}
*/

$bundle = $ec2->bundle_instance('1234567890', array(
	'Bucket' => 'warpshare_test',
	'Prefix' => 'test_',
	'UploadPolicy' => $policy
));

print_r($bundle);

/********************************************************************************************************************/

$describe = $ec2->describe_bundle_tasks();
print_r($describe);

$cancel = $ec2->cancel_bundle_task('1234567890');
print_r($cancel);

?>