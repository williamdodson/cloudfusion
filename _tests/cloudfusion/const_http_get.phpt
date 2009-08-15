--TEST--
CloudFusion - HTTP_GET

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(HTTP_GET);
?>

--EXPECT--
string(3) "GET"
