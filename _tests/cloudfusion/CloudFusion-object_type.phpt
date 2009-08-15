--TEST--
CloudFusion - Object type

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(get_class($f));
?>

--EXPECT--
string(11) "CloudFusion"
