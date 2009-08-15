--TEST--
CloudFusion - adjust_offset

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	$f->adjust_offset(123456789);
	var_dump($f->adjust_offset);
?>

--EXPECT--
int(123456789)
