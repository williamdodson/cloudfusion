--TEST--
CloudFusion - DATE_FORMAT_MYSQL

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(date(DATE_FORMAT_MYSQL, strtotime('1 January 2009')));
?>

--EXPECT--
string(19) "2009-01-01 00:00:00"
