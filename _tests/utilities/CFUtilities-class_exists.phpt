--TEST--
CFUtilities - Exists

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new CFUtilities();
	var_dump(class_exists('CFUtilities'));
?>

--EXPECT--
bool(true)
