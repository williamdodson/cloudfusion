<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonSQSQueue object using the settings from the config.inc.php file.
 */
$sqs = new AmazonSQSQueue('warpshare_test');


/**
 * Instantiate a new AmazonSQSQueue object using these specific settings.
 */
$sqs = new AmazonSQSQueue('warpshare_test', $key, $secret_key);


?>