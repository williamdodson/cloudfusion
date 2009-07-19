--TEST--
CFUtilities - try_these values2

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->try_these(array(null, null, 1, null)));
?>

--EXPECT--
int(1)
