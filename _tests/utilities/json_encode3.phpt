--TEST--
CFUtilities - json_encode string

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->json_encode('example'));
?>

--EXPECT--
string(9) ""example""
