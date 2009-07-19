--TEST--
CFUtilities - to_query_string

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->to_query_string(array(
		'a' => 1,
		'b' => 2,
		'c' => 3,
	)));
?>

--EXPECT--
string(11) "a=1&b=2&c=3"
