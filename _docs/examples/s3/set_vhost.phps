<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonS3 object using the settings from the config.inc.php file.
 */
$s3 = new AmazonS3();


/**
 * Use a virtual host address for URLs and other HTTP requests instead of the <bucket>.s3.amazonaws.com URL.
 * http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?VirtualHosting.html
 */
$s3->set_vhost('s3.warpshare.com');

?>