--TEST--
CloudFusion - Instantiate

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';

	$f = new CloudFusion('test_key', 'test_secret_key', 'test_account_id', 'test_assoc_id');

	var_dump($f->key);
	var_dump($f->secret_key);
	var_dump($f->account_id);
	var_dump($f->assoc_id);
?>

--EXPECT--
string(8) "test_key"
string(15) "test_secret_key"
string(15) "test_account_id"
string(13) "test_assoc_id"
