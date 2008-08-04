<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Instantiate a new AmazonS3 object using these specific settings.
 */
$s3 = new AmazonS3($key, $secret_key);


?>