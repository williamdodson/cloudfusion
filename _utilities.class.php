<?php
/**
 * File: TarzanUtilities
 * 	Utilities for connecting to, and working with, AWS.
 *
 * Version:
 * 	2008.09.29
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
// CLASS

/**
 * Class: TarzanUtilities
 * 	Container for all utility-related methods.
 */
class TarzanUtilities
{
	/**
	 * Method: __construct()
	 * 	The constructor
	 * 
	 * Access:
	 * 	public
	 * 
	 * Returns:
	 * 	<TarzanUtilities> object
	 */
	public function __construct()
	{
		return $this;
	}

	/**
	 * Method: ready()
	 * 	Check if a value (such as a GET or POST parameter or an array value) has a real, non-empty value.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	var - _array_ (Required) The value to check.
	 * 
	 * Returns:
	 * 	_boolean_ Whether this has a real value.
	 */
	public function ready($var)
	{
		return (isset($var) && !empty($var)) ? true : false;
	}

	/**
	 * Method: hex_to_base64()
	 * 	Convert a HEX value to Base64.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	str - _string_ (Required) Value to convert.
	 * 
	 * Returns:
	 * 	_string_ Base64-encoded string.
	 */
	public function hex_to_base64($str)
	{
		$raw = '';

		for ($i = 0; $i < strlen($str); $i += 2)
		{
			$raw .= chr(hexdec(substr($str, $i, 2)));
		}

		return base64_encode($raw);
	}

	/**
	 * Method: to_query_string()
	 * 	Convert an associative array into a query string.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	array - _array_ (Required) Array to convert.
	 * 
	 * Returns:
	 * 	_string_ URL-friendly query string.
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
	 * Method: to_signable_string()
	 * 	Convert an associative array into a sign-able string.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	array - _array_ (Required) Array to convert.
	 * 
	 * Returns:
	 * 	_string_ URL-friendly sign-able string.
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
	 * Method: query_to_array()
	 * 	Convert a query string into an associative array. Multiple, identical keys will become an indexed array.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	qs - _string_ (Required) Query string to convert.
	 * 
	 * Returns:
	 * 	_array_ Associative array of keys and values.
	 * 
	 * Example Usage:
	 * (start code)
	 * // This query string...
	 * ?key1=value&key1=value&key2=value
	 * 
	 * // Will become this array...
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
	 * (end)
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
	 * Method: size_readable()
	 * 	Return human readable file sizes. Original function by Aidan Lister <mailto:aidan@php.net>, modified by Ryan Parman.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	size - _integer_ (Required) Filesize in bytes.
	 * 	unit - _string_ (Optional) The maximum unit to use. Defaults to the largest appropriate unit.
	 * 	retstring - _string_ (Optional) The format for the return string. Defaults to '%01.2f %s'
	 * 
	 * Returns:
	 * 	_string_ The human-readable file size.
	 * 
	 * See Also:
	 * 	Original Function - http://aidanlister.com/repos/v/function.size_readable.php
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
	 * Method: time_hms()
	 * 	Convert a number of seconds into Hours:Minutes:Seconds.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	seconds - _integer_ (Required) The number of seconds to convert.
	 * 
	 * Returns:
	 * 	_string_ The formatted time.
	 */
	function time_hms($seconds)
	{
		$time = '';

		$hours = floor($seconds / 3600);
		$remainder = $seconds % 3600;

		if ($hours > 0)
		{
			$time .= $hours . ':';
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

		$time .= $minutes . ':';
		$time .= $seconds;

		return $time;
	}

	/**
	 * Method: try_these()
	 * 	Returns the first value that is set. Based on Try.these() from Prototype <http://prototypejs.org>.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	attrs - _array_ (Required) The attributes to test, as strings. Intended for testing properties of the $base object, but also works with variables if you place an @ symbol at the beginning of the command.
	 * 	base - _object_ (Optional) The base object to use, if any.
	 * 	default - _mixed_ (Optional) What to return if there are no matches. Defaults to null.
	 * 
	 * Returns:
	 * 	_mixed_ Either a matching property of a given object, _boolean_ false, or any other data type you might choose.
	 */
	function try_these($attrs, $base = null, $default = null)
	{
		if ($base)
		{
			foreach ($attrs as $attr)
			{
				if (isset($base->$attr))
				{
					return $base->$attr;
				}
			}
		}
		else
		{
			foreach ($attrs as $attr)
			{
				if (isset($attr))
				{
					return $attr;
				}
			}
		}

		return $default;
	}
}
?>