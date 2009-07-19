<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate ANY Amazon class. In this example, we'll use AmazonAAWS.
 */
$aaws = new AmazonAAWS();


/**
 * "Try These" will look at a variety of values in order and return the first one that 
 * exists or isn't null. This is particularly useful when used with AAWS as the data 
 * isn't always as consistent as you might like (prices, images, availability, etc.).
 */

// Look up an item by its ASIN.
$item = $aaws->item_lookup('B000I0QJI4', array(
	'ResponseGroup' => 'Medium'
));


// Return the first image size that exists. Because it always returns the first match, 
// we want to put them in order of preference.
if ($artwork = $aaws->util->try_these(array('MediumImage', 'LargeImage', 'SmallImage'), $item->body->Items->Item))
{
	echo '<img src="' . $artwork->URL . '">';
}
else
{
	echo '<img src="/assets/images/does_not_exist.png">';
}

?>