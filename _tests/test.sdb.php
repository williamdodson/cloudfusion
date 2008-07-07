<?php
/**
 * SDB UNIT TESTS
 * Provides automated testing of functionality.
 *
 * @category Tarzan
 * @package UnitTests
 * @subpackage SDB
 * @version 2008.07.07
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.googlecode.com Tarzan
 * @link http://sdb.amazonaws.com Amazon SDB
 * @see README
 */


/*%******************************************************************************************%*/
// PREPARATION

require_once(dirname(dirname(__FILE__)) . '/tarzan.class.php');
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL);


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
	if ((int) $obj->status == 200)
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

// Save the domain name.
$dname = 'tarzan-test';
$iname = 'tarzan-test-item';

// Instantiate new AmazonSDB object.
$sdb = new AmazonSDB();

// Create a new domain
$create_domain = $sdb->create_domain($dname);

sleep(10);

// List the available domains
$list_domains = $sdb->list_domains();

// Add an attribute
$put_attributes = $sdb->put_attributes($dname, $iname, array(
	'adam' => 'eve',
	'benny' => 'joon',
	'bonnie' => 'clyde'
), true);

sleep(10);

// Query SDB
$query = $sdb->query($dname);

// Get the attributes
$get_attributes = $sdb->get_attributes($dname, $query->body->QueryResult->ItemName);

// Delete attributes
$delete_attributes = $sdb->delete_attributes($dname, $query->body->QueryResult->ItemName);

// Delete the domain
$delete_domain = $sdb->delete_domain($dname);


/*%******************************************************************************************%*/
// OUTPUT RESULTS

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">

<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>test.sdb</title>
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen">
	</head>

	<body>
		<div id="page">
		<?php
		echo '<h1>Unit Test: ' . $sdb->service . ' (' . $sdb->api_version . ')</h1>';
		?>

		<table class="chart">
			<tbody>
				<?php get_result($create_domain); ?>
				<td><a href="#create_domain">Create Domain</a></td></tr>

				<?php get_result($list_domains); ?>
				<td><a href="#list_domains">List Domains</a></td></tr>

				<?php get_result($put_attributes); ?>
				<td><a href="#put_attributes">Put Attributes</a></td></tr>

				<?php get_result($query); ?>
				<td><a href="#query">Query</a></td></tr>

				<?php get_result($get_attributes); ?>
				<td><a href="#get_attributes">Get Attributes</a></td></tr>

				<?php get_result($delete_attributes); ?>
				<td><a href="#delete_attributes">Delete Attributes</a></td></tr>

				<?php get_result($delete_domain); ?>
				<td><a href="#delete_domain">Delete Domain</a></td></tr>

			</tbody>
		</table>

		<?php
		echo '<h2><a name="create_domain">Create Domain</a></h2>';
		echo '<pre>'; print_r($create_domain); echo '</pre>';

		echo '<h2><a name="list_domains">List Domains</a></h2>';
		echo '<pre>'; print_r($list_domains); echo '</pre>';
		?>
			<div class="indent">
			<?php
			echo '<h2><a name="put_attributes">Put Attributes</a></h2>';
			echo '<pre>'; print_r($put_attributes); echo '</pre>';

			echo '<h2><a name="query">Query</a></h2>';
			echo '<pre>'; print_r($query); echo '</pre>';
			
			echo '<h2><a name="get_attributes">Get Attributes</a></h2>';
			echo '<pre>'; print_r($get_attributes); echo '</pre>';
			
			echo '<h2><a name="delete_attributes">Delete Attributes</a></h2>';
			echo '<pre>'; print_r($delete_attributes); echo '</pre>';
			?>
			</div>
		<?php
		echo '<h2><a name="delete_domain">Delete Domain</a></h2>';
		echo '<pre>'; print_r($delete_domain); echo '</pre>';
		?>
		</div>
	</body>
</html>
