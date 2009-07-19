--TEST--
CFUtilities - size_readable retstring

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->size_readable(9876543210, 'kB', '%01.5f %s'));
?>

--EXPECT--
string(16) "9645061.72852 kB"
