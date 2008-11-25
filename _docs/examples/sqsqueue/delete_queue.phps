<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonSQSQueue object using the settings from the config.inc.php file.
 */
$sqs = new AmazonSQSQueue('warpshare_test');


/**
 * Delete an SQS queue.
 */
$queue = $sqs->delete_queue();

// As long as the request was successful...
if ($queue->isOK())
{
	echo 'Your queue was successfully deleted.';
}


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($queue);
echo '</pre>';


?>