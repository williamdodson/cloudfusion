<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonSQS object using the settings from the config.inc.php file.
 */
$sqs = new AmazonSQS();


/**
 * Delete an SQS queue.
 */
$queue = $sqs->delete_queue('http://queue.amazonaws.com/warpshare_test');

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