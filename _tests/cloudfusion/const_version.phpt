--TEST--
CloudFusion - CLOUDFUSION_VERSION

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(CLOUDFUSION_VERSION);
?>

--EXPECTF--
string(%d) "%f"
