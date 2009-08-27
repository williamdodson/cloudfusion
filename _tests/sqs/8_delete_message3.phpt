--TEST--
AmazonSQS::delete_message (EU)

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a message we've read
	$sqs = new AmazonSQS();
	$sqs->set_locale(SQS_LOCATION_EU);
	$response = $sqs->delete_message('warpshare-unit-test',
		file_get_contents('receipt_handle_eu.cache') // See receive_message() example for why we're doing this.
	);

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)

--CLEAN--
<?php
	unlink('receipt_handle_eu.cache');
?>
