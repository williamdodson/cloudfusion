--TEST--
CFUtilities - json_encode_php51 integer

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->json_encode_php51(1));
?>

--EXPECT--
string(1) "1"