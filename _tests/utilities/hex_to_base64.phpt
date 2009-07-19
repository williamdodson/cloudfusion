--TEST--
CFUtilities - hex_to_base64

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->hex_to_base64('example'));
?>

--EXPECT--
string(8) "DgoADg=="
