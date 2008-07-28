<?php
/**
 * AMAZON SIMPLE STORAGE SERVICE (S3)
 * http://s3.amazonaws.com
 *
 * @category Tarzan
 * @package S3
 * @version 2008.07.15
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.com Tarzan
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

	/**
	 * @var The virtual host setting.
	 */
	var $vhost;


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
		$this->vhost = null;
		$this->api_version = '2006-03-01';
		parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// AUTHENTICATION

	/**
	 * Authenticate
	 *
	 * Authenticates a connection to S3.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
	 * @param array $opt (Optional) Associative array of parameters for authenticating. See the individual methods for allowed keys.
	 * @param string $location (Do Not Use) Used internally by this function on occasions when S3 returns a redirect code and it needs to call itself recursively.
	 * @param integer $redirects (Do Not Use) Used internally by this function on occasions when S3 returns a redirect code and it needs to call itself recursively.
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
			$lastmodified = null;
			$etag = null;
			$qsa = null;
			$md5 = null;
			$returnCurlHandle = null;

			// Break the array into individual variables, while storing the original.
			$_opt = $opt;
			extract($opt);

			$filename = rawurlencode($filename);

			// Set hostname
			if ($this->vhost)
			{
				$hostname = $this->vhost;
			}
			elseif ($method == 'list_buckets')
			{
				$hostname = 's3.amazonaws.com';
			}
			else
			{
				$hostname = $bucket . '.s3.amazonaws.com';
			}

			// Get the UTC timestamp in RFC 2616 format
			$since_epoch = time() + $this->adjust_offset;
			$httpDate = gmdate(DATE_AWS_RFC2616, $since_epoch);

			// Generate the request string
			$request = '';

			// Append additional parameters
			$request .= '/' . $filename;

			// List Object settings
			if ($method == 'list_objects')
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

			// Logging
			elseif ($method == 'get_logs')
			{
				$request .= '?logging';
				$filename .= '?logging';
			}

			// Get Bucket Locale settings
			elseif ($method == 'get_bucket_locale')
			{
				$request = '/?location';
				$filename = '?location';
			}

			// Add ACL stuff if we're getting/setting ACL preferences.
			elseif ($method == 'get_bucket_acl' || $method == 'get_object_acl')
			{
				$request .= '?acl';
				$filename .= '?acl';
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

			// Instantiate the request class
			$req = new $this->request_class($this->request_url);

			// Do we have a verb?
			if (isset($verb) && !empty($verb))
			{
				$req->setMethod($verb);
			}

			// Do we have a contentType?
			if (isset($contentType) && !empty($contentType))
			{
				$req->addHeader('Content-Type', $contentType);
			}
			else if ($verb == HTTP_PUT) // Set a default value for HTTP_PUT
			{
				$contentType = 'application/x-www-form-urlencoded';
			}

			// Do we have an MD5 header?
			if ($md5)
			{
				$req->addHeader('Content-MD5', $md5);
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

			// Do we have COPY settings?
			if ($method == 'copy_object')
			{
				$acl .= 'x-amz-copy-source:/' . $sourceBucket . '/' . $sourceObject . "\n";
				$req->addHeader('x-amz-copy-source', '/' . $sourceBucket . '/' . $sourceObject);
			}

			// Are we checking for changes?
			if ($lastmodified && $etag)
			{
				$req->addHeader('If-Modified-Since', $lastmodified);
				$req->addHeader('If-None-Match', $etag);
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

			// If we're listing buckets, there is no filename value.
			if ($method == 'list_buckets')
			{
				$filename = '';
			}

			if ($qsa)
			{
				// Prepare the string to sign
				$stringToSign = "$verb\n$md5\n$contentType\n$since_epoch\n$acl/$bucket$filename";
			}
			else
			{
				// Prepare the string to sign
				$stringToSign = "$verb\n$md5\n$contentType\n$httpDate\n$acl/$bucket$filename";
			}

			// Hash the AWS secret key and generate a signature for the request.
			$signature = $this->util->hex_to_base64(hash_hmac('sha1', $stringToSign, $this->secret_key));

			// Pass the developer key and signature
			$req->addHeader("Authorization", "AWS " . $this->key . ":" . $signature);

			// If we have a "true" value for returnCurlHandle, do that instead of completing the request.
			if ($returnCurlHandle)
			{
				return $req->prepRequest();
			}

			// Are we getting a Query String Auth?
			if ($qsa)
			{
				return array(
					'bucket' => $bucket,
					'filename' => $filename,
					'key' => $this->key,
					'expires' => $since_epoch,
					'signature' => $signature,
				);
			}

			// Send!
			$req->sendRequest();

			// Prepare the response.
			$headers = $req->getResponseHeader();
			$headers['x-tarzan-redirects'] = $redirects;
			$headers['x-tarzan-requesturl'] = $this->request_url;
			$headers['x-tarzan-stringtosign'] = $stringToSign;
			$headers['x-tarzan-requestheaders'] = $req->request_headers;
			$data = new $this->response_class($headers, $req->getResponseBody(), $req->getResponseCode());

			// Did Amazon tell us to redirect? Typically happens for multiple rapid requests EU datacenters.
			// @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/Redirects.html
			if ((int) $req->getResponseCode() == 307) // Temporary redirect to new endpoint.
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

	/**
	 * Set Virtual Host
	 * 
	 * Use this virtual host instead of the normal bucket.s3.amazonaws.com domain.
	 * 
	 * @access public
	 * @param string $vhost (Required) The hostname to use instead of bucket.s3.amazonaws.com.
	 * @return void
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?VirtualHosting.html
	 */
	public function set_vhost($vhost)
	{
		$this->vhost = $vhost;
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
	 * @param string $locale (Optional) Sets the preferred geographical location for the bucket. Accepts S3_LOCATION_US or S3_LOCATION_EU. Defaults to S3_LOCATION_US.
	 * @param boolean $returnCurlHandle (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTBucketPUT.html
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/UsingBucket.html
	 */
	public function create_bucket($bucket, $locale = null, $returnCurlHandle = null)
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
			'verb' => HTTP_PUT,
			'method' => 'create_bucket',
			'body' => $body,
			'contentType' => $contentType,
			'returnCurlHandle' => $returnCurlHandle
		));
	}

	/**
	 * Get Bucket
	 *
	 * Referred to as "GET Bucket" in the AWS docs, but implemented here as AmazonS3::list_objects().
	 * 
	 * @access public
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
	 * @param boolean $returnCurlHandle (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTBucketLocationGET.html
	 */
	public function get_bucket_locale($bucket, $returnCurlHandle = null)
	{
		// Add this to our request
		$opt = array();
		$opt['verb'] = HTTP_GET;
		$opt['method'] = 'get_bucket_locale';
		$opt['returnCurlHandle'] = $returnCurlHandle;

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * HEAD Bucket
	 * 
	 * Reads only the HTTP headers of an object within a bucket.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
	 * @param boolean $returnCurlHandle (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTObjectHEAD.html
	 */
	public function head_bucket($bucket, $returnCurlHandle = null)
	{
		// Add this to our request
		$opt = array();
		$opt['verb'] = HTTP_HEAD;
		$opt['method'] = 'head_bucket';
		$opt['returnCurlHandle'] = $returnCurlHandle;

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * If Bucket Exists
	 * 
	 * Checks whether this bucket already exists in your account or not.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to check.
	 * @return boolean Whether it exists or not.
	 */
	public function if_bucket_exists($bucket)
	{
		$header = $this->head_bucket($bucket);
		return $header->isOK();
	}

	/**
	 * Delete Bucket
	 *
	 * All objects in the bucket must be deleted before the bucket itself can be deleted.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to delete.
	 * @param boolean $force (Optional) Whether to force-delete the bucket and all of its contents. Defaults to false.
	 * @param boolean $returnCurlHandle (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.
	 * @return TarzanHTTPResponse|boolean Standard TarzanHTTPResponse if normal bucket deletion or if forced bucket deletion was successful, a boolean false if the forced deletion was unsuccessful.
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTBucketDELETE.html
	 */
	public function delete_bucket($bucket, $force = false, $returnCurlHandle = null)
	{
		// Set default value
		$success = true;

		if ($force)
		{
			// Delete all of the items from the bucket.
			$success = $this->delete_all_objects($bucket);
		}

		// As long as we were successful...
		if ($success)
		{
			// Add this to our request
			$opt = array();
			$opt['verb'] = HTTP_DELETE;
			$opt['method'] = 'delete_bucket';
			$opt['returnCurlHandle'] = $returnCurlHandle;

			// Authenticate to S3
			return $this->authenticate($bucket, $opt);
		}

		return false;
	}

	/**
	 * Copy Bucket
	 * 
	 * Copies the contents of a bucket into a new bucket.
	 * 
	 * @access public
	 * @param string $source_bucket (Required) The name of the source bucket.
	 * @param string $dest_bucket (Required) The name of the destination bucket.
	 * @return TarzanHTTPResponse
	 */
	public function copy_bucket($source_bucket, $dest_bucket)
	{
		$dest = $this->create_bucket($dest_bucket);

		if ($dest->isOK())
		{
			$list = $this->get_object_list($source_bucket);
			$handles = array();
	
			foreach ($list as $item)
			{
				$handles[] = $this->copy_object($source_bucket, $item, $dest_bucket, $item, S3_ACL_PRIVATE, true);
			}

			$request = new $this->request_class(null);
			return $request->sendMultiRequest($handles);
		}
	}

	/**
	 * Rename Bucket
	 * 
	 * Renames a bucket by making a copy and deleting the original.
	 * 
	 * @access public
	 * @param string $source_bucket (Required) The name of the source bucket.
	 * @param string $dest_bucket (Required) The name of the destination bucket.
	 * @return TarzanHTTPResponse
	 */
	public function rename_bucket($source_bucket, $dest_bucket)
	{
		$responses = array();
		$responses['copy'] = $this->copy_bucket($source_bucket, $dest_bucket);
		$responses['delete'] = $this->delete_bucket($source_bucket, true);

		return $responses;
	}

	/**
	 * Get Bucket Size
	 * 
	 * Gets the number of files in the bucket.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to check.
	 * @return integer The number of files in the bucket.
	 */
	public function get_bucket_size($bucket)
	{
		return count($this->get_object_list($bucket));
	}

	/**
	 * Get Bucket File Size
	 * 
	 * Gets the file size of the contents of the bucket.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to check.
	 * @param boolean $friendly_format (Optional) Whether to format the value to 2 decimal points using the largest possible unit (i.e. 3.42 GB).
	 * @return integer|string The number of bytes as an integer, or the friendly format as a string.
	 */
	public function get_bucket_filesize($bucket, $friendly_format = false)
	{
		$filesize = 0;
		$list = $this->list_objects($bucket);

		foreach ($list->body->Contents as $filename)
		{
			$filesize += (int) $filename->Size;
		}

		if ($friendly_format)
		{
			$filesize = $this->util->size_readable($filesize);
		}

		return $filesize;
	}

	/**
	 * List Buckets
	 * 
	 * Gets a list of all of the buckets on the S3 account.
	 * 
	 * @access public
	 * @param boolean $returnCurlHandle (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.
	 * @return TarzanHTTPResponse
	 */
	public function list_buckets($returnCurlHandle = null)
	{
		// Add this to our request
		$opt['verb'] = HTTP_GET;
		$opt['method'] = 'list_buckets';
		$opt['returnCurlHandle'] = $returnCurlHandle;

		// Authenticate to S3
		return $this->authenticate('', $opt);
	}

	/**
	 * Get Bucket List
	 * 
	 * ONLY lists the bucket names on the S3 account.
	 * 
	 * @access public
	 * @param string $pcre (Optional) A Perl-Compatible Regular Expression (PCRE) to filter the bucket names against.
	 * @return TarzanHTTPResponse
	 */
	public function get_bucket_list($pcre = null)
	{
		// Set some default values
		$bucketnames = array();

		// Get a list of buckets.
		$list = $this->list_buckets();

		// If we have a PCRE regex, store it.
		if ($pcre)
		{
			// Loop through and find the bucket names.
			foreach ($list->body->Buckets->Bucket as $bucket)
			{
				$bucket = (string) $bucket->Name;

				if (preg_match($pcre, $bucket))
				{
					$bucketnames[] = $bucket;
				}
			}
		}
		else
		{
			// Loop through and find the bucket names.
			foreach ($list->body->Buckets->Bucket as $bucket)
			{
				$bucketnames[] = (string) $bucket->Name;
			}
		}

		return (count($bucketnames) > 0) ? $bucketnames : null;
	}

	/**
	 * Get Bucket ACL
	 * 
	 * Gets the ACL settings for a bucket.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
	 * @param boolean $returnCurlHandle (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?RESTAccessPolicy.html
	 */
	public function get_bucket_acl($bucket, $returnCurlHandle = null)
	{
		// Add this to our request
		$opt['verb'] = HTTP_GET;
		$opt['method'] = 'get_bucket_acl';
		$opt['returnCurlHandle'] = $returnCurlHandle;

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Set Bucket ACL
	 * 
	 * Sets the ACL settings for a bucket.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
	 * @param boolean $returnCurlHandle (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?RESTAccessPolicy.html
	 */
	public function set_bucket_acl($bucket, $acl = S3_ACL_PRIVATE, $returnCurlHandle = null)
	{
		// Add this to our request
		$opt['verb'] = HTTP_PUT;
		$opt['method'] = 'set_bucket_acl';
		$opt['returnCurlHandle'] = $returnCurlHandle;
		$opt['acl'] = $acl;

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}


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
	 *   <li>boolean $returnCurlHandle - (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTObjectPUT.html
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTAccessPolicy.html
	 * @todo Add support for custom metadata.
	 */
	public function create_object($bucket, $opt = null)
	{
		// Add this to our request
		$opt['verb'] = HTTP_PUT;
		$opt['method'] = 'create_object';
		$opt['filename'] = rawurlencode($opt['filename']);
		$opt['md5'] = $this->util->hex_to_base64(md5($opt['body']));

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
 	 * @param array $opt (Optional) Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string lastmodified - (Optional) The LastModified header passed in from a previous request. If used, requires 'etag' as well. Will return a 304 if file hasn't changed.</li>
	 *   <li>string etag - (Optional) The ETag header passed in from a previous request. If used, requires 'lastmodified' as well. Will return a 304 if file hasn't changed.</li>
	 *   <li>boolean $returnCurlHandle - (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTObjectGET.html
	 */
	public function get_object($bucket, $filename, $opt = null)
	{
		// Add this to our request
		$opt['verb'] = HTTP_GET;
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
	 * @param string $bucket (Required) The name of the bucket check.
	 * @param string $filename (Required) The filename for the content.
	 * @param boolean $returnCurlHandle (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTObjectHEAD.html
	 */
	public function head_object($bucket, $filename, $returnCurlHandle = null)
	{
		// Add this to our request
		$opt = array();
		$opt['verb'] = HTTP_HEAD;
		$opt['method'] = 'head_object';
		$opt['filename'] = rawurlencode($filename);
		$opt['returnCurlHandle'] = $returnCurlHandle;

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * If Object Exists
	 * 
	 * Checks whether this object already exists in this bucket.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket check.
	 * @param string $filename (Required) The filename for the content.
	 * @return boolean Whether it exists or not.
	 */
	public function if_object_exists($bucket, $filename)
	{
		$header = $this->head_object($bucket, $filename);
		return $header->isOK();
	}

	/**
	 * Delete Object
	 * 
	 * Deletes an object within a bucket.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
	 * @param string $filename (Required) The filename you want to delete.
	 * @param boolean $returnCurlHandle (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.
	 * @return TarzanHTTPResponse Standard TarzanHTTPResponse.
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/RESTObjectDELETE.html
	 */
	public function delete_object($bucket, $filename, $returnCurlHandle = null)
	{
		// Add this to our request
		$opt = array();
		$opt['verb'] = HTTP_DELETE;
		$opt['method'] = 'delete_object';
		$opt['filename'] = rawurlencode($filename);
		$opt['returnCurlHandle'] = $returnCurlHandle;

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Delete All Objects
	 * 
	 * Delete all of the objects inside the specified bucket.
	 *
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
	 * @param string $pcre (Optional) PCRE regular expression to match filenames by. Defaults to S3_PCRE_ALL.
	 * @return boolean Determines the success of deleting all files.
	 * @see delete_object
	 */
	public function delete_all_objects($bucket, $pcre = S3_PCRE_ALL)
	{
		// Collect all matches
		$list = $this->get_object_list($bucket, array('pcre', $pcre));

		// As long as we have at least one match...
		if (count($list) > 0)
		{
			// Hold CURL handles
			$handles = array();

			// Go through all of the items and delete them.
			foreach ($list as $item)
			{
				$handles[] = $this->delete_object($bucket, $item, true);
			}

			$request = new $this->request_class(null);
			return $request->sendMultiRequest($handles);
		}

		return false;
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
	 *   <li>boolean $returnCurlHandle - (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/gsg/ListKeys.html
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/ListingKeysRequest.html
	 */
	public function list_objects($bucket, $opt = null)
	{
		// Add this to our request
		$opt['verb'] = HTTP_GET;
		$opt['method'] = 'list_objects';

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Get Object File Size
	 * 
	 * Gets the file size of the object.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket check.
	 * @param string $filename (Required) The filename for the content.
	 * @param boolean $friendly_format (Optional) Whether to format the value to 2 decimal points using the largest possible unit (i.e. 3.42 GB).
	 * @return integer|string The number of bytes as an integer, or the friendly format as a string.
	 */
	public function get_object_filesize($bucket, $filename, $friendly_format = false)
	{
		$object = $this->head_object($bucket, $filename);
		$filesize = (integer) $object->header['content-length'];

		if ($friendly_format)
		{
			$filesize = $this->util->size_readable($filesize);
		}

		return $filesize;
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

	/**
	 * Copy Object
	 * 
	 * Copies an object to a new location.
	 * 
	 * @access public
	 * @param string $source_bucket (Required) The name of the bucket that contains the source file.
	 * @param string $source_filename (Required) The source filename that you want to copy.
	 * @param string $dest_bucket (Required) The name of the bucket that you want to copy the file to.
	 * @param string $dest_filename (Required) The filename that you want to give to the copy.
	 * @param string $acl - (Optional) One of the following options: S3_ACL_PRIVATE, S3_ACL_PUBLIC, S3_ACL_OPEN, or S3_ACL_AUTH_READ. Defaults to S3_ACL_PRIVATE.
	 * @param boolean $returnCurlHandle (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?RESTObjectCOPY.html
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?UsingCopyingObjects.html
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?RESTObjectPUT.html#RESTObjectPUTRequestHeaders
	 * @todo Add support for custom metadata.
	 */
	public function copy_object($source_bucket, $source_filename, $dest_bucket, $dest_filename, $acl = S3_ACL_PRIVATE, $returnCurlHandle = null)
	{
		// Add this to our request
		$opt['verb'] = HTTP_PUT;
		$opt['method'] = 'copy_object';
		$opt['sourceBucket'] = $source_bucket;
		$opt['sourceObject'] = $source_filename;
		$opt['destinationBucket'] = $dest_bucket;
		$opt['destinationObject'] = $dest_filename;
		$opt['metadataDirective'] = 'COPY';
		$opt['acl'] = $acl;
		$opt['filename'] = rawurlencode($dest_filename);
		$opt['returnCurlHandle'] = $returnCurlHandle;

		// Authenticate to S3
		return $this->authenticate($dest_bucket, $opt);
	}

	/**
	 * Duplicate Object
	 * 
	 * Identical to copy_object(), except that it only copies within a single bucket.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket that contains the file.
	 * @param string $source_filename (Required) The source filename that you want to copy.
	 * @param string $dest_filename (Required) The filename that you want to give to the copy.
	 * @param string $acl - (Optional) One of the following options: S3_ACL_PRIVATE, S3_ACL_PUBLIC, S3_ACL_OPEN, or S3_ACL_AUTH_READ. Defaults to S3_ACL_PRIVATE.
	 * @todo Add support for custom metadata.
	 */
	public function duplicate_object($bucket, $source_filename, $dest_filename, $acl = S3_ACL_PRIVATE)
	{
		return $this->copy_object($bucket, $source_filename, $bucket, $dest_filename, $acl);
	}

	/**
	 * Move Object
	 * 
	 * Moves an object to a new location.
	 * 
	 * @access public
	 * @param string $source_bucket (Required) The name of the bucket that contains the source file.
	 * @param string $source_filename (Required) The source filename that you want to copy.
	 * @param string $dest_bucket (Required) The name of the bucket that you want to copy the file to.
	 * @param string $dest_filename (Required) The filename that you want to give to the copy.
	 * @param string $acl - (Optional) One of the following options: S3_ACL_PRIVATE, S3_ACL_PUBLIC, S3_ACL_OPEN, or S3_ACL_AUTH_READ. Defaults to S3_ACL_PRIVATE.
	 * @todo Add support for custom metadata.
	 */
	public function move_object($source_bucket, $source_filename, $dest_bucket, $dest_filename, $acl = S3_ACL_PRIVATE)
	{
		$copy = $this->copy_object($source_bucket, $source_filename, $dest_bucket, $dest_filename, $acl);
		$del = $this->delete_object($source_bucket, $source_filename);
		return $copy;
	}

	/**
	 * Rename Object
	 * 
	 * Identical to move_object(), except that it only moves within a single bucket.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket that contains the file.
	 * @param string $source_filename (Required) The source filename that you want to copy.
	 * @param string $dest_filename (Required) The filename that you want to give to the copy.
	 * @param string $acl - (Optional) One of the following options: S3_ACL_PRIVATE, S3_ACL_PUBLIC, S3_ACL_OPEN, or S3_ACL_AUTH_READ. Defaults to S3_ACL_PRIVATE.
	 * @todo Add support for custom metadata.
	 */
	public function rename_object($bucket, $source_filename, $dest_filename, $acl = S3_ACL_PRIVATE)
	{
		return $this->move_object($bucket, $source_filename, $bucket, $dest_filename, $acl);
	}

	/**
	 * Get Object ACL
	 * 
	 * Gets the ACL settings for a object.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
	 * @param string $filename (Required) The filename for the content.
	 * @param boolean $returnCurlHandle (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?RESTAccessPolicy.html
	 */
	public function get_object_acl($bucket, $filename, $returnCurlHandle = null)
	{
		// Add this to our request
		$opt['verb'] = HTTP_GET;
		$opt['method'] = 'get_object_acl';
		$opt['filename'] = $filename;
		$opt['returnCurlHandle'] = $returnCurlHandle;

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Set Object ACL
	 * 
	 * Sets the ACL settings for a object.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used.
	 * @param string $filename (Required) The filename for the content.
	 * @param boolean $returnCurlHandle (Optional) A private toggle that will return the CURL handle for the request rather than actually completing the request. This is useful for MultiCURL requests.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?RESTAccessPolicy.html
	 */
	public function set_object_acl($bucket, $filename, $acl = S3_ACL_PRIVATE, $returnCurlHandle = null)
	{
		// Add this to our request
		$opt['verb'] = HTTP_PUT;
		$opt['method'] = 'set_object_acl';
		$opt['filename'] = $filename;
		$opt['returnCurlHandle'] = $returnCurlHandle;
		$opt['acl'] = $acl;

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}


	/*%******************************************************************************************%*/
	// LOGGING METHODS

	/**
	 * Get Logs
	 * 
	 * Get the access logs associated with a given bucket.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used. Pass null if using AmazonS3::set_vhost().
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?ServerLogs.html
	 */
	public function get_logs($bucket)
	{
		// Add this to our request
		$opt['verb'] = HTTP_GET;
		$opt['method'] = 'get_logs';

		// Authenticate to S3
		return $this->authenticate($bucket, $opt);
	}

	/**
	 * Toggle Logging
	 * 
	 * Enable/Disable bucket logging.
	 * 
	 * @todo Implement this method.
	 */
	public function toggle_logging()
	{
		
	}

	/**
	 * Set Logging Permissions
	 * 
	 * Determine the permissions for managing the logging process.
	 * 
	 * @todo Implement this method.
	 */
	public function set_logging_permissions()
	{
		
	}


	/*%******************************************************************************************%*/
	// MISCELLANEOUS METHODS

	/**
	 * Store Remote File
	 * 
	 * Takes an existing remote file, stores it to S3, and returns a URL.
	 * 
	 * @access public
	 * @param string $remote_file (Required) The full URL of the file to store on the S3 service.
	 * @param string $bucket (Required) The name of the bucket that you want to store it in.
	 * @param string $filename (Required) The name that you want to give to the file.
 	 * @param array $opt (Optional) Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string acl - (Optional) One of the following options: S3_ACL_PRIVATE, S3_ACL_PUBLIC, S3_ACL_OPEN, or S3_ACL_AUTH_READ. Defaults to S3_ACL_PUBLIC.</li>
	 *   <li>string overwrite - (Optional) If set to true, checks to see if the file exists and will overwrite the old data with new data. Defaults to false.</li>
	 * </ul>
	 * @return string The S3 URL for the uploaded file. Returns null if unsuccessful.
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
			$file = new $this->request_class($remote_file);
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
			$url = $object->header['x-tarzan-requesturl'];

			// If we have a virtual host value, use that instead of Amazon's hostname. There are better ways of doing this, but it works for now.
			if ($this->vhost)
			{
				$url = str_ireplace('http://', '', $url);
				$url = explode('/', $url);
				$url[0] = $this->vhost;
				$url = 'http://' . implode('/', $url);
			}

			return $url;
		}
		else
		{
			return null;
		}
	}

	/**
	 * Get Object URL
	 * 
	 * Gets the URL for the file.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used. Pass null if using AmazonS3::set_vhost().
	 * @param string $filename (Required) The filename for the content.
	 * @param integer $qsa (Required) This doubles as a boolean (do you want to use Query String Authentication?) and an integer (how many seconds from now should this authentication work?). Defaults to 0/false.
	 * @return string The file URL, with authentication parameters if requested.
	 */
	public function get_object_url($bucket, $filename, $qsa = 0)
	{
		if ($qsa)
		{
			// Add this to our request
			$opt['verb'] = HTTP_GET;
			$opt['method'] = 'get_object_url';
			$opt['filename'] = $filename;
			$opt['qsa'] = $qsa;

			// Adjust the clock
			$old_offset = $this->adjust_offset;
			$this->adjust_offset($qsa);

			// Authenticate to S3
			$data = $this->authenticate($bucket, $opt);

			// Reset the clock
			$this->adjust_offset = $old_offset;

			if ($this->vhost)
			{
				return 'http://' . $this->vhost . $data['filename'] . '?AWSAccessKeyId=' . $data['key'] . '&Expires=' . $data['expires'] . '&Signature=' . rawurlencode($data['signature']);
			}
			
			return 'http://' . $data['bucket'] . '.s3.amazonaws.com' . $data['filename'] . '?AWSAccessKeyId=' . $data['key'] . '&Expires=' . $data['expires'] . '&Signature=' . rawurlencode($data['signature']);
		}
		else
		{
			// If we're using a virtual host, use that instead.
			if ($this->vhost)
			{
				return 'http://' . $this->vhost . '/' . $filename;
			}

			return 'http://' . $bucket . '.s3.amazonaws.com/' . $filename;
		}
	}

	/**
	 * Get Torrent URL
	 * 
	 * Gets the URL for the torrent file for the file.
	 * 
	 * @access public
	 * @param string $bucket (Required) The name of the bucket to be used. Pass null if using AmazonS3::set_vhost().
	 * @param string $filename (Required) The filename for the content.
	 * @return string The Torrent URL.
	 * @see http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?S3Torrent.html
	 */
	public function get_torrent_url($bucket, $filename)
	{
		// If we're using a virtual host, use that instead.
		if ($this->vhost)
		{
			return 'http://' . $this->vhost . '/' . $filename . '?torrent';
		}
		return 'http://' . $bucket . '.s3.amazonaws.com/' . $filename . '?torrent';
	}
}
?>