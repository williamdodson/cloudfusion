<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonSQS object using the settings from the config.inc.php file.
 */
$sqs = new AmazonSQS();


/**
 * Instantiate a new AmazonSQS object using these specific settings.
 */
$sqs = new AmazonSQS($key, $secret_key);


?>