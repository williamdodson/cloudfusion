--TEST--
CloudFusion - HTTP_HEAD

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(HTTP_HEAD);
?>

--EXPECT--
string(4) "HEAD"
