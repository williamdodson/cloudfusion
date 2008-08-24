<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonSDB object using the settings from the config.inc.php file.
 */
$sdb = new AmazonSDB();


/**
 * Query SimpleDB for items containing data. Returns all matches up to 250 items. A 
 * separate request is required to return back the full data for the items returned 
 * in this query. (See below for more info.)
 */
$query = $sdb->query('warpshare_test', array(
	'MaxNumberOfItems' => 250
));


/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($query);
echo '</pre>';


/*========================================================*/


/**
 * Same as above, but we're using a complex SimpleDB expression to pull back specific items. 
 * (Added linebreaks for readability.)
 */
$query = $sdb->$query('warpshare_test', 
	array(
		'MaxNumberOfItems' => 250
	), 
	"['Year' >= '1900' and 'Year' < '2000'] intersection ['Keyword' = 'Book'] intersection ['Rating' starts-with '4' or 'Rating' = '****'] union ['Title' = '300'] union ['Author' = 'Paul Van Dyk']"
);


/**
 * Same as above, but we're using a complex SimpleDB expression to pull back specific items, 
 * and then request those items all at once so that query responses also contain the 
 * data for the relevant items. (Added linebreaks for readability.)
 */
$query = $sdb->$query('warpshare_test', 
	array(
		'MaxNumberOfItems' => 250
	), 
	"['Year' >= '1900' and 'Year' < '2000'] intersection ['Keyword' = 'Book'] intersection ['Rating' starts-with '4' or 'Rating' = '****'] union ['Title' = '300'] union ['Author' = 'Paul Van Dyk']", 
	true
);


/**
 * We're NOT using a SimpleDB expression, but we are requesting the data for the resulting 
 * items all at once. 
 */
$query = $sdb->$query('warpshare_test', array(
	'MaxNumberOfItems' => 250
), null, true);


?>