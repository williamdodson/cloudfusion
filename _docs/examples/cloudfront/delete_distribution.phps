<?php
require_once('cloudfusion.class.php');

/**
 * Instantiate a new AmazonCloudFront object using the settings from the config.inc.php file.
 */
$cf = new AmazonCloudFront();


/**
 * Delete a distribution.
 */

// Fetch the information about a specific distribution.
$info = $cf->get_distribution_info($distribution_id);

// Delete the distribution by passing in the distribution ID and the ETag value we obtained from $info.
$delete = $cf->delete_distribution($distribution_id, $info->header['etag']);

// View the output object
print_r($delete);

?>