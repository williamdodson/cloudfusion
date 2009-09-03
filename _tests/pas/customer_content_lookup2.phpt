--TEST--
AmazonPAS::customer_content_lookup with ResponseGroup

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Look up the user
	$pas = new AmazonPAS();
	$response = $pas->customer_content_lookup('A1ESH8CKZLUV25', array(
		'ResponseGroup' => 'CustomerFull'
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
