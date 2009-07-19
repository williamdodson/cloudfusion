--TEST--
CFUtilities - json_encode_php51 float

--FILE--
<?php
	ini_set('disable_functions', 'json_encode');
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->json_encode_php51(1.2));
?>

--EXPECT--
string(3) "1.2"