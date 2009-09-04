--TEST--
AmazonPAS::set_locale

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Set a locale and trigger an operation
	// Japan should be prioritized over UK.
	$pas = new AmazonPAS();
	$pas->set_locale(PAS_LOCALE_JAPAN);
	$response = $pas->item_lookup('B002FZL94O', PAS_LOCALE_UK);

	if ($response->isOK())
	{
		// Determine the hostname for the request
		$request_url = parse_url($response->header['_info']['url'], PHP_URL_HOST);

		// Success?
		var_dump($request_url);
	}
?>

--EXPECT--
string(16) "ecs.amazonaws.jp"
