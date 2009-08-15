--TEST--
CloudFusion - disable_ssl

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	$f->disable_ssl(true);
	var_dump($f->enable_ssl);
?>

--EXPECT--
bool(false)
