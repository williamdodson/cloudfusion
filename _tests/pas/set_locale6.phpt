--TEST--
AmazonPAS::set_locale

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Set a locale and trigger an operation
	$pas = new AmazonPAS();
	$response = $pas->item_lookup('B002FZL94O', null, PAS_LOCALE_JAPAN);

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
