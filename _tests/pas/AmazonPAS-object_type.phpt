--TEST--
AmazonPAS - Object type

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$pas = new AmazonPAS();
	var_dump(get_class($pas));
?>

--EXPECT--
string(9) "AmazonPAS"
