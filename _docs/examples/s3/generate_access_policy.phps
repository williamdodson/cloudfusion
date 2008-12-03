<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Generate ACP XML.
 */
header('Content-type:text/xml; charset=utf-8');

echo $s3->generate_access_policy(AWS_CANONICAL_ID, AWS_CANONICAL_NAME, array(
	array(
		'id' => S3_USERS_AUTH, // Authorized Users
		'permission'=> S3_GRANT_WRITE
	),
	array(
		'id' => S3_USERS_ALL, // All Users
		'permission'=> S3_GRANT_READ
	),
	array(
		'id' => S3_USERS_LOGGING, // Logging User
		'permission'=> S3_GRANT_WRITE
	),
	array(
		'id' => S3_USERS_LOGGING, // Logging User
		'permission'=> S3_GRANT_READ_ACP
	),
	array(
		'id' => 'ryan@tarzan-aws.com', // Specific Amazon User by Email Address
		'permission'=> S3_GRANT_FULL_CONTROL
	),
	array(
		'id' => 'testing@amazon.com', // Specific Amazon User by Email Address
		'permission'=> S3_GRANT_WRITE_ACP
	),
));

?>