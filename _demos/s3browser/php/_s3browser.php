<?php
/**
 * File: S3Browser
 * 	Functionality specific to the S3 Browser.
 *
 * Version:
 * 	2008.10.03
 * 
 * Copyright:
 * 	2006-2008 LifeNexus Digital, Inc., and contributors.
 * 
 * License:
 * 	Simplified BSD License - http://opensource.org/licenses/bsd-license.php
 * 
 * See Also:
 * 	Tarzan - http://tarzan-aws.com
 */


/**
 * Class: S3Browser
 * 	Container for all S3 Browser-specific functionality.
 */
class S3Browser
{
	/**
	 * Property: s3
	 * 	Holds a reference to the S3 object.
	 */
	var $s3;

	/**
	 * Property: options
	 * 	Options to pass into the object.
	 */
	var $options;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	The constructor
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	s3 - _AmazonS3_ (Required) A reference to an already instantiated AmazonS3 object.
 	 * 	options - _array_ (Required) Associative array of parameters which can have the following keys:
 	 * 
 	 * Keys for the $opt parameter:
 	 * 	cache - _string_ (Required) Either a local file system path (for file-based caching) or 'apc' for APC-based caching.
	 * 	cache_duration - _integer_ (Required) The number of seconds to cache AWS responses for.
	 * 	images - _string_ (Required) Web-friendly path to the images folder.
	 * 	templates - _string_ (Optional) Local file system path to the templates folder.
	 * 
	 * Returns:
	 * 	void
	 */
	function __construct($s3, $options)
	{
		$this->s3 = $s3;
		$this->options = $options;
	}


	/*%******************************************************************************************%*/
	// METHODS

	/**
	 * Method: is_public()
	 * 	Checks whether the object is public or not.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	item - _SimpleXMLElement_ (Required) A reference to a single item in an AmazonS3::get_object_acl() response.
	 * 
	 * Returns:
	 * 	_boolean_ Whether the object is public or not.
	 */
	function is_public($item)
	{
		if (isset($item->body->AccessControlList->Grant))
		{
			foreach ($item->body->AccessControlList->Grant as $grant)
			{
				if (isset($grant->Grantee->URI) && (string) $grant->Grantee->URI == 'http://acs.amazonaws.com/groups/global/AllUsers' && (string) $grant->Permission == 'READ')
				{
					return true;
				}
			}
		}
		
		return false;
	}

	/**
	 * Method: generate()
	 * 	Generates the view and outputs it to the page buffer.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	bucket - _string_ (Optional) The name of the bucket in your account to look up.
 	 * 
	 * Returns:
	 * 	void
	 */
	function generate($bucket = null)
	{
		// The name of the bucket.
		echo '<h3>Bucket: ' . $bucket . '</h3>';

		// Fetch (and cache) a list of objects for the current bucket.
		$contents = $this->s3->cache_response('list_objects', $this->options['cache'], $this->options['cache_duration'], array($bucket));

		// Grab each of the object filenames and generate an array of cURL handles to execute.
		$handles = array();
		foreach ($contents->body->Contents as $item)
		{
			$handles[] = $this->s3->get_object_acl($bucket, $item->Key, true);
		}

		// Execute (and cache) a MultiCurl request for ACL information for all objects in the bucket.
		$http = new TarzanHTTPRequest(null);
		$object_acl = $this->s3->cache_response(array($http, 'sendMultiRequest'), $this->options['cache'], $this->options['cache_duration'], array($handles));

		// Chop up the template and prepare for re-use.
		$template = file_get_contents($this->options['templates'] . '/default.tmpl');
		$pre = explode('{S3-LOOP}', $template);
		$content = explode('{S3-ENDLOOP}', $pre[1]);
		$post = $content[1];
		$content = $content[0];
		$pre = $pre[0];

		// Set some initial values and output the beginning of the table.
		echo $pre;
		$i = 0;
		$zi = 0;

		// Begin looping through all of the items in the bucket.
		foreach ($contents->body->Contents as $item)
		{
			// Only display if they're public (not private) items, and as long as the file size is larger than 10 bytes (folder names are 10 bytes and we want to remove them).
			if ($this->is_public($object_acl[$i]) && (integer) $item->Size > 10)
			{
				// Copy the in-loop part of the template.
				$loop = $content;

				// Get the file extension.
				$extension = array_pop(explode('.', (string) $item->Key));

				// Replace the placeholder text with the real values.
				$loop = str_replace('{S3-ZEBRA}', ($zi % 2) ? 'zebra' : '', $loop);
				$loop = str_replace('{S3-FILENAME}', (string) $item->Key, $loop);
				$loop = str_replace('{S3-FILEURL}', 'http://' . $this->s3->vhost . '/' . (string) $item->Key, $loop);
				$loop = str_replace('{S3-TYPE}', strtoupper($extension), $loop);
				$loop = str_replace('{S3-SIZE}', $this->s3->util->size_readable((integer) $item->Size), $loop);
				$loop = str_replace('{S3-DATE}', date('j M Y, g:i a', strtotime((string) $item->LastModified)), $loop);
				$loop = str_replace('{S3-ICON}', './images/icons/check.php?i=' . strtolower($extension) . '.png', $loop);
				$loop = str_replace('{S3-EXTENSION}', strtoupper($extension), $loop);

				// Echo it out to the page.
				echo $loop;

				// Increase the zebra index.
				$zi++;
			}

			// Increase the overall counter index.
			$i++;
		}

		// Output the end of the table.
		echo $post;
	}
}

?>