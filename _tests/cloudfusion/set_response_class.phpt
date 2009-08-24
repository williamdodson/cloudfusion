--TEST--
CloudFusion - set_response_class

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	/**
	 * You wouldn't normally call this class directly. These methods
	 * are inherited by the service-specific classes.
	 */

	// Custom class to extend ResponseCore
	class TestResponseCore extends ResponseCore
	{
		public function test_method()
		{
			return true;
		}
	}

	// Instantiate class and set new class
	$f = new CloudFusion();
	$f->set_response_class('TestResponseCore');

	// Test if the value was set
	var_dump($f->response_class);
?>

--EXPECT--
string(16) "TestResponseCore"
