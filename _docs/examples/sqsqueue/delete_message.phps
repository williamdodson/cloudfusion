<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonSQSQueue object using the settings from the config.inc.php file.
 */
$sqs = new AmazonSQSQueue('warpshare_test');


/**
 * Delete a message by passing in the Message Receipt ID from when we received the message.
 */
$message = $sqs->delete_message('545e1233-284b-4bf7-aca8-eac3b703d349');

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