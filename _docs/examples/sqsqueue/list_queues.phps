<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonSQSQueue object using the settings from the config.inc.php file.
 */
$sqs = new AmazonSQSQueue('warpshare_test');


/**
 * List your queues.
 */
$list = $sqs->list_queues();

// As long as the request was successful...
if ($queues->isOK())
{
	echo '<ul>';
	foreach ($list->body->ListQueuesResult->QueueUrl as $queue)
	{
		echo '<li>' . $queue . '</li>';
	}
	echo '</ul>';
}


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($list);
echo '</pre>';


?>