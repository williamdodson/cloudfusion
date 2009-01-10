<?php

/**
 * Instantiate a new CacheCore instance.
 */
$cache = new CacheFile('cache_obj', './cache', 10); // File-based caching
/* OR */
$cache = new CacheAPC('cache_obj', 'apc', 10); // APC-based caching
/* OR */
$cache = new CachePDO('cache_obj', 'sqlite://tarzan_cache.db', 10); // PDO caching (using SQLite)

/* OR */

/**
 * Memcached caching (available in upcoming version 2.0 or in the trunk @ r228). 
 * Location is an indexed array of associative arrays. Each associative array 
 * has a 'host' and a 'port' representing a server to add to the server pool.
 */
$cache = new CacheMC('cache_obj', array(
	array(
		'host' => 'localhost',
		'port' => 11211
	)
), 10);


/**
 * Example that uses all of the various methods.
 */
$request = new RequestCore('http://example.com/endpoint');

// Does a cache already exist, and can we read it?
if ($data = $cache->read())
{
	// We can read it, but is it expired?
	if ($cache->is_expired())
	{
		// Let's re-fetch fresh data
		if ($data = $request->sendRequest())
		{
			// ...and update the existing cache with it.
			$cache->update($request->getResponseBody());
		}

		// Re-fetch was unsuccessful for whatever reason
		else
		{
			// ...so we'll reset the cache's expiration counter to zero.
			$cache->reset();
		}
	}
}

// Cache does not already exist, so let's create it.
else
{
	// Let's fetch fresh data
	if ($data = $request->sendRequest())
	{
		// ...and create a new cache.
		$cache->create($request->getResponseBody());
	}
}

?>