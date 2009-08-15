--TEST--
CloudFusion - set_proxy

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	$f->set_proxy('test');
	var_dump($f->set_proxy);
?>

--EXPECT--
string(4) "test"