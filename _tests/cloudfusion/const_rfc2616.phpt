--TEST--
CloudFusion - DATE_FORMAT_RFC2616

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$f = new CloudFusion();
	var_dump(date(DATE_FORMAT_RFC2616, strtotime('1 January 2009')));
?>

--EXPECT--
string(29) "Thu, 01 Jan 2009 00:00:00 GMT"
