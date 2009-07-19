<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonAAWS object using the settings from the config.inc.php file.
 */
$aaws = new AmazonAAWS();


/**
 * Create a new shopping cart with one quantity of a single item.
 * Just pass in the OfferListingId by itself.
 */
$aaws = $ec2->create_cart('cMVuIFx8kiYSgRIJXiCzKZZyylwztVSAYV8vCo2OxHS8L9SB7lwho8fK6CxYkmdDPy8thFzm30Y%3D');


/**
 * Create a new shopping cart with a quantity of two or more for a single item.
 * Just pass in an associative array with the OfferListingId as the key and the quantity as the value.
 */
$aaws = $ec2->create_cart(array(
	'cMVuIFx8kiYSgRIJXiCzKZZyylwztVSAYV8vCo2OxHS8L9SB7lwho8fK6CxYkmdDPy8thFzm30Y%3D' => 3
));


/**
 * Create a new shopping cart with a quantity of one or more for multiple items.
 * Just pass in an associative array with the OfferListingId as the key and the quantity as the value.
 * You can pass in more than one key-value pair.
 */
$aaws = $ec2->create_cart(array(
	'cMVuIFx8kiYSgRIJXiCzKZZyylwztVSAYV8vCo2OxHS8L9SB7lwho8fK6CxYkmdDPy8thFzm30Y%3D' => 3,
	'lwztVSAYV8vCo2OxHS8L9SB7lwho8fK6CxYkmdDPy8thFzm30Y%3DcMVuIFx8kiYSgRIJXiCzKZZyy' => 6,
	'who8fK6CxYkmdDPy8thFzm30Y%3DcMVuIFx8kiYSgRIJXiCzKZZyylwztVSAYV8vCo2OxHS8L9SB7l' => 18,
	'yylwztVSAYV8vCo2OxHS8L9SB7lwho8fKcMVuIFx8kiYSgRIJXiCzKZZ6CxYkmdDPy8thFzm30Y%3D' => 1
));



/**
 * Look at the response to navigate through the headers and body of the response.
 * Note that this is an object, not an array, and that the body is a SimpleXML object.
 * 
 * http://php.net/manual/en/simplexml.examples.php
 */
echo '<pre>';
print_r($cart);
echo '</pre>';


?>