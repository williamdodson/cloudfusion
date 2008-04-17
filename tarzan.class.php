<?php
/**
 * TARZAN CORE
 * Core and common Tarzan functionality.
 *
 * @category Tarzan
 * @package TarzanCore
 * @version 2008.04.12
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.googlecode.com Tarzan
 * @see README
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
	else
	{
		require_once(dirname(dirname(__FILE__)) . '/pear/' . strtolower($class_name) . '.php');
	}
}


/*%******************************************************************************************%*/
// CONSTANTS

/**
 * Tarzan Name
 */
define('TARZAN_NAME', 'Tarzan');

/**
 * Tarzan Version
 */
define('TARZAN_VERSION', '2.0b');

/**
 * Tarzan Build
 */
define('TARZAN_BUILD', 20080412);

/**
 * Tarzan Website URL
 */
define('TARZAN_URL', 'http://tarzan-aws.googlecode.com');

/**
 * Tarzan Useragent
 */
define('TARZAN_USERAGENT', TARZAN_NAME . '/' . TARZAN_VERSION . ' (Amazon Web Services API; ' . TARZAN_URL . ') Build/' . TARZAN_BUILD);

/**
 * Define the RFC 2616-compliant date format
 */
define('DATE_AWS_RFC2616', 'D, d M Y H:i:s \G\M\T');

/**
 * Define the ISO-8601-compliant date format
 */
define('DATE_AWS_ISO8601', 'Y-m-d\TH:i:s\Z');



/*%******************************************************************************************%*/
// CLASSES

/**
 * Wrapper for common AWS functions
 */
class TarzanCore
{
	/**
	 * The Amazon API Key
	 */
	var $key;

	/**
	 * The Amazon API Secret Key
	 */
	var $secret_key;

	/**
	 * The Amazon Account ID, sans hyphens
	 */
	var $account_id;

	/**
	 * The Amazon Associates ID
	 */
	var $assoc_id;

	/**
	 * Handle for the utility functions
	 */
	var $util;

	/**
	 * An identifier for the current service.
	 */
	var $service = null;

	/**
	 * API version.
	 */
	var $api_version = null;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructor
	 *
	 * Constructs a new instance of the TarzanCore class.
	 *
	 * @access public
	 * @param string $key Your Amazon API Key. If blank, it will look for the AWS_KEY constant.
	 * @param string $secret_key Your Amazon API Secret Key. If blank, it will look for the AWS_SECRET_KEY constant.
	 * @param string $account_id Your Amazon account ID without the hyphens. Required for EC2. If blank, it will look for the AWS_ACCOUNT_ID constant.
	 * @param string $assoc_id Your Amazon Associates ID. Required for AAWS. If blank, it will look for the AWS_ASSOC_ID constant.
	 * @return bool FALSE if no valid values are set, otherwise true.
	 */
	public function __construct($key = null, $secret_key = null, $account_id = null, $assoc_id = null)
	{
		// Instantiate the utilities class.
		$this->util = new TarzanUtilities();

		// Determine the current service.
		$this->service = get_class($this);

		// Set a default value for the Account ID.
		if (!$account_id && defined(AWS_ACCOUNT_ID))
		{
			$this->account_id = AWS_ACCOUNT_ID;
		}
		else // Move this to the EC2 class.
		{
			error_log('Tarzan: No Amazon account ID was passed into the constructor, nor was it set in the AWS_ACCOUNT_ID constant. Only required for EC2.');
		}

		// Set a default value for the Associates ID.
		if (!$assoc_id && defined(AWS_ASSOC_ID))
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
	// AUTHENTICATION

	/**
	 * Authenticate
	 *
	 * Authenticates a connection to AWS and is used by EC2, SQS, and SimpleDB. This method is not 
	 * intended to be manually called. Instead it is called by the other functions on a per-use basis.
	 *
	 * @access private
	 * @param string $action (Required) Indicates the action to perform.
	 * @param array $opt (Optional) Associative array of parameters for authenticating. See the individual methods for allowed keys.
	 * @param string $queue_url (Optional) The URL of the queue to perform the action on.
	 * @param string $message (Optional) This parameter is only used by the send_message() method.
	 * @return array Amazon's XML Web Service Response formatted as an array.
	 * 
	 * @see http://docs.amazonwebservices.com/AWSSimpleQueueService/2008-01-01/SQSDeveloperGuide/Query_QueryAuth.html
	 */
	public function authenticate($action, $opt = null, $queue_url = null, $message = null)
	{
		// Manage the key-value pairs that are used in the query.
		$query['Action'] = $action;
		$query['AWSAccessKeyId'] = $this->key;
		$query['SignatureVersion'] = 1;
		$query['Timestamp'] = gmdate(DATE_AWS_ISO8601, time());
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

		// Hash the AWS secret key
		$hasher =& new Crypt_HMAC($this->secret_key, 'sha1');

		// Generate a signature for the request.
		$query['Signature'] = $this->util->hex_to_base64($hasher->hash($sign_query));

		// Generate the querystring from $query
		$querystring = $this->util->to_query_string($query);

		// Compose the request.
		$request_url = $queue_url . '?' . $querystring;
		$request =& new HTTP_Request($request_url);
		$request->addHeader('User-Agent', TARZAN_USERAGENT);

		// Tweak some things if we have a message (i.e. AmazonSQS::send_message()).
		if ($message)
		{
			$request->addHeader('Content-Type', 'text/plain');
			$request->setMethod(HTTP_REQUEST_METHOD_POST);
			$request->setBody($message);
		}

		// Send!
		$request->sendRequest();

		// Prepare the response.
		$headers = $request->getResponseHeader();
		$headers['x-amz-requesturl'] = $request_url;
		$headers['x-amz-httpstatus'] = $request->getResponseCode();
		$headers['x-amz-stringtosign'] = $sign_query;
		$data = new TarzanHTTPResponse($headers, $request->getResponseBody());

		// Return!
		return $data;
	}
}


/**
 * Various utilities for working with AWS.
 */
class TarzanUtilities
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		return $this;
	}

	/**
	 * Check if a value (such as a GET or POST parameter or an array value) has a real, non-empty value.
	 * 
	 * @access public
	 * @param array $var (Required) The value to check.
	 * @return boolean Whether this has a real value.
	 */
	public function ready($var)
	{
		return (isset($var) && !empty($var)) ? true : false;
	}

	/**
	 * Convert a HEX value to Base64.
	 *
	 * @access public
	 * @param string $str (Required) Value to convert.
	 * @return string Base64-encoded string.
	 */
	public function hex_to_base64($str) {
	    $raw = '';
	    for ($i=0; $i < strlen($str); $i+=2) {
	        $raw .= chr(hexdec(substr($str, $i, 2)));
	    }
	    return base64_encode($raw);
	}

	/**
	 * Convert an associative array into a query string.
	 *
	 * @access public
	 * @param array $array (Required) Array to convert.
	 * @return string URL-friendly query string.
	 */
	public function to_query_string($array)
	{
		$t = array();
		foreach ($array as $k => $v)
		{
			$t[] = rawurlencode($k) . '=' . rawurlencode($v);
		}
		return implode('&', $t);
	}

	/**
	 * Convert an associative array into a sign-able string.
	 *
	 * @access public
	 * @param array $array (Required) Array to convert.
	 * @return string URL-friendly sign-able string.
	 */
	public function to_signable_string($array)
	{
		$t = array();
		foreach ($array as $k => $v)
		{
			$t[] = $k . $v;
		}
		return implode('', $t);
	}

	/**
	 * Convert a query string into an associative array.
	 * 
	 * Multiple, identical keys will become an indexed array.
	 * <code>
	 * ?key1=value&key1=value&key2=value
	 * 
	 * Array
	 * (
	 *     [key1] => Array
	 *         (
	 *             [0] => value
	 *             [1] => value
	 *         )
	 * 
	 *     [key2] => value
	 * )
	 * </code>
	 *
	 * @access public
	 * @param array $qs (Required) Query string to convert.
	 * @return array Associative array of keys and values.
	 */
	public function query_to_array($qs)
	{
		$query = explode('&', $qs);
		$data = array();

		foreach ($query as $q)
		{
			$q = explode('=', $q);

			if (isset($data[$q[0]]) && is_array($data[$q[0]]))
			{
				$data[$q[0]][] = urldecode($q[1]);
			}
			else if (isset($data[$q[0]]) && !is_array($data[$q[0]]))
			{
				$data[$q[0]] = array($data[$q[0]]);
				$data[$q[0]][] = urldecode($q[1]);
			}
			else
			{
				$data[urldecode($q[0])] = urldecode($q[1]);
			}
		}
		return $data;
	}

	/**
	 * Return human readable sizes
	 *
	 * @author Aidan Lister <aidan@php.net>
	 * @author Ryan Parman <ryan@warpshare.com>
	 * @param int $size (Required) Size in bytes.
	 * @param int $unit (Optional) The maximum unit.
	 * @param int $retstring (Optional) The return string format.
	 * @link http://aidanlister.com/repos/v/function.size_readable.php
	 */
	function size_readable($size, $unit = null, $retstring = null)
	{
		// Units
		$sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB');
		$mod = 1024;
		$ii = count($sizes) - 1;

		// Max unit
		$unit = array_search((string) $unit, $sizes);
		if ($unit === null || $unit === false)
		{
			$unit = $ii;
		}

		// Return string
		if ($retstring === null)
		{
			$retstring = '%01.2f %s';
		}

		// Loop
		$i = 0;
		while ($unit != $i && $size >= 1024 && $i < $ii)
		{
			$size /= $mod;
			$i++;
		}

		return sprintf($retstring, $size, $sizes[$i]);
	}
}


/**
 * Standard handler for PEAR-based responses from Amazon.
 */
class TarzanHTTPResponse
{
	/**
	 * Store HTTP header information.
	 */
	var $header;

	/**
	 * Store the SimpleXML response.
	 */
	var $body;

	/**
	 * Constructor
	 *
	 * Constructs a new instance of the TarzanHTTPResponse class.
	 *
	 * @access public
	 * @param array $header The HTTP headers as returned from AWS by PEAR's HTTP_Request class.
	 * @param string $body XML content as returned from AWS by PEAR's HTTP_Request class.
	 * @return object Contains an (array) 'header' property (containing HTTP headers) and a (SimpleXMLElement) 'body' property.
	 */
	public function __construct($header, $body)
	{
		$this->header = $header;
		$this->body = $body;

		if (TarzanUtilities::ready($body))
		{
			// If the response is XML data, parse it.
			if (substr(ltrim($body), 0, 5) == '<?xml')
			{
				$this->body = new SimpleXMLElement($body);
			}
		}

		return $this;
	}
}

?>