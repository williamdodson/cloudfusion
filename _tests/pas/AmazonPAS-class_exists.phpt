--TEST--
AmazonPAS - Exists

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$pas = new AmazonPAS();
	var_dump(class_exists('AmazonPAS'));
?>

--EXPECT--
bool(true)
