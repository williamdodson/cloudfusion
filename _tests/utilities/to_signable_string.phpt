--TEST--
CFUtilities - to_signable_string

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump($util->to_signable_string(array(
		'a a' => 1,
		'b+b' => 2,
		'c:c' => 3,
		'd~d' => 4,
	)));
?>

--EXPECT--
string(29) "a%20a=1&b%2Bb=2&c%3Ac=3&d~d=4"
