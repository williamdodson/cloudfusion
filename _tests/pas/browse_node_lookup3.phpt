--TEST--
AmazonPAS::browse_node_lookup with ResponseGroup and returnCurlHandle

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Browse a node
	$pas = new AmazonPAS();
	$response = $pas->browse_node_lookup('173429', array(
		'ResponseGroup' => 'TopSellers',
		'returnCurlHandle' => true
	));

	// Success?
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
