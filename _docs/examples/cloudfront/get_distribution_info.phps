<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonCloudFront object using the settings from the config.inc.php file.
 */
$cf = new AmazonCloudFront();


/**
 * Get information about a specific distribution.
 */
$info = $cf->get_distribution_info($distribution_id);

// Set some values
$last_modified = (string) $info->body->LastModifiedTime;
$domain = (string) $info->body->DomainName;

?>