--TEST--
CloudFusion - CLOUDFUSION_NAME

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(CLOUDFUSION_NAME);
?>

--EXPECT--
string(11) "CloudFusion"
