<?php
/**
 * EC2 UNIT TESTS
 * Provides automated testing of functionality.
 *
 * @category Tarzan
 * @package UnitTests
 * @subpackage EC2
 * @version 2008.04.12
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.googlecode.com Tarzan
 * @link http://ec2.amazonaws.com Amazon EC2
 * @see README
 */


/*%******************************************************************************************%*/
// PREPARATION

require_once(dirname(dirname(__FILE__)) . '/tarzan.class.php');
header('Content-type: text/html; charset=utf-8');
error_reporting(0);


/*%******************************************************************************************%*/
// TEST FUNCTIONS

/**
 * Get Result
 * 
 * @param TarzanHTTPResponse $obj (Required) The response object from the function call to test.
 * @return void
 */
function get_result($obj)
{
	if ((int) $obj->header['x-amz-httpstatus'] == 200)
	{
		echo '<tr class="pass"><td class="status">&#10004;</td>';
	}
	else
	{
		echo '<tr class="fail"><td class="status">&#10008;</td>';
	}
}


/*%******************************************************************************************%*/
// RUN THE TESTS

// Instantiate new AmazonEC2 object.
$ec2 = new AmazonEC2();

// Describe availability zones
$describe_availability_zones = $ec2->describe_availability_zones();

// Describe available images
$describe_images = $ec2->describe_images();

// Describe image attribute
$describe_image_attribute = $ec2->describe_image_attribute();

// Describe instances
$describe_instances = $ec2->describe_instances();

// Describe key pairs
$describe_key_pairs = $ec2->describe_key_pairs();


/*%******************************************************************************************%*/
// OUTPUT RESULTS

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">

<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>test.ec2</title>
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen">
	</head>

	<body>
		<div id="page">
		<?php
		echo '<h1>Unit Test: ' . $ec2->service . ' (' . $ec2->api_version . ')</h1>';
		?>

		<h2>Active Tests</h2>
		<table class="chart">
			<tbody>
				<?php get_result($describe_availability_zones); ?>
				<td><a href="#describe_availability_zones">Describe Availability Zones</a></td></tr>

				<?php get_result($describe_images); ?>
				<td><a href="#describe_images">Describe Images</a></td></tr>

				<?php get_result($describe_image_attribute); ?>
				<td><a href="#describe_image_attribute">Describe Image Attribute</a></td></tr>

				<?php get_result($describe_instances); ?>
				<td><a href="#describe_instances">Describe Instances</a></td></tr>

				<?php get_result($describe_key_pairs); ?>
				<td><a href="#describe_key_pairs">Describe Key Pairs</a></td></tr>

			</tbody>
		</table>

		<h2>To-Be-Written Tests</h2>
		<table class="chart">
			<tbody>
				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#allocate_address">Allocate Address</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#associate_address">Associate Address</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#describe_addresses">Describe Addresses</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#disassociate_address">Disassociate Address</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#release_address">Release Address</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#deregister_image">Deregister Image</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#register_image">Register Image</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#modify_image_attribute">Modify Image Attribute</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#reset_image_attribute">Reset Image Attribute</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#confirm_product_instance">Confirm Product Instance</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#run_instances">Run Instances</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#terminate_instances">Terminate Instances</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#create_key_pair">Create Key Pair</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#delete_key_pair">Delete Key Pair</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#authorize_security_group_ingress">Authorize Security Group Ingress</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#create_security_group">Create Security Group</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#delete_security_group">Delete Security Group</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#describe_security_groups">Describe Security Groups</a></td></tr>

				<tr class="notest"><td class="status">&ndash;</td>
				<td><a href="#revoke_security_group_ingress">Revoke Security Group Ingress</a></td></tr>
			</tbody>
		</table>

		<?php
		echo '<h2><a name="describe_availability_zones">Describe Availability Zones</a></h2>';
		echo '<pre>'; print_r($describe_availability_zones); echo '</pre>';

		echo '<h2><a name="describe_images">Describe Images</a></h2>';
		echo '<pre>'; print_r($describe_images); echo '</pre>';

		echo '<h2><a name="describe_images">Describe Image Attribute</a></h2>';
		echo '<pre>'; print_r($describe_image_attribute); echo '</pre>';

		echo '<h2><a name="describe_instances">Describe Instances</a></h2>';
		echo '<pre>'; print_r($describe_instances); echo '</pre>';

		echo '<h2><a name="describe_key_pairs">Describe Key Pairs</a></h2>';
		echo '<pre>'; print_r($describe_key_pairs); echo '</pre>';

		?>
		</div>
	</body>
</html>
