<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonSDB object using the settings from the config.inc.php file.
 */
$sdb = new AmazonSDB();


/**
 * Add some key-value pairs to a SimpleDB item in a SimpleDB domain. Each "domain" 
 * can have several "items", when then contain several key-value pairs ("attributes"). 
 * You can set up to 100 key-value pairs at a time via the standard SimpleDB web 
 * service API.
 */
$put = $sdb->put_attributes('warpshare_test', 'user_data', array(
	'name' => 'Ryan Parman',
	'email' => 'ryan.lists.warpshare@gmail.com',
	'url' => 'http://warpshare.com',
	'gravatar' => 'http://en.gravatar.com/avatar/066da34008adb924c115df7a39779d8d?s=80&r=any',
	'openid' => 'http://ryanparman.com'
));


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($put);
echo '</pre>';


/*========================================================*/


/**
 * An example of assigning multiple values to a single key.
 */
$put = $sdb->put_attributes('warpshare_test', 'user_data', array(
	'name' => 'Ryan Parman',
	'email' => 'ryan.lists.warpshare@gmail.com',
	'url' => 'http://warpshare.com',
	'gravatar' => 'http://en.gravatar.com/avatar/066da34008adb924c115df7a39779d8d?s=80&r=any',
	'openid' => 'http://ryanparman.com',
	'tags' => array(
		'awesome',
		'cool',
		'fantastic',
		'wonderful',
		'he who you wish you were like'
	)
));


?>