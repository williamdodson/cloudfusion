<?php
/**
 * AMAZON SIMPLE STORAGE SERVICE (S3)
 * http://s3.amazonaws.com
 *
 * @category Tarzan
 * @package S3
 * @version 2008.04.23
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.googlecode.com Tarzan
 * @link http://s3.amazonaws.com Amazon S3
 * @see README
 */


/*%******************************************************************************************%*/
// CONSTANTS

/**
 * Specify the US location.
 */
define('S3_LOCATION_US', 'us');

/**
 * Specify the European Union (EU) location.
 */
define('S3_LOCATION_EU', 'eu');

/**
 * ACL: Owner-only read/write.
 */
define('S3_ACL_PRIVATE', 'private');

/**
 * ACL: Owner read/write, public read.
 */
define('S3_ACL_PUBLIC', 'public-read');

/**
 * ACL: Public read/write.
 */
define('S3_ACL_OPEN', 'public-read-write');

/**
 * ACL: Owner read/write, authenticated read.
 */
define('S3_ACL_AUTH_READ', 'authenticated-read');

/**
 * PCRE: Match all items
 */
define('S3_PCRE_ALL', '/.*/i');


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Container for all Amazon S3-related methods.
 */
class AmazonS3 extends TarzanCore
{
	/**
	 * @var The request URL.
	 */
	var $request_url;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructor
	 * 
	 * @access public
	 * @param string $key Your Amazon API Key. If blank, it will look for the AWS_KEY constant.
	 * @param string $secret_key Your Amazon API Secret Key. If blank, it will look for the AWS_SECRET_KEY constant.
	 * @return bool FALSE if no valid values are set, otherwise true.
	 */
	public function __construct($key = null, $secret_key = null)
	{
		$this->api_version = '2006-03-01';
		parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// AUTHENTICATION

	/**
	 * Authenticate
	 *
	 * Authenticates a connection to AWS. Overridden from TarzanCore.
	 *
	 * @access private
	 * @param string $bucket (Required) The name of the bucket to be used.
	 * @param array $opt Associative array of parameters for authenticating. See the individual methods for allowed keys.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTAuthentication.html
	 */
	public function authenticate($bucket, $opt = null, $location = null, $redirects = 0)
	{
		// If nothing was passed in, don't do anything.
		if (!$opt)
		{
			return false;
		}
		else
		{
			// Set default values
			$bucket = strtolower($bucket);
			$acl = null;
			$body = null;
			$contentType = null;
			$delimiter = null;
			$filename = null;
			$marker = null;
			$maxKeys = null;
			$method = null;
			$prefix = null;
			$verb = null;
			$hostname = $bucket . '.s3.amazonaws.com';

			// Break the array into individual variables, while storing the original.
			$_opt = $opt;
			extract($opt);

			// Get the UTC timestamp in RFC 2616 format
			$httpDate = gmdate(DATE_AWS_RFC2616, time());

			// Generate the request string
			//$request = $bucket;
			$request = '';

			// Append additional parameters
			$request .= '/' . $filename;

			// List Object settings
			if (isset($method) && !empty($method) && $method == 'list_objects')
			{
				if (isset($prefix) && !empty($prefix))
				{
					$request = '/?prefix=' . $prefix;
				}
				else if (isset($marker) && !empty($marker))
				{
					$request = '/?marker=' . $marker;
				}
				else if (isset($maxKeys) && !empty($maxKeys))
				{
					$request = '/?max-keys=' . $maxKeys;
				}
				else if (isset($delimiter) && !empty($delimiter))
				{
					$request = '/?delimiter=' . $delimiter;
				}
			}

			// Get Bucket Locale settings
			if (isset($method) && !empty($method) && $method == 'get_bucket_locale')
			{
				$request = '/?location';
				$filename = '?location';
			}

			if (!$request == '/')
			{
				$request = '/' . $request;
			}

			// Prepare the request.
			if ($location)
			{
				$this->request_url = $location;
			}
			else
			{
				$this->request_url = 'http://' . $hostname . $request;
			}
			$req =& new HTTP_Request($this->request_url);
			$req->addHeader('User-Agent', TARZAN_USERAGENT);

			// Do we have a verb?
			if (isset($verb) && !empty($verb))
			{
				$req->setMethod($verb);
			}

			// Do we have a contentType?
			if (isset($contentType) && !empty($contentType))
			{
				$req->addHeader("Content-Type", $contentType);
			}

			// Do we have a date?
			if (isset($httpDate) && !empty($httpDate))
			{
				$req->addHeader("Date", $httpDate);
			}

			// Do we have ACL settings? (Optional in signed string)
			if (isset($acl) && !empty($acl))
			{
				$req->addHeader("x-amz-acl", $acl);
				$acl = 'x-amz-acl:' . $acl . "\n";
			}

			// Add a body if we're creating
			if ($method == 'create_object' || $method == 'create_bucket')
			{
				if (isset($body) && !empty($body))
				{
					$req->setBody($body);
				}
			}

			// Data that will be "signed".
			$filename = '/' . $filename;
			$stringToSign = "$verb\n\n$contentType\n$httpDate\n$acl/$bucket$filename";

			// Hash the AWS secret key
			$hasher =& new Crypt_HMAC($this->secret_key, 'sha1');

			// Generate a signature for the request.
			$signature = $this->util->hex_to_base64($hasher->hash($stringToSign));

			// Pass the developer key and signature
			$req->addHeader("Authorization", "AWS " . $this->key . ":" . $signature);

			// Send!
			$req->sendRequest();

			// Prepare the response.
			$headers = $req->getResponseHeader();
			$headers['x-amz-httpstatus'] = $req->getResponseCode();
			$headers['x-amz-redirects'] = $redirects;
			$headers['x-amz-requesturl'] = $this->request_url;
			$headers['x-amz-stringtosign'] = $stringToSign;
			$data = new TarzanHTTPResponse($headers, $req->getResponseBody(), $req->getResponseCode());

			// Did Amazon tell us to redirect? Typically happens for multiple rapid requests EU datacenters.
			// @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/Redirects.html
			if ((int) $headers['x-amz-httpstatus'] == 307) // Temporary redirect to new endpoint.
			{
				$redirects++;
				$data = $this->authenticate($bucket, 
					$_opt, 
					$headers['location'], 
					$redirects);
			}

			// Return!
			return $data;
		}
	}


	/*%******************************************************************************************%*/
	// BUCKET METHODS

	/**
	 * Create Bucket
	 *
	 * The bucket holds all of your objects, and provides a globally unique namespace in which you 
	 * can manage the keys that identify objects. A bucket can hold any number of objects.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to create.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTBucketPUT.html
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/UsingBucket.html
	 */
	public function create_bucket($bucket, $locale = null)
	{
		// Defaults
		$body = null;
		$contentType = null;

		if ($locale)
		{
			switch(strtolower($locale))
			{
				case 'eu':
					$body = '<CreateBucketConfiguration><LocationConstraint>' . strtoupper($locale) . '</LocationConstraint></CreateBucketConfiguration>';
					$contentType = 'application/xml';
					break;
			}
		}

		// Authenticate to S3
		return $this->authenticate($bucket, array(
			'verb' => 'PUT',
			'method' => 'create_bucket',
			'body' => $body,
			'contentType' => $contentType
		));
	}

	/**
	 * Get Bucket
	 *
	 * Referred to as "GET Bucket" in the AWS docs, but implemented here as AmazonS3::list_objects().
	 * 
	 * @return TarzanHTTPResponse
	 * @see list_objects
	 */
	public function get_bucket($bucket, $opt = null)
	{
		return $this->list_objects($bucket, $opt);
	}

	/**
	 * Get Bucket Locale
	 *
	 * Lists the location constraint of the bucket. U.S.-based buckets have no response.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to check.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTBucketLocationGET.html
	 */
	public function get_bucket_locale($bucket)
	{
		// Add this to our request
		$opt = array();
		$opt['verb'] = 'GET';
		$opt['method'] = 'get_bucket_locale';

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Delete Bucket
	 *
	 * All objects in the bucket must be deleted before the bucket itself can be deleted.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to delete.
	 * @param boolean $force (Optional) Whether to force-delete the bucket and all of its contents. Defaults to false.
	 * @return TarzanHTTPResponse|boolean Standard TarzanHTTPResponse if normal bucket deletion or if forced bucket deletion was successful, a boolean false if the forced deletion was unsuccessful.
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTBucketDELETE.html
	 */
	public function delete_bucket($bucket, $force = false)
	{
		// Set default value
		$success = true;

		if ($force)
		{
			// Delete all of the items from the bucket.
			$success = $this->delete_object($bucket, S3_PCRE_ALL, true);
		}

		// As long as we were successful...
		if ($success)
		{
			// Add this to our request
			$opt = array();
			$opt['verb'] = 'DELETE';
			$opt['method'] = 'delete_bucket';

			// Authenticate to S3
			return $this->authenticate($bucket, $opt);
		}

		// Otherwise return false.
		else
		{
			return false;
		}
	}

	/**
	 * Copy Bucket
	 * 
	 * Copies the contents of a bucket into a new bucket.
	 * 
	 * @todo Implement this method.
	 */
	public function copy_bucket()
	{
		
	}

	/**
	 * Rename Bucket
	 * 
	 * Because renaming buckets isn't supported natively by S3, this method will create a new bucket, 
	 * copy the contents of the current bucket into the new bucket, delete the contents of the old 
	 * bucket, then delete the old bucket. This gives the end-result of a bucket being renamed, but 
	 * involves a lot of data transfer. For larger buckets this can be costly in terms of time, CPU, 
	 * and S3 billing costs.
	 * 
	 * You're better off picking a good name at the beginning, or living with a bucket name that 
	 * already exists. ;)
	 * 
	 * @todo Implement this method.
	 */
	public function rename_bucket()
	{
		
	}

	/**
	 * Bucket Exists
	 * 
	 * Checks whether this bucket already exists or not.
	 * 
	 * @todo Implement this method.
	 */
	public function if_bucket_exists($bucket)
	{
		
	}

	/**
	 * Get Bucket Size
	 * 
	 * Gets the number of files in the bucket.
	 * 
	 * @return integer
	 */
	public function get_bucket_size($bucket)
	{
		return count($this->get_object_list($bucket));
	}

	/**
	 * Get Bucket Size
	 * 
	 * Gets the file size of the contents of the bucket.
	 * 
	 * @todo Implement this method.
	 */
	public function get_bucket_filesize($bucket, $friendly_format = false)
	{
		
	}

	/**
	 * Post Object
	 *
	 * @todo Implement this method.
	 */
	private function post_object() {}


	/*%******************************************************************************************%*/
	// OBJECT METHODS

	/**
	 * Create Object
	 *
	 * Once you have a bucket, you can start storing objects in it. Objects are stored using the HTTP 
	 * PUT method. Each object can hold up to 5 GB of data. When you store an object, S3 streams the 
	 * data to multiple storage servers in multiple data centers to ensure that the data remains 
	 * available in the event of internal network or hardware failure.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
 	 * @param array $opt (Required) Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string filename - (Required) The filename for the content.</li>
	 *   <li>string body - (Required) The data to be stored in the object.</li>
	 *   <li>string contentType - (Required) The type of content that is being sent in the body.</li>
	 *   <li>string acl - (Optional) One of the following options: S3_ACL_PRIVATE, S3_ACL_PUBLIC, S3_ACL_OPEN, or S3_ACL_AUTH_READ. Defaults to S3_ACL_PRIVATE.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTObjectPUT.html
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTAccessPolicy.html
	 */
	public function create_object($bucket, $opt = null)
	{
		// Add this to our request
		$opt['verb'] = 'PUT';
		$opt['method'] = 'create_object';
		$opt['filename'] = rawurlencode($opt['filename']);

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Get Object
	 * 
	 * Reads the contents of an object within a bucket.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
	 * @param string $filename (Required) The filename for the content.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTObjectGET.html
	 */
	public function get_object($bucket, $filename)
	{
		// Add this to our request
		$opt = array();
		$opt['verb'] = 'GET';
		$opt['method'] = 'get_object';
		$opt['filename'] = rawurlencode($filename);

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * HEAD Object
	 * 
	 * Reads only the HTTP headers of an object within a bucket.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
	 * @param string $filename (Required) The filename for the content.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTObjectHEAD.html
	 */
	public function head_object($bucket, $filename)
	{
		// Add this to our request
		$opt = array();
		$opt['verb'] = 'HEAD';
		$opt['method'] = 'head_object';
		$opt['filename'] = rawurlencode($filename);

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Delete Object
	 * 
	 * Deletes an object within a bucket.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
	 * @param string $filename (Required) Either the filename for the content, or a PCRE regular expression that matches the files you want to delete.
	 * @param boolean $is_pcre (Optional) Tells the method whether you've passed a PCRE regular expression to the $filename parameter.
	 * @return TarzanHTTPResponse|boolean Standard TarzanHTTPResponse if a single file deletion, a boolean value determining the success of deleting requested files.
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTObjectDELETE.html
	 */
	public function delete_object($bucket, $filename, $is_pcre = false)
	{
		if ($is_pcre)
		{
			$success = true;

			$list = $this->get_object_list($bucket, array('pcre', $filename));
			foreach ($list as $item)
			{
				$del = $this->delete_object($bucket, $item);

				if (!$del->isOK(204))
				{
					$success = false;
				}
			}

			return $success;
		}
		else
		{
			// Add this to our request
			$opt = array();
			$opt['verb'] = 'DELETE';
			$opt['method'] = 'delete_object';
			$opt['filename'] = rawurlencode($filename);

			// Authenticate to S3
			return $this->authenticate($bucket, $opt);
		}
	}

	/**
	 * List Objects
	 * 
	 * Lists the objects in a bucket. Provided as the 'GetBucket' action in Amazon's REST API.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
 	 * @param array $opt (Optional) Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string prefix - (Optional) Restricts the response to only contain results that begin with the specified prefix.</li>
	 *   <li>string marker - (Optional) It restricts the response to only contain results that occur alphabetically after the value of marker.</li>
	 *   <li>string maxKeys - (Optional) Limits the number of results returned in response to your query. Will return no more than this number of results, but possibly less.</li>
	 *   <li>string delimiter - (Optional) Unicode string parameter. Keys that contain the same string between the prefix and the first occurrence of the delimiter will be rolled up into a single result element in the CommonPrefixes collection.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/gsg/ListKeys.html
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/ListingKeysRequest.html
	 */
	public function list_objects($bucket, $opt = null)
	{
		// Add this to our request
		$opt['verb'] = 'GET';
		$opt['method'] = 'list_objects';

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Get Object List
	 * 
	 * ONLY lists the object filenames from a bucket.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
 	 * @param array $opt (Optional) Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string prefix - (Optional) Restricts the response to only contain results that begin with the specified prefix.</li>
	 *   <li>string marker - (Optional) It restricts the response to only contain results that occur alphabetically after the value of marker.</li>
	 *   <li>string maxKeys - (Optional) Limits the number of results returned in response to your query. Will return no more than this number of results, but possibly less.</li>
	 *   <li>string delimiter - (Optional) Unicode string parameter. Keys that contain the same string between the prefix and the first occurrence of the delimiter will be rolled up into a single result element in the CommonPrefixes collection.</li>
	 *   <li>string pcre - (Optional) A Perl-Compatible Regular Expression (PCRE) to filter the filenames against. This is applied AFTER any native S3 filtering from 'prefix', 'marker', 'maxKeys', or 'delimiter'.</li>
	 * </ul>
	 * @return array
	 * @see list_objects
	 */
	public function get_object_list($bucket, $opt = null)
	{
		// Set some default values
		$filenames = array();
		$pcre = null;

		// Get a list of files.
		$list = $this->list_objects($bucket, $opt);

		// Extract the options
		if ($opt)
		{
			extract($opt);
		}

		// If we have a PCRE regex, store it.
		if ($pcre)
		{
			// Loop through and find the filenames.
			foreach ($list->body->Contents as $file)
			{
				$file = (string) $file->Key;

				if (preg_match($pcre, $file))
				{
					$filenames[] = $file;
				}
			}
		}
		else
		{
			// Loop through and find the filenames.
			foreach ($list->body->Contents as $file)
			{
				$filenames[] = (string) $file->Key;
			}
		}

		return (count($filenames) > 0) ? $filenames : null;
	}

	public function copy_object()
	{
		
	}

	public function move_object()
	{
		
	}

	public function rename_object()
	{
		
	}

	public function change_object_permissions()
	{
		
	}


	/*%******************************************************************************************%*/
	// MISCELLANEOUS METHODS

	/**
	 * Store Remote File
	 * 
	 * Takes an existing remote file, stores it to S3, and returns a URL.
	 * 
	 * @param string $remote_file (Required) The full URL of the file to store on the S3 service.
	 * @param string $bucket (Required) The name of the bucket that you want to store it in.
	 * @param string $filename (Required) The name that you want to give to the file.
 	 * @param array $opt (Optional) Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string acl - (Optional) One of the following options: S3_ACL_PRIVATE, S3_ACL_PUBLIC, S3_ACL_OPEN, or S3_ACL_AUTH_READ. Defaults to S3_ACL_PRIVATE. Defaults to S3_ACL_PUBLIC.</li>
	 *   <li>string overwrite - (Optional) If set to true, checks to see if the file exists and will overwrite the old data with new data. Defaults to false.</li>
	 *   <li>string cname - (Optional) If you're serving the file from a different hostname from s3.amazonaws.com (e.g. such as with a custom CNAME setting), return the URL with this hostname. Defaults to null.</li>
	 * </ul>
	 * @return string The S3 URL for the uploaded file. Returns null if unsuccessful.
	 * @todo Create Unit Test
	 */
	public function store_remote_file($remote_file, $bucket, $filename, $opt = null)
	{
		// Set default values.
		$acl = S3_ACL_PUBLIC;
		$overwrite = false;
		$cname = null;

		if ($opt)
		{
			// Break the options out.
			extract($opt);
		}

		// Does the file already exist?
		$object = $this->head_object($bucket, $filename);

		// As long as it doesn't already exist, fetch and store it.
		if (!$object->isOK() || $overwrite)
		{
			// Fetch the file
			$file = new HTTP_Request($remote_file);
			$file->sendRequest();

			// Store it in S3
			unset($object);
			$object = $this->create_object($bucket, array(
				'filename' => $filename,
				'body' => $file->getResponseBody(),
				'contentType' => $file->getResponseHeader('content-type'),
				'acl' => $acl
			));
		}

		// Was the request successful?
		if ($object->isOK())
		{
			$url = $object->header['x-amz-requesturl'];

			// If we have a CNAME value, use that instead of Amazon's hostname. There are better ways of doing this, but it works for now.
			if ($cname)
			{
				$url = str_ireplace('http://', '', $url);
				$url = explode('/', $url);
				$url[0] = $cname;
				$url = 'http://' . implode('/', $url);
			}

			return $url;
		}
		else
		{
			return null;
		}
	}
}
?>