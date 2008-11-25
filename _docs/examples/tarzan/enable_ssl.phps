<?php
require_once('tarzan.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonSQS.
 */
$sqs = new AmazonSQS();


/**
 * As of revision 198, SSL (https) is enabled by default. Use this only for 
 * disabling SSL. Disabling SSL can be useful for debugging purposes such 
 * as packet sniffing your own requests/responses.
 */
$sqs->enable_ssl(false);


/**
 * Begin using the class as normal. For example:
 */
$list = $sqs->list_queues();

?>