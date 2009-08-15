--TEST--
CloudFusion - Get parent class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(get_parent_class('CloudFusion'));
?>

--EXPECT--
bool(false)
