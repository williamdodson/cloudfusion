<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonCloudFront object using the settings from the config.inc.php file.
 */
$cf = new AmazonCloudFront();


/**
 * Read the current DistributionConfig XML settings, update them, and write the update back to the server.
 */

// Read the current settings
$dist_config = $cf->get_distribution_config($distribution_id);

// Remove a certain CNAME value from the DistributionConfig XML.
$updated_xml = $cf->remove_cname('cdn.warpshare.com');

// Write the updated DistributionConfig XML back to the CloudFront distribution.
$set_config = $cf->set_distribution_config(
	$distribution_id, 
	$updated_xml, 
	$dist_config->header['etag']
);

// View the response from the write.
print_r($set_config);

?>