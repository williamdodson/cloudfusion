<?php
/**
 * File: TarzanCore
 * 	Core functionality and default settings shared across classes.
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


/*%******************************************************************************************%*/
// CORE DEPENDENCIES

/**
 * Include the Tarzan config file
 */
@include_once('config.inc.php');

/**
 * Autoload classes.
 */
function __autoload($class_name)
{
	if (stristr($class_name, 'amazon'))
	{
		require_once(dirname(__FILE__) . '/' . str_replace('amazon', '', strtolower($class_name)) . '.class.php');
	}
	elseif (stristr($class_name, 'tarzan'))
	{
		require_once(dirname(__FILE__) . '/' . str_replace('tarzan', '_', strtolower($class_name)) . '.class.php');
	}
	elseif (stristr($class_name, 'cache'))
	{
		require_once(dirname(__FILE__) . '/' . '_' . strtolower($class_name) . '.class.php');
	}
}


/*%******************************************************************************************%*/
// CONSTANTS

/**
 * Constant: TARZAN_NAME
 * Name of the software.
 */
define('TARZAN_NAME', 'Tarzan');

/**
 * Constant: TARZAN_VERSION
 * Version of the software.
 */
define('TARZAN_VERSION', '2.0b');

/**
 * Constant: TARZAN_BUILD
 * Build ID of the software.
 */
define('TARZAN_BUILD', gmdate('YmdHis', strtotime(substr('$Date$', 7, 25)) ? strtotime(substr('$Date$', 7, 25)) : filemtime(__FILE__)));

/**
 * Constant: TARZAN_URL
 * URL to learn more about the software.
 */
define('TARZAN_URL', 'http://tarzan-aws.com');

/**
 * Constant: TARZAN_USERAGENT
 * User agent string used to identify Tarzan
 * > Tarzan/2.0b (Amazon Web Services API; http://tarzan-aws.com) Build/20080927210040
 */
define('TARZAN_USERAGENT', TARZAN_NAME . '/' . TARZAN_VERSION . ' (Amazon Web Services API; ' . TARZAN_URL . ') Build/' . TARZAN_BUILD);

/**
 * Constant: DATE_AWS_RFC2616
 * Define the RFC 2616-compliant date format
 */
define('DATE_AWS_RFC2616', 'D, d M Y H:i:s \G\M\T');

/**
 * Constant: DATE_AWS_ISO8601
 * Define the ISO-8601-compliant date format
 */
define('DATE_AWS_ISO8601', 'Y-m-d\TH:i:s\Z');

/**
 * Constant: HTTP_GET
 * HTTP method type: Get
 */
define('HTTP_GET', 'GET');

/**
 * Constant: HTTP_POST
 * HTTP method type: Post
 */
define('HTTP_POST', 'POST');

/**
 * Constant: HTTP_PUT
 * HTTP method type: Put
 */
define('HTTP_PUT', 'PUT');

/**
 * Constant: HTTP_DELETE
 * HTTP method type: Delete
 */
define('HTTP_DELETE', 'DELETE');

/**
 * Constant: HTTP_HEAD
 * HTTP method type: Head
 */
define('HTTP_HEAD', 'HEAD');


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: TarzanCore
 * 	Container for all shared methods. This is not intended to be instantiated directly, but is extended by the Amazon-specific classes.
 */
class TarzanCore
{
	/**
	 * Property: key
	 * The Amazon API Key.
	 */
	var $key;

	/**
	 * Property: secret_key
	 * The Amazon API Secret Key.
	 */
	var $secret_key;

	/**
	 * Property: account_id
	 * The Amazon Account ID, sans hyphens.
	 */
	var $account_id;

	/**
	 * Property: assoc_id
	 * The Amazon Associates ID.
	 */
	var $assoc_id;

	/**
	 * Property: util
	 * Handle for the utility functions.
	 */
	var $util;

	/**
	 * Property: service
	 * An identifier for the current AWS service.
	 */
	var $service = null;

	/**
	 * Property: api_version
	 * The supported API version.
	 */
	var $api_version = null;

	/**
	 * Property: utilities_class
	 * The default class to use for Utilities (defaults to <TarzanUtilities>).
	 */
	var $utilities_class = 'TarzanUtilities';

	/**
	 * Property: request_class
	 * The default class to use for HTTP Requests (defaults to <TarzanHTTPRequest>).
	 */
	var $request_class = 'TarzanHTTPRequest';

	/**
	 * Property: response_class
	 * The default class to use for HTTP Responses (defaults to <TarzanHTTPResponse>).
	 */
	var $response_class = 'TarzanHTTPResponse';

	/**
	 * Property: adjust_offset
	 * The number of seconds to adjust the request timestamp by (defaults to 0).
	 */
	var $adjust_offset = 0;


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
	 * 	key - _string_ (Optional) Your Amazon API Key. If blank, it will look for the <AWS_KEY> constant.
	 * 	secret_key - _string_ (Optional) Your Amazon API Secret Key. If blank, it will look for the <AWS_SECRET_KEY> constant.
	 * 	account_id - _string_ (Optional) Your Amazon account ID without the hyphens. Required for EC2. If blank, it will look for the <AWS_ACCOUNT_ID> constant.
	 * 	assoc_id - _string_ (Optional) Your Amazon Associates ID. Required for AAWS. If blank, it will look for the <AWS_ASSOC_ID> constant.
	 * 
	 * Returns:
	 * 	boolean FALSE if no valid values are set, otherwise true.
	 */
	public function __construct($key = null, $secret_key = null, $account_id = null, $assoc_id = null)
	{
		// Instantiate the utilities class.
		$this->util = new $this->utilities_class();

		// Determine the current service.
		$this->service = get_class($this);

		// Set a default value for the Account ID.
		if (!$account_id && defined('AWS_ACCOUNT_ID'))
		{
			$this->account_id = AWS_ACCOUNT_ID;
		}
		else // Move this to the EC2 class.
		{
			error_log('Tarzan: No Amazon account ID was passed into the constructor, nor was it set in the AWS_ACCOUNT_ID constant. Only required for EC2.');
		}

		// Set a default value for the Associates ID.
		if (!$assoc_id && defined('AWS_ASSOC_ID'))
		{
			$this->assoc_id = AWS_ASSOC_ID;
		}
		else // Move this to the AAWS class.
		{
			error_log('Tarzan: No Amazon Associates ID was passed into the constructor, nor was it set in the AWS_ASSOC_ID constant. Only required for AAWS.');
		}

		// If both a key and secret key are passed in, use those.
		if ($key && $secret_key)
		{
			$this->key = $key;
			$this->secret_key = $secret_key;
			return true;
		}

		// If neither are passed in, look for the constants instead.
		else if (defined('AWS_KEY') && defined('AWS_SECRET_KEY'))
		{
			$this->key = AWS_KEY;
			$this->secret_key = AWS_SECRET_KEY;
			return true;
		}

		// Otherwise set the values to blank and return false.
		else
		{
			$this->key = '';
			$this->secret_key = '';
			return false;
		}
	}


	/*%******************************************************************************************%*/
	// SET CUSTOM SETTINGS

	/**
	 * Method: adjust_offset()
	 * 	Allows you to adjust the current time, for occasions when your server is out of sync with Amazon's servers.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	seconds - _integer_ (Required) The number of seconds to adjust the sent timestamp by.
	 * 
	 * Returns:
	 * 	void
	 */
	public function adjust_offset($seconds)
	{
		$this->adjust_offset = $seconds;
	}


	/*%******************************************************************************************%*/
	// SET CUSTOM CLASSES

	/**
	 * Method: set_utilities_class()
	 * 	Set a custom class for this functionality. Perfect for extending/overriding existing classes with new functionality.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	class - _string_ (Optional) The name of the new class to use for this functionality. Defaults to the default class.
	 * 
	 * Returns:
	 * 	void
	 */
	function set_utilities_class($class = 'TarzanUtilities')
	{
		$this->utilities_class = $class;
		$this->util = new $this->utilities_class();
	}

	/**
	 * Method: set_request_class()
	 * 	Set a custom class for this functionality. Perfect for extending/overriding existing classes with new functionality.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	class - _string_ (Optional) The name of the new class to use for this functionality. Defaults to the default class.
	 * 
	 * Returns:
	 * 	void
	 */
	function set_request_class($class = 'TarzanHTTPRequest')
	{
		$this->request_class = $class;
	}

	/**
	 * Method: set_response_class()
	 * 	Set a custom class for this functionality. Perfect for extending/overriding existing classes with new functionality.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	class - _string_ (Optional) The name of the new class to use for this functionality. Defaults to the default class.
	 * 
	 * Returns:
	 * 	void
	 */
	function set_response_class($class = 'TarzanHTTPResponse')
	{
		$this->response_class = $class;
	}


	/*%******************************************************************************************%*/
	// AUTHENTICATION

	/**
	 * Method: authenticate()
	 * 	Default, shared method for authenticating a connection to AWS. Overridden on a class-by-class basis as necessary. This should not be used directly unless you're writing custom methods for this class.
	 * 
	 * Access:
	 * 	public
 	 * 
	 * Parameters:
	 * 	action - _string_ (Required) Indicates the action to perform.
	 * 	opt - _array_ (Optional) Associative array of parameters for authenticating. See the individual methods for allowed keys.
	 * 	queue_url - _string_ (Optional) The URL of the queue to perform the action on.
	 * 	message - _string_ (Optional) This parameter is only used by the send_message() method.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 */
	public function authenticate($action, $opt = null, $queue_url = null, $message = null)
	{
		// Manage the key-value pairs that are used in the query.
		$query['Action'] = $action;
		$query['AWSAccessKeyId'] = $this->key;
		$query['SignatureVersion'] = 1;
		$query['Timestamp'] = gmdate(DATE_AWS_ISO8601, time() + $this->adjust_offset);
		$query['Version'] = $this->api_version;

		// Merge in any options that were passed in
		if (is_array($opt))
		{
			$query = array_merge($query, $opt);
		}

		// Do a case-insensitive, natural order sort on the array keys.
		uksort($query, 'strnatcasecmp');

		// Create the string that needs to be hashed.
		$sign_query = $this->util->to_signable_string($query);

		// Hash the AWS secret key and generate a signature for the request.
		$query['Signature'] = $this->util->hex_to_base64(hash_hmac('sha1', $sign_query, $this->secret_key));

		// Generate the querystring from $query
		$querystring = $this->util->to_query_string($query);

		// Compose the request.
		$request_url = $queue_url . '?' . $querystring;
		$request = new $this->request_class($request_url);

		// Tweak some things if we have a message (i.e. AmazonSQS::send_message()).
		if ($message)
		{
			$request->addHeader('Content-Type', 'text/plain');
			$request->setMethod(HTTP_POST);
			$request->setBody($message);
		}

		// If we have a "true" value for returnCurlHandle, do that instead of completing the request.
		if (isset($opt['returnCurlHandle']))
		{
			return $request->prepRequest();
		}

		// Send!
		$request->sendRequest();

		// Prepare the response.
		$headers = $request->getResponseHeader();
		$headers['x-tarzan-requesturl'] = $request_url;
		$headers['x-tarzan-stringtosign'] = $sign_query;
		if ($message) $headers['x-tarzan-body'] = $message;
		$data = new $this->response_class($headers, $request->getResponseBody(), $request->getResponseCode());

		// Return!
		return $data;
	}


	/*%******************************************************************************************%*/
	// CACHING LAYER

	/**
	 * Method: cache_response()
	 * 	Caches a TarzanHTTPResponse object using the preferred caching method.
	 * 
	 * Access:
	 * 	public
 	 * 
	 * Parameters:
	 * 	method - _string_ (Required) The method of the current object that you want to execute and cache the response for. If the method is not in the $this scope, pass in an array where the correct scope is in the [0] position and the method name is in the [1] position.
	 * 	location - _string_ (Required) The location to store the cache object in. This may vary by cache method. Currently, file-based caching (via <CacheFile>) and APC caching (via <CacheAPC>) are available so valid values include relative and absolute local file system paths (e.g. /tmp/cache or ./cache), or 'apc'.
	 * 	expires - _integer_ (Required) The number of seconds until a cache object is considered stale.
	 * 	params - _array_ (Optional) An indexed array of parameters to pass to the aforementioned method, where array[0] represents the first parameter, array[1] is the second, etc.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 */
	public function cache_response($method, $location, $expires, $params = null)
	{
		$_this = $this;
		if (is_array($method))
		{
			$_this = $method[0];
			$method = $method[1];
		}

		// I would expect locations like '/tmp/cache', 'pdo://user:pass@hostname:port', and 'apc'.
		$type = strtolower(substr($location, 0, 3));
		switch ($type)
		{
			case 'apc':
				$CacheMethod = 'CacheAPC';
				break;
	
			default:
				$CacheMethod = 'CacheFile';
				break;
		}

		// Once we've determined the preferred caching method, instantiate a new cache.
		if (isset($_this->key))
		{
			$cache_uuid = $method . '-' . $_this->key . '-' . sha1($method . serialize($params));
		}
		else
		{
			$cache_uuid = $method . '-' . 'nokey' . '-' . sha1($method . serialize($params));
		}

		$cache = new $CacheMethod($cache_uuid, $location, $expires);

		// If the data exists...
		if ($data = $cache->read())
		{
			// It exists, but is it expired?
			if ($cache->is_expired())
			{
				// If so, fetch new data from Amazon.
				if ($data = call_user_func_array(array($_this, $method), $params))
				{
					if (is_array($data))
					{
						$copy = array();

						for ($i = 0, $len = sizeof($data); $i < $len; $i++)
						{
							// We need to convert the SimpleXML data back to real XML before the cache methods serialize it. <http://bugs.php.net/28152>
							$copy[$i] = clone($data[$i]);
							$copy[$i]->body = $copy[$i]->body->asXML();
						}

						// Cache the data
						$cache->create($copy);
					}
					else
					{
						// We need to convert the SimpleXML data back to real XML before the cache methods serialize it. <http://bugs.php.net/28152>
						$copy = clone($data);
						$copy->body = $copy->body->asXML();

						// Cache the data
						$cache->create($copy);

						// Free the unused memory.
						unset($copy);
					}
				}

				// We did not get back good data from Amazon...
				else
				{
					// ...so we'll reset the freshness of the cache and use it again (if supported by the caching method).
					$cache->reset();
				}
			}

			// It exists and is still fresh. Let's use it.
			else
			{
				if (is_array($data))
				{
					for ($i = 0, $len = sizeof($data); $i < $len; $i++)
					{
						// We need to convert the SimpleXML data back to real XML before the cache methods serialize it. <http://bugs.php.net/28152>
						$data[$i]->body = new SimpleXMLElement($data[$i]->body);
					}
				}
				else
				{
					// Since we're going to use this, let's convert the XML back into a SimpleXML object.
					$data->body = new SimpleXMLElement($data->body);
				}
			}
		}

		// The data does not already exist in the cache.
		else
		{
			// Fetch it.
			if ($data = call_user_func_array(array($_this, $method), $params))
			{
				if (is_array($data))
				{
					$copy = array();

					for ($i = 0, $len = sizeof($data); $i < $len; $i++)
					{
						// We need to convert the SimpleXML data back to real XML before the cache methods serialize it. <http://bugs.php.net/28152>
						$copy[$i] = clone($data[$i]);
						$copy[$i]->body = $copy[$i]->body->asXML();
					}

					// Cache the data
					$cache->create($copy);

					// Free the unused memory.
					unset($copy);
				}
				else
				{
					// We need to convert the SimpleXML data back to real XML before the cache methods serialize it. <http://bugs.php.net/28152>
					$copy = clone($data);
					$copy->body = $copy->body->asXML();

					// Cache the data
					$cache->create($copy);

					// Free the unused memory.
					unset($copy);
				}
			}
		}

		// We're done. Return the data. Huzzah!
		return $data;
	}
}
?>