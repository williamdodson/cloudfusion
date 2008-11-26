<?php
require_once('tarzan.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonS3.
 */
$s3 = new AmazonS3();


/**
 * Used only for calculating signatures when communicating with AWS. 
 * Converts an array into a signable string.
 */
$arr = array(
	'key1' => 'value1',
	'key2' => 'value2',
	'key3' => 'value3'
);

$signature = signing_function($s3->util->to_signable_string($arr));


?>