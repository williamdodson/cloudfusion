--TEST--
CFUtilities - json_encode_php51 string

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->json_encode_php51('example'));
?>

--EXPECT--
string(9) ""example""
