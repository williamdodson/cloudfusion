--TEST--
CFUtilities - query_to_array

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	$qs = $util->to_query_string(array(
		'a' => 1,
		'b' => 2,
		'c' => 3,
	));

	// Success?
	var_dump($qs);
	var_dump($util->query_to_array($qs));
?>

--EXPECT--
string(11) "a=1&b=2&c=3"
array(3) {
  ["a"]=>
  string(1) "1"
  ["b"]=>
  string(1) "2"
  ["c"]=>
  string(1) "3"
}
