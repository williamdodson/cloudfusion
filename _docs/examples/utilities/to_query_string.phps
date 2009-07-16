<?php
require_once('tarzan.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonS3.
 */
$s3 = new AmazonS3();


/**
 * Convert an array (typically associative) into a query string.
 */
$arr = array(
	'key1' => 'value1',
	'key2' => 'value2',
	'key3' => 'value3'
);

$query_string = $s3->util->to_query_string($arr);

$http = new RequestCore('http://domain.com/path.php?' . $query_string);


?>