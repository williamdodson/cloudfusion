<?php
/**
 * File: CachePDO
 * 	Database-based caching class using PHP Data Objects (PDO).
 *
 * Version:
 * 	2008.10.09
 * 
 * Copyright:
 * 	2006-2008 LifeNexus Digital, Inc., and contributors.
 * 
 * License:
 * 	Simplified BSD License - http://opensource.org/licenses/bsd-license.php
 * 
 * See Also:
 * 	Tarzan - http://tarzan-aws.com
 * 	PDO - http://php.net/pdo
 */


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: CachePDO
 * 	Container for all PDO-based cache methods. Inherits additional methods from CacheCore.
 */
class CachePDO extends CacheCore
{
	/**
	 * Property: pdo
	 * 	Reference to the PDO connection object.
	 */
	var $pdo = null;

	/**
	 * Property: dsn
	 * 	Holds the parsed URL components.
	 */
	var $dsn = null;

	/**
	 * Property: dsn_string
	 * 	Holds the PDO-friendly version of the connection string.
	 */
	var $dsn_string = null;

	/**
	 * Property: create
	 * 	Holds the prepared statement for creating an entry.
	 */
	var $create = null;

	/**
	 * Property: read
	 * 	Holds the prepared statement for reading an entry.
	 */
	var $read = null;

	/**
	 * Property: update
	 * 	Holds the prepared statement for updating an entry.
	 */
	var $update = null;

	/**
	 * Property: reset
	 * 	Holds the prepared statement for resetting the expiry of an entry.
	 */
	var $reset = null;

	/**
	 * Property: delete
	 * 	Holds the prepared statement for deleting an entry.
	 */
	var $delete = null;

	/**
	 * Property: store_read
	 * 	Holds the response of the read so we only need to fetch it once instead of doing multiple queries.
	 */
	var $store_read = null;


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
	 * 	name - _string_ (Required) A name to uniquely identify the cache object.
	 * 	location - _string_ (Required) The location to store the cache object in. This may vary by cache method.
	 * 	expires - _integer_ (Required) The number of seconds until a cache object is considered stale.
	 * 
	 * Returns:
	 * 	_object_ Reference to the cache object.
	 */
	public function __construct($name, $location, $expires)
	{
		// Call parent constructor and set id.
		parent::__construct($name, $location, $expires);
		$this->id = $this->name;
		// $this->expires_sql = date(DATE_AWS_MYSQL);

		// Parse and set the DSN
		$this->dsn = parse_url($location);
		$this->dsn_string = $this->dsn['scheme'] . ':host=' . $this->dsn['host'] . ((isset($this->dsn['port'])) ? ';port=' . $this->dsn['port'] : '') . ';dbname=' . substr($this->dsn['path'], 1);

		// Instantiate a new PDO object
		$this->pdo = new PDO($this->dsn_string, $this->dsn['user'], $this->dsn['pass'], array(
			PDO::ATTR_PERSISTENT => true
		));

		// Define prepared statements
		$this->create = $this->pdo->prepare("INSERT INTO cache (id, data) VALUES (:id, :data)");
		$this->read = $this->pdo->prepare("SELECT id, expires, data FROM cache WHERE id = :id");
		$this->update = $this->pdo->prepare("UPDATE cache SET data = :data WHERE id = :id");
		$this->reset = $this->pdo->prepare("UPDATE cache SET :expires = NOW() WHERE id = :id");
		$this->delete = $this->pdo->prepare("DELETE FROM cache WHERE id = :id");
	}

	/**
	 * Method: create()
	 * 	Creates a new cache.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	data - _mixed_ (Required) The data to cache.
	 * 
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 */
	public function create($data)
	{
		$this->create->bindParam(':id', $this->id);
		$this->create->bindParam(':data', serialize($data));
		return (bool) $this->create->execute();
	}

	/**
	 * Method: read()
	 * 	Reads a cache.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Returns:
	 * 	_mixed_ Either the content of the cache object, or _boolean_ false.
	 */
	public function read()
	{
		if (!$this->store_read)
		{
			$this->read->bindParam(':id', $this->id);
			$this->read->execute();
			$this->store_read = $this->read->fetch(PDO::FETCH_ASSOC);
		}

		if ($this->store_read)
		{
			return unserialize($this->store_read['data']);
		}

		return false;
	}

	/**
	 * Method: update()
	 * 	Updates an existing cache.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	data - _mixed_ (Required) The data to cache.
	 * 
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 */
	public function update($data)
	{
		$this->create->bindParam(':id', $this->id);
		$this->create->bindParam(':data', serialize($data));
		return (bool) $this->update->execute();
	}

	/**
	 * Method: delete()
	 * 	Deletes a cache.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 */
	public function delete()
	{
		$this->delete->bindParam(':id', $this->id);
		return $this->delete->execute();
	}

	/**
	 * Method: timestamp()
	 * 	Retrieves the timestamp of the cache.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Returns:
	 * 	_mixed_ Either the Unix timestamp of the cache creation, or _boolean_ false.
	 */
	public function timestamp()
	{
		if (!$this->store_read)
		{
			$this->read->bindParam(':id', $this->id);
			$this->read->execute();
			$this->store_read = $this->read->fetch(PDO::FETCH_ASSOC);
		}

		if ($this->store_read)
		{
			return date('U', strtotime($this->store_read['expires']));
		}

		return false;
	}

	/**
	 * Method: reset()
	 * 	Resets the freshness of the cache.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Returns:
	 * 	_boolean_ Whether the operation was successful.
	 */
	public function reset()
	{
		$this->create->bindParam(':id', $this->id);
		return (bool) $this->reset->execute();
	}

	/**
	 * Method: is_expired()
	 * 	Checks whether the cache object is expired or not.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Returns:
	 * 	_boolean_ Whether the cache is expired or not.
	 */
	public function is_expired()
	{
		if ($this->timestamp() + $this->expires < time())
		{
			return true;
		}

		return false;
	}
}
?>