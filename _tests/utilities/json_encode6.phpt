--TEST--
CFUtilities - json_encode list

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->json_encode(array(
		'string',
		1,
		1.2,
		true,
	)));
?>

--EXPECT--
string(21) "["string",1,1.2,true]"
