--TEST--
AmazonPAS - Get parent class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$pas = new AmazonPAS();
	var_dump(get_parent_class('AmazonPAS'));
?>

--EXPECT--
string(11) "CloudFusion"