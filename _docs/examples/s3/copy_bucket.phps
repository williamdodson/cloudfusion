<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Copy the contents of an existing bucket to a newly created bucket.
 */
$copy = $s3->copy_bucket('warpshare.test.eu', 'warpshare.test.eu.backup');


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($copy);
echo '</pre>';


/**
 * Custom function for displaying which files were successfully copied. Accepts the 
 * response from the copy_bucket() method as input.
 */
function list_successful_files($copy_object, $status = 200)
{
	$files = array();

	foreach ($copy_object as $obj)
	{
		if ($obj->isOK($status))
		{
			$files[] = (string) $obj->header['_info']['url'];
		}
	}

	return $files;
}


/**
 * Example of us calling the new custom function and passing in the copy_object() 
 * response to get an array of filenames that were successfully copied.
 */
$files = list_successful_files($copy);
print_r($files);


?>