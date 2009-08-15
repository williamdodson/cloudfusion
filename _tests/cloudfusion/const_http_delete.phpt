--TEST--
CloudFusion - HTTP_DELETE

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(HTTP_DELETE);
?>

--EXPECT--
string(6) "DELETE"
