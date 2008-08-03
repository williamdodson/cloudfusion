<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Create a new bucket in the United States. Since bucket names need to be unique across 
 * the entire S3 service, it's always a good idea to prefix the bucket name with something 
 * representative of you (or your organization) specifically.
 * 
 * http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?BucketRestrictions.html
 */
$bucket = $s3->create_bucket('warpshare.images');


// As long as there were no errors...
if ($bucket->isOK())
{
	// Do stuff with the bucket.
}


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($bucket);
echo '</pre>';


/*========================================================*/


/**
 * Same as above, but explicitly choose the European Union using the S3_LOCATION_EU constant.
 */
$s3->create_bucket('warpshare.images', S3_LOCATION_EU);


?>