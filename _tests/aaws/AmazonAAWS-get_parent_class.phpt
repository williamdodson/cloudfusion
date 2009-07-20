--TEST--
AmazonAAWS - Get parent class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new AmazonAAWS();
	var_dump(get_parent_class('AmazonAAWS'));
?>

--EXPECT--
string(11) "CloudFusion"