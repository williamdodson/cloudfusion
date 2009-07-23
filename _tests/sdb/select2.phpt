--TEST--
AmazonSDB::select NextToken

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$sdb = new AmazonSDB();
	$response = $sdb->select('SELECT * FROM `warpshare-unit-test`', array(
		'NextToken' => 't'
	));
	var_dump($response->body->Errors->Error->Code);
?>

--EXPECT--
object(SimpleXMLElement)#6 (1) {
  [0]=>
  string(16) "InvalidNextToken"
}