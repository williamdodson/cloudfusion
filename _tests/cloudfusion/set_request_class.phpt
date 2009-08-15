--TEST--
CloudFusion - set_request_class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Custom class to extend RequestCore
	class TestRequestCore extends RequestCore
	{
		public function test_method()
		{
			return true;
		}
	}

	// Instantiate class and set new class
	$f = new CloudFusion();
	$f->set_request_class('TestRequestCore');
	var_dump($f->request_class);
?>

--EXPECT--
string(15) "TestRequestCore"
