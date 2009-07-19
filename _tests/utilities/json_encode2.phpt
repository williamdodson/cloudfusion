--TEST--
CFUtilities - json_encode boolean

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->json_encode(true));
?>

--EXPECT--
string(4) "true"
