<?php
require_once('tarzan.class.php');

/**
 * Instantiate a new AmazonEC2 object using the settings from the config.inc.php file.
 */
$ec2 = new AmazonEC2();


/**
 * Explicitly set the location to the U.S.
 */
$ec2->set_locale(EC2_LOCATION_US);


/**
 * Describe ALL availability zones.
 */
$describe = $ec2->describe_availability_zones();

print_r($describe);

?>