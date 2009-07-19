--TEST--
CFUtilities - Get parent class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$s3 = new CFUtilities();
	var_dump(get_parent_class('CFUtilities'));
?>

--EXPECT--
bool(false)