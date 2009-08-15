--TEST--
CloudFusion - set_hostname

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	$f->set_hostname('example.com');
	var_dump($f->hostname);
?>

--EXPECT--
string(11) "example.com"
