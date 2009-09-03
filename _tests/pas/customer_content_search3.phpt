--TEST--
AmazonPAS::customer_content_search with ResponseGroup

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Browse a node
	$pas = new AmazonPAS();
	$response = $pas->customer_content_search('Ryan Parman', array(
		'ResponseGroup' => 'CustomerInfo'
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
