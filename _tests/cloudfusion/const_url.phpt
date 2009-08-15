--TEST--
CloudFusion - CLOUDFUSION_URL

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(CLOUDFUSION_URL);
?>

--EXPECT--
string(25) "http://getcloudfusion.com"
