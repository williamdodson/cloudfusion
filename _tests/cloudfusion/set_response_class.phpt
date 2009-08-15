--TEST--
CloudFusion - set_response_class

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

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
	var_dump($f->response_class);
?>

--EXPECT--
string(16) "TestResponseCore"
