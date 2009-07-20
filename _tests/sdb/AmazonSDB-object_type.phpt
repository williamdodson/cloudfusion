--TEST--
AmazonSDB - Object type

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	var_dump(get_class($sdb));
?>

--EXPECT--
string(9) "AmazonSDB"
