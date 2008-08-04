<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonSDB object using the settings from the config.inc.php file.
 */
$sdb = new AmazonSDB();


/**
 * Instantiate a new AmazonSDB object using these specific settings.
 */
$sdb = new AmazonSDB($key, $secret_key);


?>