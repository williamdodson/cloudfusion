--TEST--
AmazonSQS::delete_message

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Delete a message we've read
	$sqs = new AmazonSQS();
	$response = $sqs->delete_message(SQS_DEFAULT_URL . '/warpshare-unit-test',
		file_get_contents('receipt_handle.cache') // See receive_message() example for why we're doing this.
	);

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)

--CLEAN--
<?php
	unlink('receipt_handle.cache');
?>
