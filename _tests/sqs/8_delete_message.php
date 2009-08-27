<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a message we've read
	$sqs = new AmazonSQS();
	$response = $sqs->delete_message('warpshare-unit-test',
		file_get_contents('receipt_handle_eu.cache') // See receive_message() example for why we're doing this.
	);

	// Success?
	var_dump($response->isOK());
?>

