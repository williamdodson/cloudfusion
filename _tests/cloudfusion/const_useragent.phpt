--TEST--
CloudFusion - CLOUDFUSION_USERAGENT

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(CLOUDFUSION_USERAGENT);
?>

--EXPECTF--
string(%d) "CloudFusion/%f (Cloud Computing Toolkit; http://getcloudfusion.com) Build/%d"
