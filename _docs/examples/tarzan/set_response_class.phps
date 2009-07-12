<?php
require_once('tarzan.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonSQS.
 */
$sqs = new AmazonSQS();


/**
 * Tell Tarzan to use a custom class for responses. The custom class should 
 * override/extend the TarzanHTTPResponse class.
 */
$sqs->set_response_class('CustomHTTPResponse');


/**
 * Make sure you define your custom class.
 */
class CustomHTTPResponse extends TarzanHTTPResponse
{
	// Add new methods or override existing ones.
}


/**
 * Begin using the class as normal, with any adjustments. For example:
 */
$list = $sqs->list_queues();

?>