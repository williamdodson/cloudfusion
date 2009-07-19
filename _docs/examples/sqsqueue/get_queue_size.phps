<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonSQSQueue object using the settings from the config.inc.php file.
 */
$sqs = new AmazonSQSQueue('warpshare_test');


/**
 * Get the APPROXIMATE number of messages currently in the queue.
 */
$queue_size = $sqs->get_queue_size();

echo 'There are currently ' . $queue_size . ' messages in this queue.';


?>