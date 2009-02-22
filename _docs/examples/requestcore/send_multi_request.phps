<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Loop through a series of bucket names and collect the not-fired cURL handles.
 * Setting returnCurlHandle will return a handle for the request without actually firing it.
 */
$handles = array();
$buckets = array('test_one', 'test_two', 'test_three');

foreach ($buckets as $bucket)
{
	// Collect the cURL handles by setting returnCurlHandle to true.
	$handles[] = $s3->list_objects($bucket, array('returnCurlHandle' => true));
}


/**
 * Instantiate a new RequestCore object for the purpose of firing a MultiCurl (parallel) request.
 */
$request = new RequestCore(null); // We're not firing on a single URL.
$response = $request->send_multi_request($handles); // Fire the cURL handles we previously collected.

print_r($response);

?>