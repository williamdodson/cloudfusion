<?php
/**
 * S3 UNIT TESTS
 * Provides automated testing of functionality.
 *
 * @category Tarzan
 * @package UnitTests
 * @subpackage S3
 * @version 2008.07.05
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.googlecode.com Tarzan
 * @link http://s3.amazonaws.com Amazon S3
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
	if (is_bool($obj))
	{
		$result = $obj;
	}
	else
	{
		$result = $obj->isOK(array(200, 204));
	}

	if ($result)
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

// Instantiate new AmazonS3 object.
$s3 = new AmazonS3();

/**
 * Test the U.S. connection.
 */

// The re-usable names of stuff.
$bname = 'tarzan-test-us-' . strtolower($s3->key);
$fname = 'test.txt';

// Create a new bucket
$bucket = $s3->create_bucket($bname, S3_LOCATION_US);

// Get the locale of the bucket we just created
$locale = $s3->get_bucket_locale($bname);

// Get a list of all buckets on the account.
$list_buckets = $s3->list_buckets();

// ONLY lists the bucket names on the account.
$get_bucket_list = $s3->get_bucket_list();

// HEAD bucket
$head_bucket = $s3->head_bucket($bname);

// If bucket exists
$if_bucket_exists = $s3->if_bucket_exists($bname);

// Create a new readable test file.
$file = $s3->create_object($bname, array(
	'filename' => $fname,
	'body' => 'Hello world!',
	'contentType' => 'text/plain',
	'acl' => S3_ACL_PUBLIC
));

// Store a remote file.
$store_remote_file = $s3->store_remote_file('http://code.google.com/p/tarzan-aws/', $bname, '2'.$fname);

// Copy/Duplicate a file.
$copy_object = $s3->duplicate_object($bname, $fname, 'duplicate_of_' . $fname);

// Move/Rename a file.
$move_object = $s3->rename_object($bname, 'duplicate_of_' . $fname, 'renamed_duplicate_of_' . $fname);

// List the objects in the bucket.
$list = $s3->list_objects($bname);

// ONLY lists the object filenames in the bucket.
$get_object_list = $s3->get_object_list($bname);

// Get the number of items in the bucket
$get_bucket_size = $s3->get_bucket_size($bname);

// Get the filesize of the bucket
$get_bucket_filesize = $s3->get_bucket_filesize($bname);

// Get the headers for a file without downloading the entire file.
$head = $s3->head_object($bname, $fname);

// If Object Exists
$if_object_exists = $s3->if_object_exists($bname, $fname);

// Get the file.
$get = $s3->get_object($bname, $fname);

// Get the file publicly, without Amazon. Tests ACL settings.
$get_public = new TarzanHTTPRequest($get->header['x-tarzan-requesturl']);
$get_public->sendRequest();
$get_public = new TarzanHTTPResponse($get_public->getResponseHeader(), null, $get_public->getResponseCode());

// Delete the file.
$delf = $s3->delete_object($bname, $fname);

// Delete ALL Files
$delete_all_objects = $s3->delete_all_objects($bname);

// Delete the bucket.
$delb = $s3->delete_bucket($bname);


/**
 * Test the E.U. connection.
 */

// The re-usable names of stuff.
$bname_eu = 'tarzan-test-eu-' . strtolower($s3->key);
$fname_eu = 'test-eu.txt';

// Create a new bucket
$bucket_eu = $s3->create_bucket($bname_eu, S3_LOCATION_EU);

// Get the locale of the bucket we just created
$locale_eu = $s3->get_bucket_locale($bname_eu);

// Create a new readable test file.
$file_eu = $s3->create_object($bname_eu, array(
	'filename' => $fname_eu,
	'body' => 'Hello world!',
	'contentType' => 'text/plain',
	'acl' => S3_ACL_PUBLIC
));

// List the objects in the bucket.
$list_eu = $s3->list_objects($bname_eu);

// Get the headers for a file without downloading the entire file.
$head_eu = $s3->head_object($bname_eu, $fname_eu);
//$head = new TarzanHTTPResponse(array('x-tarzan-httpstatus' => '0'), '');

// Get the file.
$get_eu = $s3->get_object($bname_eu, $fname_eu);

// Delete the file.
$delf_eu = $s3->delete_object($bname_eu, $fname_eu);

// Delete the bucket.
$delb_eu = $s3->delete_bucket($bname_eu);


/*%******************************************************************************************%*/
// OUTPUT RESULTS

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">

<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>test.s3</title>
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen">
	</head>

	<body>
		<div id="page">
		<?php
		echo '<h1>Unit Test: ' . $s3->service . ' (' . $s3->api_version . ')</h1>';
		?>

		<h2>United States</h2>
		<table class="chart">
			<tbody>
				<?php get_result($bucket); ?>
				<td><a href="#create_bucket">Create Bucket (US)</a></td></tr>

				<?php get_result($locale); ?>
				<td><a href="#get_bucket_locale">Get Bucket Locale (US)</a></td></tr>

				<?php get_result($list_buckets); ?>
				<td><a href="#list_buckets">List Buckets (US)</a></td></tr>

				<?php
				if ($get_bucket_list)
				{
					echo '<tr class="pass"><td class="status">&#10004;</td>';
				}
				else
				{
					echo '<tr class="fail"><td class="status">&#10008;</td>';
				}
				?>
				<td><a href="#get_bucket_list">Get Bucket List (US)</a></td></tr>

				<?php get_result($head_bucket); ?>
				<td><a href="#head_bucket">HEAD Bucket (US)</a></td></tr>

				<?php
				if ($if_bucket_exists)
				{
					echo '<tr class="pass"><td class="status">&#10004;</td>';
				}
				else
				{
					echo '<tr class="fail"><td class="status">&#10008;</td>';
				}
				?>
				<td><a href="#if_bucket_exists">If Bucket Exists (US)</a></td></tr>

				<?php get_result($file); ?>
				<td><a href="#create_object">Create Object (US)</a></td></tr>

				<?php
				if ($store_remote_file)
				{
					echo '<tr class="pass"><td class="status">&#10004;</td>';
				}
				else
				{
					echo '<tr class="fail"><td class="status">&#10008;</td>';
				}
				?>
				<td><a href="#store_remote_file">Store Remote File (US)</a></td></tr>

				<?php get_result($copy_object); ?>
				<td><a href="#copy_object">Copy/Duplicate Object (US)</a></td></tr>

				<?php get_result($move_object); ?>
				<td><a href="#move_object">Move/Rename Object (US)</a></td></tr>

				<?php get_result($list); ?>
				<td><a href="#change_object_acl">List Objects (Get Bucket) (US)</a></td></tr>

				<?php
				if ($get_object_list)
				{
					echo '<tr class="pass"><td class="status">&#10004;</td>';
				}
				else
				{
					echo '<tr class="fail"><td class="status">&#10008;</td>';
				}
				?>
				<td><a href="#get_object_list">Get Object List (US)</a></td></tr>

				<?php
				if ($get_bucket_size)
				{
					echo '<tr class="pass"><td class="status">&#10004;</td>';
				}
				else
				{
					echo '<tr class="fail"><td class="status">&#10008;</td>';
				}
				?>
				<td><a href="#get_bucket_size">Get Bucket Size (US)</a></td></tr>

				<?php
				if ($get_bucket_filesize)
				{
					echo '<tr class="pass"><td class="status">&#10004;</td>';
				}
				else
				{
					echo '<tr class="fail"><td class="status">&#10008;</td>';
				}
				?>
				<td><a href="#get_bucket_filesize">Get Bucket Filesize (US)</a></td></tr>

				<?php get_result($head); ?>
				<td><a href="#head_object">HEAD Object (US)</a></td></tr>

				<?php
				if ($if_bucket_exists)
				{
					echo '<tr class="pass"><td class="status">&#10004;</td>';
				}
				else
				{
					echo '<tr class="fail"><td class="status">&#10008;</td>';
				}
				?>
				<td><a href="#if_bucket_exists">If Bucket Exists (US)</a></td></tr>

				<?php get_result($get); ?>
				<td><a href="#get_object">Get Object (US)</a></td></tr>

				<?php get_result($get_public); ?>
				<td><a href="#get_public">Fetch the file without S3 to test ACL support (US)</a></td></tr>

				<?php get_result($delf); ?>
				<td><a href="#delete_object">Delete Object (US)</a></td></tr>

				<?php
				if ($delete_all_objects)
				{
					echo '<tr class="pass"><td class="status">&#10004;</td>';
				}
				else
				{
					echo '<tr class="fail"><td class="status">&#10008;</td>';
				}
				?>
				<td><a href="#delete_all_objects">Delete ALL Objects (US)</a></td></tr>

				<?php get_result($delb); ?>
				<td><a href="#delete_bucket">Delete Bucket (US)</a></td></tr>
			</tbody>
		</table>

		<h2>European Union</h2>
		<table class="chart">
			<tbody>
				<?php get_result($bucket_eu); ?>
				<td><a href="#create_bucket_eu">Create Bucket (EU)</a></td></tr>

				<?php get_result($locale_eu); ?>
				<td><a href="#get_bucket_locale_eu">Get Bucket Locale (EU)</a></td></tr>

				<?php get_result($file_eu); ?>
				<td><a href="#create_object_eu">Create Object (EU)</a></td></tr>

				<?php get_result($list_eu); ?>
				<td><a href="#list_objects_eu">List Objects (Get Bucket) (EU)</a></td></tr>

				<?php get_result($head_eu); ?>
				<td><a href="#head_object_eu">HEAD Object (EU)</a></td></tr>

				<?php get_result($get_eu); ?>
				<td><a href="#get_object_eu">Get Object (EU)</a></td></tr>

				<?php get_result($delf_eu); ?>
				<td><a href="#delete_object_eu">Delete Object (EU)</a></td></tr>

				<?php get_result($delb_eu); ?>
				<td><a href="#delete_bucket_eu">Delete Bucket (EU)</a></td></tr>
			</tbody>
		</table>

		<?php
		echo '<h2><a name="create_bucket">Create Bucket (US)</a></h2>';
		echo '<pre>'; print_r($bucket); echo '</pre>';

		echo '<h2><a name="get_bucket_locale">Get Bucket Locale (US)</a></h2>';
		echo '<pre>'; print_r($locale); echo '</pre>';

		echo '<h2><a name="list_buckets">List Buckets (US)</a></h2>';
		echo '<pre>'; print_r($list_buckets); echo '</pre>';

		echo '<h2><a name="get_bucket_list">Get Bucket List (US)</a></h2>';
		echo '<pre>'; print_r($get_bucket_list); echo '</pre>';

		echo '<h2><a name="head_bucket">HEAD Bucket (US)</a></h2>';
		echo '<pre>'; print_r($head_bucket); echo '</pre>';

		echo '<h2><a name="if_bucket_exists">If Bucket Exists (US)</a></h2>';
		echo '<pre>'; print_r($if_bucket_exists ? 'true' : 'false'); echo '</pre>';
		?>
			<div class="indent">
			<?php
			echo '<h2><a name="create_object">Create Object (US)</a></h2>';
			echo '<pre>'; print_r($file); echo '</pre>';

			echo '<h2><a name="store_remote_file">Store Remote File (US)</a></h2>';
			echo '<pre>'; print_r($store_remote_file); echo '</pre>';

			echo '<h2><a name="copy_object">Copy/Duplicate Object (US)</a></h2>';
			echo '<pre>'; print_r($copy_object); echo '</pre>';

			echo '<h2><a name="move_object">Move/Rename Object (US)</a></h2>';
			echo '<pre>'; print_r($move_object); echo '</pre>';

			echo '<h2><a name="list_objects">List Objects (Get Bucket) (US)</a></h2>';
			echo '<pre>'; print_r($list); echo '</pre>';

			echo '<h2><a name="get_object_list">Get Object List (US)</a></h2>';
			echo '<pre>'; print_r($get_object_list); echo '</pre>';

			echo '<h2><a name="get_bucket_size">Get Bucket Size (US)</a></h2>';
			echo '<pre>'; print_r($get_bucket_size); echo '</pre>';

			echo '<h2><a name="get_bucket_filesize">Get Bucket Filesize (US)</a></h2>';
			echo '<pre>'; print_r($get_bucket_filesize); echo '</pre>';

			echo '<h2><a name="head_object">HEAD Object (US)</a></h2>';
			echo '<pre>'; print_r($head); echo '</pre>';

			echo '<h2><a name="if_object_exists">If Object Exists (US)</a></h2>';
			echo '<pre>'; print_r($if_object_exists ? 'true' : 'false'); echo '</pre>';

			echo '<h2><a name="get_object">Get Object (US)</a></h2>';
			echo '<pre>'; print_r($get); echo '</pre>';

			echo '<h2><a name="get_public">Fetch the file without S3 to test ACL support (US)</a></h2>';
			echo '<pre>'; print_r($get_public->header); echo '</pre>';

			echo '<h2><a name="delete_object">Delete Object (US)</a></h2>';
			echo '<pre>'; print_r($delf); echo '</pre>';

			echo '<h2><a name="delete_all_objects">Delete ALL Objects (US)</a></h2>';
			echo '<pre>'; print_r($delete_all_objects ? 'true' : 'false'); echo '</pre>';
			?>
			</div>
		<?php
		echo '<h2><a name="delete_bucket">Delete Bucket (US)</a></h2>';
		echo '<pre>'; print_r($delb); echo '</pre>';
		?>



		<?php
		echo '<h2><a name="create_bucket_eu">Create Bucket (EU)</a></h2>';
		echo '<pre>'; print_r($bucket_eu); echo '</pre>';

		echo '<h2><a name="get_bucket_locale_eu">Get Bucket Locale (EU)</a></h2>';
		echo '<pre>'; print_r($locale_eu); echo '</pre>';
		?>
			<div class="indent">
			<?php
			echo '<h2><a name="create_object_eu">Create Object (EU)</a></h2>';
			echo '<pre>'; print_r($file_eu); echo '</pre>';

			echo '<h2><a name="list_objects_eu">List Objects (Get Bucket) (EU)</a></h2>';
			echo '<pre>'; print_r($list_eu); echo '</pre>';

			echo '<h2><a name="head_object_eu">HEAD Object (EU)</a></h2>';
			echo '<pre>'; print_r($head_eu); echo '</pre>';

			echo '<h2><a name="get_object_eu">Get Object (EU)</a></h2>';
			echo '<pre>'; print_r($get_eu); echo '</pre>';

			echo '<h2><a name="delete_object_eu">Delete Object (EU)</a></h2>';
			echo '<pre>'; print_r($delf_eu); echo '</pre>';
			?>
			</div>
		<?php
		echo '<h2><a name="delete_bucket_eu">Delete Bucket (EU)</a></h2>';
		echo '<pre>'; print_r($delb_eu); echo '</pre>';
		?>
		</div>
	</body>
</html>
