--TEST--
CloudFusion - set_utilities_class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

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
	var_dump($f->util->test_method());
?>

--EXPECT--
bool(true)
