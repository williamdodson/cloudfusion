<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonCloudFront object using the settings from the config.inc.php file.
 */
$cf = new AmazonCloudFront();


/**
 * Generate a DistributionConfig XML document. This method is generally used internally by create_distribution().
 */
$caller_reference = sha1(time() . $cf->key);

$config_xml = $cf->generate_config_xml('warpshare_test', $caller_reference, array(
	'Comment' => 'This is my special comment.',
	'CNAME' => 'cdn.warpshare.com'
));

// Display the raw XML document.
echo $config_xml;

?>