--TEST--
AmazonSDB - Get parent class

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$sdb = new AmazonSDB();

	// Success?
	var_dump(get_parent_class('AmazonSDB'));
?>

--EXPECT--
string(11) "CloudFusion"