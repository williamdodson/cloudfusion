<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonCloudFront object using the settings from the config.inc.php file.
 */
$cf = new AmazonCloudFront();


/**
 * Instantiate a new AmazonCloudFront object using these specific settings.
 */
$cf = new AmazonCloudFront($key, $secret_key);


?>