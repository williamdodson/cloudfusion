--TEST--
AmazonPAS::item_lookup with ResponseGroup

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Browse a node
	$pas = new AmazonPAS();
	$response = $pas->item_lookup('B002FZL94O', array(
		'ResponseGroup' => 'Large'
	));

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
