<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonS3.
 */
$s3 = new AmazonS3();


/**
 * Hex to Base64 is used along with HMAC to create a request signature 
 * when communicating with AWS. This is how it works by itself.
 */
echo $s3->util->hex_to_base64($hex_value);

?>