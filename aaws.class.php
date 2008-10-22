<?php
/**
 * File: Amazon AAWS
 * 	Amazon Associates Web Service (http://aws.amazon.com/associates)
 *
 * Version:
 * 	2008.10.21
 * 
 * Copyright:
 * 	2006-2008 LifeNexus Digital, Inc., and contributors.
 * 
 * License:
 * 	Simplified BSD License - http://opensource.org/licenses/bsd-license.php
 * 
 * See Also:
 * 	Tarzan - http://tarzan-aws.com
 * 	Amazon AAWS - http://aws.amazon.com/associates
 */


/*%******************************************************************************************%*/
// CONSTANTS

/**
 * Constant: AAWS_LOCALE_US
 * 	Locale code for the United States
 */
define('AAWS_LOCALE_US', 'us');

/**
 * Constant: AAWS_LOCALE_UK
 * 	Locale code for the United Kingdom
 */
define('AAWS_LOCALE_UK', 'uk');

/**
 * Constant: AAWS_LOCALE_CANADA
 * 	Locale code for Canada
 */
define('AAWS_LOCALE_CANADA', 'ca');

/**
 * Constant: AAWS_LOCALE_FRANCE
 * 	Locale code for France
 */
define('AAWS_LOCALE_FRANCE', 'fr');

/**
 * Constant: AAWS_LOCALE_GERMANY
 * 	Locale code for Germany
 */
define('AAWS_LOCALE_GERMANY', 'de');

/**
 * Constant: AAWS_LOCALE_JAPAN
 * 	Locale code for Japan
 */
define('AAWS_LOCALE_JAPAN', 'jp');


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonAAWS
 * 	Container for all Amazon AAWS-related methods. Inherits additional methods from TarzanCore.
 * 
 * Extends:
 * 	TarzanCore
 * 
 * Example Usage:
 * (start code)
 * require_once('tarzan.class.php');
 * 
 * // Instantiate a new AmazonAAWS object using the settings from the config.inc.php file.
 * $s3 = new AmazonAAWS();
 * 
 * // Instantiate a new AmazonAAWS object using these specific settings.
 * $s3 = new AmazonAAWS($key, $secret_key, $assoc_id);
 * (end)
 */
class AmazonAAWS extends TarzanCore
{
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
	 * 	key - _string_ (Optional) Your Amazon API Key. If blank, it will look for the <AWS_KEY> constant.
	 * 	secret_key - _string_ (Optional) Your Amazon API Secret Key. If blank, it will look for the <AWS_SECRET_KEY> constant.
	 * 	assoc_id - _string_ (Optional) Your Amazon Associates ID. If blank, it will look for the <AWS_ASSOC_ID> constant.
	 * 
	 * Returns:
	 * 	_boolean_ false if no valid values are set, otherwise true.
	 */
	public function __construct($key = null, $secret_key = null, $assoc_id = null)
	{
		$this->api_version = '2008-10-07';
		parent::__construct($key, $secret_key, null, $assoc_id);
	}


	/*%******************************************************************************************%*/
	// CORE FUNCTIONALITY

	/**
	 * Method: authenticate()
	 * 	Construct a URL to request from Amazon, request it, and return a formatted response.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	action - _string_ (Required) Indicates the action to perform.
	 * 	opt - _array_ (Optional) Associative array of parameters. See the individual methods for allowed keys.
	 * 	locale - _string_ (Optional) Which Amazon-supported locale do we use? Defaults to United States.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 */
	public function authenticate($action, $opt = null, $locale = AAWS_LOCALE_US)
	{
		// Determine the hostname
		switch ($locale)
		{
			// United Kingdom
			case AAWS_LOCALE_UK:
				$hostname = 'http://ecs.amazonaws.co.uk/';
				break;

			// Canada
			case AAWS_LOCALE_CANADA:
				$hostname = 'http://ecs.amazonaws.ca/';
				break;

			// France
			case AAWS_LOCALE_FRANCE:
				$hostname = 'http://ecs.amazonaws.fr/';
				break;

			// Germany
			case AAWS_LOCALE_GERMANY:
				$hostname = 'http://ecs.amazonaws.de/';
				break;

			// Japan
			case AAWS_LOCALE_JAPAN:
				$hostname = 'http://ecs.amazonaws.jp/';
				break;

			// Default to United States
			default:
				$hostname = 'http://ecs.amazonaws.com/';
				break;
		}

		// Send the request to the service.
		$request_url = $hostname . 'onca/xml?Service=AWSECommerceService&AWSAccessKeyId=' . $this->key . '&Operation=' . $action . '&' . $this->util->to_query_string($opt);
		$request =& new $this->request_class($request_url, $this->set_proxy);
		$request->sendRequest();

		// Prepare the response.
		$headers = $request->getResponseHeader();
		$headers['x-tarzan-requesturl'] = $request_url;
		$headers['x-tarzan-httpstatus'] = $request->getResponseCode();
		$data = new $this->response_class($headers, $request->getResponseBody(), $request->getResponseCode());

		// Return!
		return $data;
	}


	/*%******************************************************************************************%*/
	// BROWSE NODE LOOKUP

	/**
	 * Method: browse_node_lookup()
	 * 	Given a browse node ID, <browse_node_lookup()> returns the specified browse node's name, children, and ancestors. The names and browse node IDs of the children and ancestor browse nodes are also returned. <browse_node_lookup()> enables you to traverse the browse node hierarchy to find a browse node.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	browse_node_id - _integer_ (Required) A positive integer assigned by Amazon that uniquely identifies a product category.
	 * 	response_group - _string_ (Optional) Specifies the types of values to return. You can specify multiple response groups in one request by separating them with commas. Allows 'BrowseNodeInfo' (default), 'NewReleases', 'TopSellers'.
	 * 	locale - _string_ (Optional) Which Amazon-supported locale do we use? Defaults to United States.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 * 
	 * See Also:
	 * 	AWS Method - UPDATE
	 */
	public function browse_node_lookup($browse_node_id, $response_group = 'BrowseNodeInfo', $locale = AAWS_LOCALE_US)
	{
		$opt = array();
		$opt['BrowseNodeId'] = $browse_node_id;
		$opt['ResponseGroup'] = $response_group;

		return $this->authenticate('BrowseNodeLookup', $opt, $locale);
	}


	/*%******************************************************************************************%*/
	// CART METHODS

	/**
	 * 
	 */
	public function cart_add() {}

	/**
	 * 
	 */
	public function cart_clear() {}
	
	/**
	 * 
	 */
	public function cart_create() {}

	/**
	 * 
	 */
	public function cart_get() {}
	
	/**
	 * 
	 */
	public function cart_modify() {}


	/*%******************************************************************************************%*/
	// CUSTOMER CONTENT METHODS

	/**
	 * Method: customer_content_lookup()
	 * 	For a given customer ID, the <customer_content_lookup()> operation retrieves all of the information a customer has made public about themselves on Amazon. Such information includes some or all of the following: About Me, Birthday, City, State, Country, Customer Reviews, Customer ID, Name, Nickname, Wedding Registry, or WishList. To find a customer ID, use the <customer_content_search()> operation.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	customer_id - _string_ (Required) An alphanumeric token assigned by Amazon that uniquely identifies a customer. Only one customer_id can be submitted at a time in <customer_content_lookup()>.
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 	locale - _string_ (Optional) Which Amazon-supported locale do we use? Defaults to United States.
	 * 
	 * Keys for the $opt parameter:
	 * 	ReviewPage - _integer_ (Optional) A positive integer that specifies the page of reviews to read. There are ten reviews per page. For example, to read reviews 11 through 20, specify ReviewPage=2. The total number of pages is returned in the TotalPages response tag.
	 * 	TagPage - _integer_ (Optional) Specifies the page of results to return. There are ten results on a page. The maximum page number is 400.
	 * 	TagsPerPage - _integer_ (Optional) The number of tags to return that are associated with a specified item.
	 * 	TagSort - _string_ (Optional) Specifies the sorting order for the results. Allows 'FirstUsed', 'LastUsed', 'Name', or 'Usages' (default)
	 * 	ResponseGroup - _string_ (Optional) Specifies the types of values to return. You can specify multiple response groups in one request by separating them with commas. Allows 'CustomerInfo' (default), 'CustomerReviews', 'CustomerLists', 'CustomerFull', 'TaggedGuides', 'TaggedItems', 'TaggedListmaniaLists', 'TagsSummary', or 'Tags'.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 * 
	 * See Also:
	 * 	AWS Method - UPDATE
	 * 	Related - <customer_content_lookup()>, <customer_content_search()>
	 */
	public function customer_content_lookup($customer_id, $opt = null, $locale = AAWS_LOCALE_US)
	{
		if (!$opt) $opt = array();

		$opt['CustomerId'] = $customer_id;

		return $this->authenticate('CustomerContentLookup', $opt, $locale);
	}

	/**
	 * Method: customer_content_search()
	 * 	For a given customer Email address or name, the <customer_content_search()> operation returns matching customer IDs, names, nicknames, and residence information (city, state, and country). In general, supplying an Email address returns unique results whereas supplying a name more often returns multiple results.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	email_name - _string_ (Required) Either the email address or the name of the customer you want to look up the ID for.
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 	locale - _string_ (Optional) Which Amazon-supported locale do we use? Defaults to United States.
	 * 
	 * Keys for the $opt parameter:
	 * 	CustomerPage - _integer_ (Optional) A positive integer that specifies the page of customer IDs to return. Up to twenty customer IDs are returned per page. Defaults to 1.
	 * 	Email - _string_ (Optional) Besides the first parameter, you can set the email address here.
	 * 	Name - _string_ (Optional) Besides the first parameter, you can set the name here.
	 * 	ResponseGroup - _string_ (Optional) Specifies the types of values to return. You can specify multiple response groups in one request by separating them with commas.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 * 
	 * See Also:
	 * 	AWS Method - UPDATE
	 * 	Related - <customer_content_lookup()>, <customer_content_search()>
	 */
	public function customer_content_search($email_name, $opt = null, $locale = AAWS_LOCALE_US)
	{
		if (!$opt) $opt = array();

		if (!isset($opt['CustomerPage']) || empty($opt['CustomerPage']))
		{
			$opt['CustomerPage'] = 1;
		}

		if (strpos($email_name, '@'))
		{
			$opt['Email'] = $email_name;
		}
		else
		{
			$opt['Name'] = $email_name;
		}

		return $this->authenticate('CustomerContentSearch', $opt, $locale);
	}


	/*%******************************************************************************************%*/
	// HELP

	/**
	 * Method: help()
	 * 	The Help operation provides information about AAWS operations and response groups. For operations, Help lists required and optional request parameters, as well as default and optional response groups the operation can use. For response groups, Help lists the operations that can use the response group as well as the response tags returned by the response group in the XML response.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 	locale - _string_ (Optional) Which Amazon-supported locale do we use? Defaults to United States.
	 * 
	 * Keys for the $opt parameter:
	 * 	About - _string_ (Optional) Specifies the operation or response group about which you want more information. Allows all AAWS operations, all AAWS response groups.
	 * 	HelpType - _string_ (Optional) Specifies whether the help topic is an operation or response group. HelpType and About values must both be operations or response groups, not a mixture of the two. Allows 'Operation' or 'ResponseGroup'.
	 * 	ResponseGroup - _string_ (Optional) Specifies the types of values to return. You can specify multiple response groups in one request by separating them with commas. Allows 'Request' or 'Help'.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 * 
	 * See Also:
	 * 	AWS Method - UPDATE
	 */
	public function help($opt = null, $locale = AAWS_LOCALE_US)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('Help', $opt, $locale);
	}


	/*%******************************************************************************************%*/
	// ITEM METHODS

	/**
	 * Method: item_lookup()
	 * 	Given an Item identifier, the ItemLookup operation returns some or all of the item attributes, depending on the response group specified in the request. By default, <item_lookup()> returns an item’s ASIN, DetailPageURL, Manufacturer, ProductGroup, and Title of the item.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	item_id - _string_ (Required) A positive integer that unique identifies an item. The meaning of the number is specified by IdType. That is, if IdType is ASIN, the ItemId value is an ASIN. If ItemId is an ASIN, a search index cannot be specified in the request.
	 * 	opt - _array_ (Optional) Associative array of parameters. There are a large number available, so check the Amazon documentation page for details.
	 * 	locale - _string_ (Optional) Which Amazon-supported locale do we use? Defaults to United States.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 * 
	 * See Also:
	 * 	AWS Method - UPDATE
	 * 	Related - <item_lookup()>, <item_search()>
	 */
	public function item_lookup($item_id, $opt = null, $locale = AAWS_LOCALE_US)
	{
		if (!$opt) $opt = array();

		$opt['ItemId'] = $item_id;

		return $this->authenticate('ItemLookup', $opt, $locale);
	}

	/**
	 * Method: item_search()
	 * 	The <item_search()> operation returns items that satisfy the search criteria, including one or more search indices. <item_search()> is the operation that is used most often in requests. In general, when trying to find an item for sale, you use this operation.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	keywords - _string_ (Required) A word or phrase associated with an item. The word or phrase can be in various product fields, including product title, author, artist, description, manufacturer, and so forth. When, for example, the search index equals "MusicTracks", the Keywords parameter enables you to search by song title.
	 * 	opt - _array_ (Optional) Associative array of parameters. There are a large number available, so check the Amazon documentation page for details.
	 * 	locale - _string_ (Optional) Which Amazon-supported locale do we use? Defaults to United States.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 * 
	 * See Also:
	 * 	AWS Method - UPDATE
	 * 	Related - <item_lookup()>, <item_search()>
	 */
	public function item_search($keywords, $opt = null, $locale = AAWS_LOCALE_US)
	{
		if (!$opt) $opt = array();

		$opt['Keywords'] = $keywords;

		// Default to 'All' if nothing else has been sent.
		if (!isset($opt['SearchIndex']) || empty($opt['SearchIndex']))
		{
			$opt['SearchIndex'] = 'All';
		}

		return $this->authenticate('ItemSearch', $opt, $locale);
	}


	/*%******************************************************************************************%*/
	// LIST METHODS

	/**
	 * Method: list_lookup()
	 * 	The <list_lookup()> operation returns, by default, summary information about a list that you specify in the request.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	list_id - _string_ (Required) Number that uniquely identifies a list.
	 * 	list_type - _string_ (Required) Type of list. Accepts 'WeddingRegistry', 'Listmania', 'WishList'.
	 * 	opt - _array_ (Optional) Associative array of parameters. There are a large number available, so check the Amazon documentation page for details.
	 * 	locale - _string_ (Optional) Which Amazon-supported locale do we use? Defaults to United States.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 * 
	 * See Also:
	 * 	AWS Method - UPDATE
	 * 	Related - <list_lookup()>, <list_search()>
	 */
	public function list_lookup($list_id, $list_type, $opt = null, $locale = AAWS_LOCALE_US)
	{
		if (!$opt) $opt = array();

		$opt['ListId'] = $list_id;
		$opt['ListType'] = $list_type;

		return $this->authenticate('ListLookup', $opt, $locale);
	}

	/**
	 * Method: list_search()
	 * 	Given a customer name or Email address, the <list_search()> operation returns the associated list ID(s) but not the list items. To find those, use the list ID returned by <list_search()> with <list_lookup()>.
	 * 
	 * 	Specifying a full name or just a first or last name in the request typically returns multiple lists belonging to different people. Using Email as the identifier produces more filtered results.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	opt - _array_ (Optional) Associative array of parameters. There are a large number available, so check the Amazon documentation page for details.
	 * 	locale - _string_ (Optional) Which Amazon-supported locale do we use? Defaults to United States.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 * 
	 * See Also:
	 * 	AWS Method - UPDATE
	 * 	Related - <list_lookup()>, <list_search()>
	 */
	public function list_search($opt = null, $locale = AAWS_LOCALE_US)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ListSearch', $opt, $locale);
	}


	/*%******************************************************************************************%*/
	// SELLER METHODS

	/**
	 * Method: seller_listing_lookup()
	 * 	Enables you to return information about a seller's listings, including product descriptions, availability, condition, and quantity available. The response also includes the seller's nickname. Each request requires a seller ID.
	 * 
	 * 	You can also find a seller's items using ItemLookup. There are, however, some reasons why it is better to use <seller_listing_lookup()>: (a) <seller_listing_lookup()> enables you to search by seller ID. (b) <seller_listing_lookup()> returns much more information than <item_lookup()>.
	 * 
	 * 	This operation only works with sellers who have less than 100,000 items for sale. Sellers that have more items for sale should use, instead of Amazon Associates Web Service, other APIs, including the Amazon Inventory Management System, and the Merchant@ API.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	item_id - _string_ (Optional) Number that uniquely identifies an item. The valid value depends on the value for IdType. Allows an Exchange ID, a Listing ID, an ASIN, or a SKU.
	 * 	id_type - _string_ (Optional) Use the IdType parameter to specify the value type of the Id parameter value. If you are looking up an Amazon Marketplace item, use Exchange, ASIN, or SKU as the value for IdType. Discontinued, out of stock, or unavailable products will not be returned if IdType is Listing, SKU, or ASIN. Those products will be returned, however, if IdType is Exchange. Allows 'Exchange', 'Listing', 'ASIN', 'SKU'.
	 * 	seller_id - _string_ (Optional) Alphanumeric token that uniquely identifies a seller. This parameter limits the results to a single seller ID.
	 * 	response_group - _string_ (Optional) Specifies the types of values to return. You can specify multiple response groups in one request by separating them with commas.
	 * 	locale - _string_ (Optional) Which Amazon-supported locale do we use? Defaults to United States.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 * 
	 * See Also:
	 * 	AWS Method - UPDATE
	 * 	Related - <seller_listing_search()>, <seller_lookup()>
	 */
	public function seller_listing_lookup($item_id, $id_type, $seller_id, $response_group = 'SellerListing', $locale = AAWS_LOCALE_US)
	{
		$opt = array();
		$opt['Id'] = $item_id;
		$opt['IdType'] = $id_type;
		$opt['SellerId'] = $seller_id;
		$opt['ResponseGroup'] = $response_group;

		return $this->authenticate('SellerListingLookup', $opt, $locale);
	}

	/**
	 * Method: seller_listing_search()
	 * 	Enables you to search for items offered by specific sellers. You cannot use <seller_listing_search()> to look up items sold by merchants. To look up an item sold by a merchant, use <item_lookup()> or <item_search()> along with the MerchantId parameter.
	 * 
	 * 	<seller_listing_search()> returns the listing ID or exchange ID of an item. Typically, you use those values with <seller_listing_lookup()> to find out more about those items.
	 * 
	 * 	Each request returns up to ten items. By default, the first ten items are returned. You can use the ListingPage parameter to retrieve additional pages of (up to) ten listings. To use Amazon Associates Web Service, sellers must have less than 100,000 items for sale. Sellers that have more items for sale should use, instead of Amazon Associates Web Service, other seller APIs, including the Amazon Inventory Management System, and the Merchant@ API.
	 * 
	 * 	<seller_listing_search()> requires a seller ID, which means that you cannot use this operation to search across all sellers. Amazon Associates Web Service does not have a seller-specific operation that does this. To search across all sellers, use <item_lookup()> or <item_search()>.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	seller_id - _string_ (Required) An alphanumeric token that uniquely identifies a seller. These tokens are created by Amazon and distributed to sellers.
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 	locale - _string_ (Optional) Which Amazon-supported locale do we use? Defaults to United States.
	 * 
	 * Keys for the $opt parameter:
	 * 	ListingPage - _integer_ (Optional) Page of the response to return. Up to ten lists are returned per page. For customers that have more than ten lists, more than one page of results are returned. By default, the first page is returned. To return another page, specify the page number. Allows 1 through 500.
	 * 	OfferStatus - _string_ (Optional) Specifies whether the product is available (Open), or not (Closed.) Closed products are those that are discontinued, out of stock, or unavailable. Defaults to 'Open'.
	 * 	Sort - _string_ (Optional) Use the Sort parameter to specify how your seller listing search results will be ordered. The -bfp (featured listings - default), applies only to the US, UK, and DE locales. Allows '-startdate', 'startdate', '+startdate', '-enddate', 'enddate', '-sku', 'sku', '-quantity', 'quantity', '-price', 'price |+price', '-title', 'title'.
	 * 	Title - _string_ (Optional) Searches for products based on the product's name. Keywords and Title are mutually exclusive; you can have only one of the two in a request.
	 * 	ResponseGroup - _string_ (Optional) Specifies the types of values to return. You can specify multiple response groups in one request by separating them with commas.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 * 
	 * See Also:
	 * 	AWS Method - UPDATE
	 * 	Related - <seller_listing_lookup()>, <seller_lookup()>
	 */
	public function seller_listing_search($seller_id, $opt = null, $locale = AAWS_LOCALE_US)
	{
		if (!$opt) $opt = array();

		$opt['SellerId'] = $seller_id;

		return $this->authenticate('SellerListingSearch', $opt, $locale);
	}

	/**
	 * Method: seller_lookup()
	 * 	Returns detailed information about sellers and, in the US locale, merchants. To lookup a seller, you must use their seller ID. The information returned includes the seller's name, average rating by customers, and the first five customer feedback entries. <seller_lookup()> will not, however, return the seller's e-mail or business addresses.
	 * 
	 * A seller must enter their information. Sometimes, sellers do not. In that case, <seller_lookup()> cannot return some seller-specific information.
	 * 
	 * To look up more than one seller in a single request, insert a comma-delimited list of up to five seller IDs in the SellerId parameter of the REST request. Customers can rate sellers. 5 is the best rating; 0 is the worst. The rating reflects the customer's experience with the seller. The <seller_lookup()> operation, by default, returns review comments by individual customers.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	seller_id - _string_ (Required) An alphanumeric token that uniquely identifies a seller. These tokens are created by Amazon and distributed to sellers.
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 	locale - _string_ (Optional) Which Amazon-supported locale do we use? Defaults to United States.
	 * 
	 * Keys for the $opt parameter:
	 * 	FeedbackPage - _string_ (Optional) Specifies the page of reviews to return. Up to five reviews are returned per page. The first page is returned by default. To access additional pages, use this parameter to specify the desired page. The maximum number of pages that can be returned is 10 (50 feedback items). Allows 1 through 10.
	 * 	ResponseGroup - _string_ (Optional) Specifies the types of values to return. You can specify multiple response groups in one request by separating them with commas.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
	 * 
	 * See Also:
	 * 	AWS Method - UPDATE
	 * 	Related - <seller_listing_lookup()>, <seller_listing_search()>
	 */
	public function seller_lookup($seller_id, $opt = null, $locale = AAWS_LOCALE_US)
	{
		if (!$opt) $opt = array();

		$opt['SellerId'] = $seller_id;

		return $this->authenticate('SellerLookup', $opt, $locale);
	}


	/*%******************************************************************************************%*/
	// VEHICLE METHODS

	/**
	 * 
	 */
	public function vehicle_part_lookup() {}

	/**
	 * 
	 */
	public function vehicle_part_search() {}

	/**
	 * 
	 */
	public function vehicle_search() {}


	/*%******************************************************************************************%*/
	// OTHER LOOKUP METHODS

	/**
	 * 
	 */
	function similarity_lookup() {}

	/**
	 * 
	 */
	function tag_lookup() {}

	/**
	 * 
	 */
	function transaction_lookup() {}
}
?>