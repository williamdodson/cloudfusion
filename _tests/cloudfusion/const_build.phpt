--TEST--
CloudFusion - CLOUDFUSION_BUILD

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(CLOUDFUSION_BUILD);
?>

--EXPECTF--
string(%d) "%d"