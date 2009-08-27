--TEST--
CFUtilities - query_to_array multi-dimensional

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$util = new CFUtilities();

	// Test data
	var_dump($util->query_to_array('a=1&a=2&a=3&b=2&c=3'));
?>

--EXPECT--
array(3) {
  ["a"]=>
  array(3) {
    [0]=>
    string(1) "1"
    [1]=>
    string(1) "2"
    [2]=>
    string(1) "3"
  }
  ["b"]=>
  string(1) "2"
  ["c"]=>
  string(1) "3"
}