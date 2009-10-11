--TEST--
AmazonSDB::cache_response CachePDO:SQLite

--FILE--
<?php
	// Dependencies
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	// Instantiate
	$s3 = new AmazonS3();

	// First time pulls live data
	$response = $s3->cache_response('get_object_url', 'pdo.sqlite:' . dirname(dirname(__FILE__)) . '/_cache/sqlite.db', 10, array('tarzan.demo', 'macgyver_gets_lazy.png', 3600));
	var_dump($response);

	// Second time pulls from cache
	$response = $s3->cache_response('get_object_url', 'pdo.sqlite:' . dirname(dirname(__FILE__)) . '/_cache/sqlite.db', 10, array('tarzan.demo', 'macgyver_gets_lazy.png', 3600));
	var_dump($response);
?>

--EXPECTF--
string(%d) "http://tarzan.demo.s3.amazonaws.com/macgyver_gets_lazy.png?%s"
string(%d) "http://tarzan.demo.s3.amazonaws.com/macgyver_gets_lazy.png?%s"
