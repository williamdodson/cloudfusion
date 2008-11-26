<?php
require_once('tarzan.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonS3.
 */
$s3 = new AmazonS3();


/**
 * Check to make sure a variable (including POST/GET/REQUEST variables) is set and not an empty string.
 */
if ($s3->util->ready($_GET['query']))
{
	// Do something with $_GET['query']
}

?>