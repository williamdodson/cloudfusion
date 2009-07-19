<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonSQSQueue object using the settings from the config.inc.php file.
 */
$sqs = new AmazonSQSQueue('warpshare_test');


/**
 * Set a queue attribute.
 */
$attr = $sqs->set_queue_attributes(array(
	'VisibilityTimeout' => 7200
));

// As long as the request was successful...
if ($attr->isOK())
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
print_r($attr);
echo '</pre>';


?>