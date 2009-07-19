<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonSDB object using the settings from the config.inc.php file.
 */
$sdb = new AmazonSDB();


/**
 * Delete all of the "attribute" key-value pairs for this particular domain-item, 
 * thereby deleting the item itself as well.
 */
$delete = $sdb->delete_attributes('warpshare_test', 'user_data');


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($delete);
echo '</pre>';


/*========================================================*/


/**
 * Delete only the value for the "name" key.
 */
$delete = $sdb->delete_attributes('warpshare_test', 'user_data', 'name');


/**
 * Delete the values for the "name", "email", and "openid" keys.
 */
$delete = $sdb->delete_attributes('warpshare_test', 'user_data', array(
	'name', 
	'email', 
	'openid'
));


?>