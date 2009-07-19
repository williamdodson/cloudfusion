<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonS3.
 */
$s3 = new AmazonS3();


/**
 * Converts a query string back into an array. Supports multiple 
 * keys with the same name.
 */
$arr = $s3->util->query_to_array('key1=value&key1=value&key2=value');

print_r($arr);
/**
Array
(
	[key1] => Array
		(
			[0] => value
			[1] => value
		)

	[key2] => value
)
*/

?>