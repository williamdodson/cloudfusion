<?php
require_once('tarzan.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonSQS.
 */
$sqs = new AmazonSQS();


/**
 * For some reason, our server clock is out of sync with Amazon's. Probably 
 * because we're not syncing with a standard time server. Let's adjust our 
 * clock forward by 20 minutes to more closely match Amazon's clock so that 
 * the request will go through without Amazon thinking it's a stale request.
 */
$sqs->adjust_offset(1200);


/**
 * Begin using the class as normal. For example:
 */
$list = $sqs->list_queues();

?>