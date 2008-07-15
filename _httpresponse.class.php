<?php
/**
 * TARZAN HTTP RESPONSE
 * Standard HTTP response handler.
 *
 * @category Tarzan
 * @package TarzanHTTPResponse
 * @version 2008.04.20
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.com Tarzan
 * @see README
 */


/*%******************************************************************************************%*/
// CLASS

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
	 * Store the HTTP response code.
	 */
	var $status;

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
	public function __construct($header, $body, $status = null)
	{
		$this->header = $header;
		$this->body = $body;
		$this->status = $status;

		if (isset($body))
		{
			// If the response is XML data, parse it.
			if (substr(ltrim($body), 0, 5) == '<?xml')
			{
				$this->body = new SimpleXMLElement($body);
			}
		}

		return $this;
	}

	/**
	 * isOK
	 * 
	 * Did we receive the status code we expected?
	 * 
	 * @param mixed $codes (Optional) The status code(s) to expect. Integer for a single accepted value, or an array of integers for multiple accepted values.
	 * @return boolean Whether we received the expected code or not.
	 */
	public function isOK($codes = 200)
	{
		if (is_array($codes))
		{
			return in_array($this->status, $codes);
		}
		else
		{
			return ($this->status == $codes);
		}
	}
}
?>