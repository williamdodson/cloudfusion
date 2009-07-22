--TEST--
AmazonSDB::list_domains

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();

	// First time pulls live data
	$response = $sdb->list_domains();
	var_dump($response->status);
?>

--EXPECT--
int(200)
