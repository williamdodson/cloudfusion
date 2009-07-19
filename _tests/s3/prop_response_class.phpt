--TEST--
AmazonS3::response_class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonS3();
	var_dump($s3->response_class);
?>

--EXPECT--
string(12) "ResponseCore" 
