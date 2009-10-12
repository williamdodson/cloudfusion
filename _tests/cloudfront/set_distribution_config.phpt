--TEST--
CloudFront: set_distribution_config()

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Retrieve the cached Distribution ID. See create_distribution() for why we're doing this.
	$distribution_id = file_get_contents('create_distribution.cache');

	$cdn = new AmazonCloudFront();

	// Pull existing config XML...
	$existing_xml = $cdn->get_distribution_config($distribution_id);

	// Generate an updated XML config...
	$updated_xml = $cdn->update_config_xml($existing_xml, array(
		'Enabled' => false
	));

	// If we *just* created a new distribution, sleep for ~3 minutes to allow the "eventual consistency" to catch up.
	sleep(180);

	// Fetch an updated ETag value
	$etag = $cdn->get_distribution_config($distribution_id)->header['etag'];

	// Set the updated config XML to the distribution.
	$response = $cdn->set_distribution_config($distribution_id, $updated_xml, $etag);

	// Success?
	var_dump($response->isOK());
?>

--EXPECT--
bool(true)
