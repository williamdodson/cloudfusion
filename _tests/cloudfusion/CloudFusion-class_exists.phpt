--TEST--
CloudFusion - Exists

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(class_exists('CloudFusion'));
?>

--EXPECT--
bool(true)
