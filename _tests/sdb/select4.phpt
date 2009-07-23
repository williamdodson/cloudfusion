--TEST--
AmazonSDB::select returnCurlHandle

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	$response = $sdb->select('SELECT * FROM `warpshare-unit-test`', array(
		'returnCurlHandle' => true
	));
	var_dump($response);
?>

--EXPECT--
resource(9) of type (curl)
