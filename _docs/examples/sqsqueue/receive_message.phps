<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonSQSQueue object using the settings from the config.inc.php file.
 */
$sqs = new AmazonSQSQueue('warpshare_test');


/**
 * Receive one message.
 */
$message = $sqs->receive_message();

// As long as the request was successful...
if ($message->isOK())
{
	// Do stuff!
}


/**
 * Receive multiple messages and extend the timeout.
 */
$message = $sqs->receive_message(array(
	'MaxNumberOfMessages' => 10,
	'VisibilityTimeout' => 120
));

// As long as the request was successful...
if ($message->isOK())
{
	// Do stuff!
}


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($message);
echo '</pre>';


?>