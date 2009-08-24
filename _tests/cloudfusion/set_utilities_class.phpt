--TEST--
CloudFusion - set_utilities_class

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	/**
	 * You wouldn't normally call this class directly. These methods
	 * are inherited by the service-specific classes.
	 */

	// Custom class to extend CFUtilities
	class TestUtilities extends CFUtilities
	{
		public function test_method()
		{
			return true;
		}
	}

	// Instantiate class and set new class
	$f = new CloudFusion();
	$f->set_utilities_class('TestUtilities');

	// Test if the value was set
	var_dump($f->util->test_method());
?>

--EXPECT--
bool(true)
