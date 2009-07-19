--TEST--
CFUtilities - try_these with default value

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->try_these(array(null, null, null, null), null, true));
?>

--EXPECT--
bool(true)
