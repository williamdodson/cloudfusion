--TEST--
AmazonPAS::tag_lookup with large response group

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Search for similar items
	$pas = new AmazonPAS();
	$response = $pas->tag_lookup('skillet', array(
		'ResponseGroup' => 'Large'
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
