<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonAAWS object using the settings from the config.inc.php file.
 */
$aaws = new AmazonAAWS();


/**
 * Instantiate a new AmazonAAWS object using these specific settings.
 */
$aaws = new AmazonAAWS($key, $secret_key, $assoc_id);


?>