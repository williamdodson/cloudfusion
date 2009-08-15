--TEST--
CloudFusion - DATE_FORMAT_ISO8601

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(date(DATE_FORMAT_ISO8601, strtotime('1 January 2009')));
?>

--EXPECT--
string(20) "2009-01-01T00:00:00Z"
