--TEST--
CFUtilities - size_readable

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->size_readable(9876543210));
?>

--EXPECT--
string(7) "9.20 GB"
