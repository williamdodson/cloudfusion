<?php
/**
 * TARZAN HTTP REQUEST
 * HTTP Requests using CURL.
 *
 * @category Tarzan
 * @package TarzanHTTPRequest
 * @version 2008.07.03
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.googlecode.com Tarzan
 * @see README
 */


/*%******************************************************************************************%*/
// CLASS

/**
 * Request data via CURL.
 */
class TarzanHTTPRequest
{
	/**
	 * @var The URL being requested.
	 */
	var $request_url;

	/**
	 * @var The headers being sent in the request.
	 */
	var $request_headers;

	/**
	 * @var The body being sent in the request.
	 */
	var $request_body;

	/**
	 * @var The response returned by the request.
	 */
	var $response;

	/**
	 * @var The headers returned by the request.
	 */
	var $response_headers;

	/**
	 * @var The body returned by the request.
	 */
	var $response_body;

	/**
	 * @var The HTTP status code returned by the request.
	 */
	var $response_code;

	/**
	 * @var Additional response data.
	 */
	var $response_info;

	/**
	 * @var The handle for the CURL object.
	 */
	var $curl_handle;

	/**
	 * @var The method by which the request is being made.
	 */
	var $method;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructor
	 *
	 * Constructs a new instance of the TarzanHTTPRequest class.
	 *
	 * @access public
	 */
	public function __construct($url)
	{
		// Set some default values.
		$this->request_url = $url;
		$this->method = HTTP_GET;
		$this->request_headers = array();
		$this->curl_handle = curl_init();
		$this->request_body = '';
	}


	/*%******************************************************************************************%*/
	// REQUEST METHODS

	/**
	 * Add Header
	 * 
	 * Add a header to the CURL request.
	 * 
	 * @param string $key (Required) The HTTP header to set.
	 * @param string $value (Required) The value to set for the HTTP header.
	 * @return void
	 */
	public function addHeader($key, $value)
	{
		$this->request_headers[$key] = $value;
	}

	/**
	 * Remove Header
	 * 
	 * Remove a header from the CURL request.
	 * 
	 * @param string $key (Required) The HTTP header to set.
	 * @return void
	 */
	public function removeHeader($key)
	{
		if (isset($this->request_headers[$key]))
		{
			unset($this->request_headers[$key]);
		}
	}

	/**
	 * Set Method
	 * 
	 * Set the method by which to make the request.
	 * 
	 * @param string $method (Required) One of the following constants: HTTP_GET, HTTP_POST, HTTP_PUT, HTTP_HEAD, HTTP_DELETE.
	 * @return void
	 */
	public function setMethod($method)
	{
		$this->method = strtoupper($method);
	}

	/**
	 * Set Body
	 * 
	 * Set the body to send in the request.
	 * 
	 * @param string $body (Required) The text to send along in the body.
	 * @return void
	 */
	public function setBody($body)
	{
		$this->request_body = $body;
	}


	/*%******************************************************************************************%*/
	// SEND REQUEST

	/**
	 * Prepare Request
	 * 
	 * Determine the details of the CURL request to make. This can be passed along to a curl_multi_exec() function.
	 * 
	 * @return The handle for the CURL object.
	 */
	public function prepRequest()
	{
		$this->addHeader('Expect', '100-continue');
		$this->addHeader('Connection', 'close');

		// Set default options.
 		curl_setopt($this->curl_handle, CURLOPT_URL, $this->request_url);
		curl_setopt($this->curl_handle, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->curl_handle, CURLOPT_MAXREDIRS, 5);
		curl_setopt($this->curl_handle, CURLOPT_HEADER, true);
		curl_setopt($this->curl_handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl_handle, CURLOPT_TIMEOUT, 120);
		curl_setopt($this->curl_handle, CURLOPT_CONNECTTIMEOUT, 120);
		curl_setopt($this->curl_handle, CURLOPT_NOSIGNAL, true);
		curl_setopt($this->curl_handle, CURLOPT_REFERER, $this->request_url);
		curl_setopt($this->curl_handle, CURLOPT_USERAGENT, TARZAN_USERAGENT);

		// Handle the encoding if we can.
		if (extension_loaded('zlib'))
		{
			curl_setopt($this->curl_handle, CURLOPT_ENCODING, '');
		}

		// Process custom headers
		if (isset($this->request_headers) && count($this->request_headers))
		{
			$temp_headers = array();

			foreach ($this->request_headers as $k => $v)
			{
				$temp_headers[] = $k . ': ' . $v;
			}

			curl_setopt($this->curl_handle, CURLOPT_HTTPHEADER, $temp_headers);
		}

		switch ($this->method)
		{
			case HTTP_PUT:
				curl_setopt($this->curl_handle, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($this->curl_handle, CURLOPT_POSTFIELDS, $this->request_body);
				break;

			case HTTP_POST:
				curl_setopt($this->curl_handle, CURLOPT_POST, true);
				curl_setopt($this->curl_handle, CURLOPT_POSTFIELDS, $this->request_body);
				break;

			case HTTP_HEAD:
				curl_setopt($this->curl_handle, CURLOPT_CUSTOMREQUEST, HTTP_HEAD);
				curl_setopt($this->curl_handle, CURLOPT_NOBODY, 1);
				break;

			default:
				curl_setopt($this->curl_handle, CURLOPT_CUSTOMREQUEST, $this->method);
				break;
		}

		return $this->curl_handle;
	}

	/**
	 * Process Response
	 * 
	 * Take the post-processed CURL data and break it down into useful header/body/info chunks.
	 * 
	 * @return void
	 */
	public function processResponse()
	{
		// Determine what's what.
		$header_size = curl_getinfo($this->curl_handle, CURLINFO_HEADER_SIZE);
		$this->response_headers = substr($this->response, 0, $header_size);
		$this->response_body = substr($this->response, $header_size);
		$this->response_code = curl_getinfo($this->curl_handle, CURLINFO_HTTP_CODE);
		$this->response_info = curl_getinfo($this->curl_handle);

		// Parse out the headers
		$this->response_headers = explode("\r\n\r\n", trim($this->response_headers));
		$this->response_headers = array_pop($this->response_headers);
		$this->response_headers = explode("\r\n", $this->response_headers);
		array_shift($this->response_headers);

		// Loop through and split up the headers.
		$header_assoc = array();
		foreach ($this->response_headers as $header)
		{
			$kv = explode(': ', $header);
			$header_assoc[strtolower($kv[0])] = $kv[1];
		}

		// Reset the headers to the appropriate property.
		$this->response_headers = $header_assoc;
		$this->response_headers['_info'] = $this->response_info;
		$this->response_headers['_info']['method'] = $this->method;
	}

	/**
	 * Send Request
	 * 
	 * Sends the request, calling necessary utility functions to update built-in properties.
	 * 
	 * @return The resulting unparsed data from the request.
	 */
	public function sendRequest()
	{
		$this->prepRequest();
		$this->response = curl_exec($this->curl_handle);
		$this->processResponse();

		curl_close($this->curl_handle);
		return $this->response;
	}


	/*%******************************************************************************************%*/
	// RESPONSE METHODS

	/**
	 * Get Response Header
	 * 
	 * Get the response headers from the request.
	 * 
	 * @return array The response headers.
	 */
	public function getResponseHeader($header = null)
	{
		if ($header)
		{
			return $this->response_headers[strtolower($header)];
		}
		return $this->response_headers;
	}

	/**
	 * Get Response Body
	 * 
	 * Get the response body from the request.
	 * 
	 * @return string The response body.
	 */
	public function getResponseBody()
	{
		return $this->response_body;
	}

	/**
	 * Get Response Code
	 * 
	 * Get the HTTP response code from the request.
	 * 
	 * @return string The HTTP response code.
	 */
	public function getResponseCode()
	{
		return $this->response_code;
	}
}

?>