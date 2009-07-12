<?php
$time_start = microtime(true);
// require_once '../tarzan.class.php';
require_once '../../branches/2.0/tarzan.class.php';
require_once '../config.inc.php';
error_reporting(E_ALL);
header('Content-type: text/plain; charset=utf-8');


$s3 = new AmazonS3();
$data = $s3->create_object('warpshare.test', array(
	'filename' => 'farfignewton.txt', 
	'body' => gzencode('This is my highly compressed text.'),
	'acl' => S3_ACL_PUBLIC,
	'contentType' => 'text/plain',
	'headers' => array(
		'Content-Encoding' => 'gzip'
	)
));
print_r($data);



$time = microtime(true) - $time_start;
echo "\n\n\n$time";

?>
