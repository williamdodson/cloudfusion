<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonSQS object using the settings from the config.inc.php file.
 */
$sqs = new AmazonSQS();


/**
 * Get the APPROXIMATE number of messages currently in the queue.
 */
$queue_size = $sqs->get_queue_size('http://queue.amazonaws.com/warpshare-test');

echo 'There are currently ' . $queue_size . ' messages in this queue.';


?>