<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * For the sake of example, let's create a bucket that we know is in the European Union.
 */
$bucket = $s3->create_bucket('warpshare.test.eu', S3_LOCATION_EU);


/**
 * As long as the request came back with a positive response (HTTP Status Code 200)...
 */
if ($bucket->isOK())
{

	/**
	 * Let's get the locale of the bucket we just created. Remember that this returns a 
	 * ResponseCore object.
	 */
	$locale = $s3->get_bucket_locale('warpshare.test.eu');


	/**
	 * We can look at the resulting data if we want to.
	 */
	echo '<pre>';
	print_r($locale);
	echo '</pre>';


	/**
	 * If there is no body, it's a US bucket. Otherwise, the bucket is from a different 
	 * geographical location (currently only the EU).
	 */
	if (empty($locale->body))
	{
		echo 'US';
	}
	else
	{
		echo $locale->body;
	}
}


?>