<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonCloudFront object using the settings from the config.inc.php file.
 */
$cf = new AmazonCloudFront();


/**
 * List all of the existing distributions.
 */
$list = $cf->list_distributions();

// Response for the creation.
print_r($list);

?>