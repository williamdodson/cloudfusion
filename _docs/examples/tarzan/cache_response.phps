<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonS3.
 */
$s3 = new AmazonS3();


/**
 * Normal request out to the S3 service. This will go out, wait for the response, 
 * and return the fresh data every single time.
 */
$head = $s3->head_object('warpshare.test.eu', 'sample.txt');


/**
 * Response caching will make the request out to the service the very first time, 
 * then cache the response so that subsequent requests hit the cache instead of 
 * going out to S3 and coming back. Data freshness is sacrificed for operation speed.
 * 
 * When the cache expires, the next request will go all the way out to the S3 service 
 * and fetch and cache new data.
 * 
 * First parameter is the name of the method, while the last is an array containing 
 * the parameters to pass in. The middle two are the cache location and cache 
 * duration (in seconds).
 */
$head = $s3->cache_response('head_object', './cache', 10, array('warpshare.test.eu', 'sample.txt'));


/**
 * Simpler response to cache.
 */
$list = $s3->cache_response('list_buckets', './cache', 10);


/**
 * Here, we'll cache the response of a MultiCurl request. Since the method we want to 
 * fire isn't part of the $s3 object, we'll pass in an array with the correct parent 
 * object as the first entry and the method as the second.
 * 
 * We've previously collected an array of cURL handles to fire in parallel in $handles.
 */
$http = new RequestCore(null);
$multi = $s3->cache_response(array($http, 'send_multi_request'), './cache', 3600, array($handles));

?>