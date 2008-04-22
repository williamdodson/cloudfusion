<?php
/**
 * TARZAN CORE
 * Core Tarzan functionality.
 *
 * @category Tarzan
 * @package TarzanCore
 * @version 2008.04.20
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
	elseif (stristr($class_name, 'tarzan'))
	{
		require_once(dirname(__FILE__) . '/' . str_replace('tarzan', '_', strtolower($class_name)) . '.class.php');
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
// CLASS

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
	 * @return object A TarzanHTTPResponse response object.
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
		$data = new TarzanHTTPResponse($headers, $request->getResponseBody(), $request->getResponseCode());

		// Return!
		return $data;
	}
}
?>