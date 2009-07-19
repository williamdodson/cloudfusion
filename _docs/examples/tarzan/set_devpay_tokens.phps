<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonS3.
 */
$s3 = new AmazonS3();


/**
 * Tell Tarzan to use these user and product tokens so that the customer gets 
 * charged for the usage instead of you.
 */
$s3->set_devpay_tokens('eW91dHViZQ==', 'b0hnNVNKWVJIQTA='); // Fake tokens.


/**
 * Do S3-related tasks. Will continue to bill the same DevPay customer until 
 * the DevPay tokens are changed or this object is destroyed.
 */
$s3->create_bucket('user_bucket');
$s3->create_object('user_bucket', array(
	'filename' => 'user_file.txt',
	'body' => file_get_contents('file.txt'),
	'contentType' => 'text/plain',
	'acl' => S3_ACL_PUBLIC
));

?>