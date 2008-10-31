<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonAAWS object using the settings from the config.inc.php file.
 */
$ec2 = new AmazonAAWS();


/**
 * Instantiate a new AmazonAAWS object using these specific settings.
 */
$ec2 = new AmazonAAWS($key, $secret_key, $assoc_id);


?>