--TEST--
CFUtilities - time_hms

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->time_hms(98765));
?>

--EXPECT--
string(8) "27:26:05"
