<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonSQS.
 */
$sqs = new AmazonSQS();


/**
 * Pass requests through a proxy server if one is necessary. MUST use the 'proxy://' protocol 
 * or Tarzan won't be able to parse it properly. (Uses PHP's parse_url() under the hood.)
 */
$sqs->set_proxy('proxy://user:pass@example.com:8080');


/**
 * Begin using the class as normal. For example:
 */
$list = $sqs->list_queues();

?>