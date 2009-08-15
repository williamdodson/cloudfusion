--TEST--
CloudFusion - HTTP_PUT

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(HTTP_PUT);
?>

--EXPECT--
string(3) "PUT"
