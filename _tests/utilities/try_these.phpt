--TEST--
CFUtilities - try_these values

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->try_these(array(1, null, null, null)));
?>

--EXPECT--
int(1)
