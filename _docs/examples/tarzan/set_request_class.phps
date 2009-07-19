<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonSQS.
 */
$sqs = new AmazonSQS();


/**
 * Tell Tarzan to use a custom class for requests. The custom class should 
 * override/extend the RequestCore class.
 */
$sqs->set_request_class('CustomHTTPRequest');


/**
 * Make sure you define your custom class.
 */
class CustomHTTPRequest extends RequestCore
{
	// Add new methods or override existing ones.
}


/**
 * Begin using the class as normal, with any adjustments. For example:
 */
$list = $sqs->list_queues();

?>