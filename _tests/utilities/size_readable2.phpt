--TEST--
CFUtilities - size_readable other units

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->size_readable(9876543210, 'kB'));
?>

--EXPECT--
string(13) "9645061.73 kB"
