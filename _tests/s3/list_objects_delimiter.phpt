--TEST--
AmazonS3::list_objects delimiter

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	$response = $s3->list_objects('s3.ryanparman.com', array(
		'delimiter' => '1'
	));
	var_dump($response->status);
?>

--EXPECT--
int(200)
