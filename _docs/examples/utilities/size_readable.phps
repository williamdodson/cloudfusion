<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonS3.
 */
$s3 = new AmazonS3();


/**
 * Converts a file size in bytes into a human-friendly size.
 */
echo 'The size of the file is a whopping ' . $s3->util->size_readable(123456789) . ' (which is the same as ' . $sqs->util->size_readable(123456789, 'kB') . ').';

?>