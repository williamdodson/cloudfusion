--TEST--
CFUtilities - Object type

--FILE--
<?php
	require_once dirname(__FILE__) . '/../../cloudfusion.class.php';
	$util = new CFUtilities();
	var_dump(get_class($util));
?>

--EXPECT--
string(11) "CFUtilities"
