--TEST--
CloudFusion - HTTP_POST

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(HTTP_POST);
?>

--EXPECT--
string(4) "POST"
