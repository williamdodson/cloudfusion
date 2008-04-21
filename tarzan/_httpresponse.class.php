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
 * @link http://tarzan-aws.googlecode.com Tarzan
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