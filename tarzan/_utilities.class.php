<?php
/**
 * TARZAN UTILITIES
 * Common Tarzan functionality.
 *
 * @category Tarzan
 * @package TarzanUtilities
 * @version 2008.04.20
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.googlecode.com Tarzan
 * @see README
 */


/*%******************************************************************************************%*/
// CLASS

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

	/**
	 * Time in Hours:Minutes:Seconds
	 *
	 * @param int $seconds (Required) The number of seconds to convert.
	 * @return string The formatted time.
	 */
	function time_hms($seconds)
	{
		$time = '';

		$hours = floor($seconds / 3600);
		$remainder = $seconds % 3600;
		if ($hours > 0)
		{
			$time .= $hours.':';
		}

		$minutes = floor($remainder / 60);
		$seconds = $remainder % 60;
		if ($minutes < 10 && $hours > 0)
		{
			$minutes = '0' . $minutes;
		}
		if ($seconds < 10)
		{
			$seconds = '0' . $seconds;
		}

		$time .= $minutes.':';
		$time .= $seconds;

		return $time;
	}
}
?>