<?php

/**
 * Instantiate a new CacheCore instance.
 */
$cache = new CacheFile('cache_obj', './cache', 10); // File-based caching
/* OR */
$cache = new CacheAPC('cache_obj', 'apc', 10); // APC-based caching
/* OR */
$cache = new CachePDO('cache_obj', 'sqlite://tarzan_cache.db', 10); // PDO caching (using SQLite)


/**
 * Memcached caching (available in upcoming version 2.1 or in the trunk @ r228). 
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
 * This is the function that is used to fetch new data. It accepts a URL as its 
 * only parameter. If SUCCESS, return the data. If FAIL, return null.
 */
function fetch_the_fresh_data($url)
{
	$request = new RequestCore($url);

	if ($data = $request->send_request())
	{
		return $data->body;
	}

	return null;
}


/**
 * Old and busted...
 * 
 * This will always fetch the data from the source, which can be very slow.
 */
$data = fetch_the_fresh_data('http://example.com/endpoint');


/**
 * New hotness...
 * 
 * The response manager will seamlessly give you your data -- using the cache when 
 * it can, and fetching it fresh from the source upon expiration.
 */
$data = $cache->response_manager('fetch_the_fresh_data', array(
	'http://example.com/endpoint'
));

?>