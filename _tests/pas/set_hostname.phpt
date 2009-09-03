--TEST--
AmazonPAS::set_hostname

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Browse a node
	$pas = new AmazonPAS();
	$pas->set_hostname('ecs.amazonaws.com');
	$response = $pas->item_lookup('B002FZL94O');

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
