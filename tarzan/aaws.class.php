<?php
/**
 * AMAZON ASSOCIATES WEB SERVICE (AAWS)
 * (formerly known as E-Commerce Service (ECS) 4.0)
 * http://aws.amazon.com/ecs
 *
 * @category Tarzan
 * @package AAWS
 * @version 2008.04.18
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.googlecode.com Tarzan
 * @link http://aws.amazon.com/ecs Amazon AAWS
 * @see README
 */


/*%******************************************************************************************%*/
// CONSTANTS

/**
 * Locale code for the United States
 */
define('AAWS_LOCALE_US', 'us');

/**
 * Locale code for the United Kingdom
 */
define('AAWS_LOCALE_UK', 'uk');

/**
 * Locale code for Canada
 */
define('AAWS_LOCALE_CANADA', 'ca');

/**
 * Locale code for France
 */
define('AAWS_LOCALE_FRANCE', 'fr');

/**
 * Locale code for Germany
 */
define('AAWS_LOCALE_GERMANY', 'de');

/**
 * Locale code for Japan
 */
define('AAWS_LOCALE_JAPAN', 'jp');


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Container for all Amazon AAWS-related methods.
 */
class AmazonAAWS extends TarzanCore
{
	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->api_version = '2007-10-29';
		parent::__construct();
	}


	/*%******************************************************************************************%*/
	// CORE FUNCTIONALITY

	/**
	 * Authenticate
	 *
	 * Construct a URL to request from Amazon, request it, and return a formatted response.
	 *
	 * @access public
	 * @param string $action (Required) Indicates the action to perform.
	 * @param array $opt (Optional) Settings to use for the request.
	 * @param string $locale (Optional) Which Amazon-supported locale do we use?
	 * @return object A TarzanHTTPResponse response object.
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
			case AAWS_LOCALE_CA:
				$hostname = 'http://ecs.amazonaws.ca/';
				break;

			// France
			case AAWS_LOCALE_FR:
				$hostname = 'http://ecs.amazonaws.fr/';
				break;

			// Germany
			case AAWS_LOCALE_DE:
				$hostname = 'http://ecs.amazonaws.de/';
				break;

			// Japan
			case AAWS_LOCALE_JP:
				$hostname = 'http://ecs.amazonaws.jp/';
				break;

			// Default to United States
			default:
				$hostname = 'http://ecs.amazonaws.com/';
				break;
		}

		// Send the request to the service.
		$request_url = $hostname . 'onca/xml?Service=AWSECommerceService&AWSAccessKeyId=' . $this->key . '&Operation=' . $operation . '&' . $this->util->to_query_string($opt);
		$request =& new HTTP_Request($request_url);
		$request->addHeader('User-Agent', TARZAN_USERAGENT);
		$request->sendRequest();

		// Prepare the response.
		$headers = $request->getResponseHeader();
		$headers['x-amz-requesturl'] = $request_url;
		$headers['x-amz-httpstatus'] = $request->getResponseCode();
		$data = new TarzanHTTPResponse($headers, $request->getResponseBody());

		// Return!
		return $data;
	}


	/*%******************************************************************************************%*/
	// BROWSE NODE LOOKUP

	/**
	 * Browse Node Lookup
	 * 
	 * Given a browse node ID, BrowseNodeLookup returns the specified browse node’s name, children, 
	 * and ancestors. The names and browse node IDs of the children and ancestor browse nodes are 
	 * also returned. BrowseNodeLookup enables you to traverse the browse node hierarchy to find a 
	 * browse node.
	 *
	 * @access public
	 * @param integer $browse_node_id (Required) A positive integer assigned by Amazon that uniquely identifies a product category.
	 * @param string $response_group (Optional) Specifies the types of values to return. You can specify multiple response groups in one request by separating them with commas. Allows 'BrowseNodeInfo' (default), 'NewReleases', 'TopSellers'.
	 * @param string $locale (Optional) Which Amazon-supported locale do we use?
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSECommerceService/2007-10-29/DG/BrowseNodeLookup.html
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
	 * Cart Add
	 * 
	 * The CartAdd operation enables you to add items to an existing remote shopping cart. CartAdd 
	 * can only be used to place a new item in a shopping cart. It cannot be used to increase the 
	 * quantity of an item already in the cart. If you would like to increase the quantity of an 
	 * item that is already in the cart, you must use the CartModify operation.
	 * 
	 * To add items to a cart, you must specify the cart using the CartId and HMAC values, which are 
	 * returned by the CartCreate operation.
	 *
	 * Two caveats: (1) Although the Amazon AAWS service allows for adding up to 10 items at once, 
	 * this method only supports adding one at a time because of how the rest of the API is 
	 * constructed. (2) The ASIN parameter discussed in the Amazon documentation is not supported 
	 * in this API. You MUST use OfferListingId instead as this is preferred by Amazon.
	 *
	 * @access public
	 * @param integer $offer_listing_id (Required) An offer listing ID is a token that uniquely identifies an item that is sold by any merchant, including Amazon. This parameter MUST be used as support for Amazon's ASIN parameter is not available in this API.
	 * @param integer $cart_id (Required) Alphanumeric token returned by CartCreate that identifies a cart.
	 * @param integer $hmac (Required) Hash Message Authentication Code returned by CartCreate that identifies a cart. This is an encrypted alphanumeric token that is used to authenticate cart operations.
	 * @param array $opt (Optional) Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string ListItemId - (Optional) The ListItemId value is returned by the ListItems response group. The value identifies an item on a list, such as a wishlist. To add this item to a cart, you must include in the CartAdd request the item's ASIN and ListItemId. The ListItemId attaches the name and address of the list owner, which the ASIN alone does not.</li>
	 *   <li>boolean MergeCart - (Optional) A boolean value that when True specifies that the items in a customer's remote shopping cart are added to the customer’s Amazon retail shopping cart. This occurs when the customer elects to purchase the items in their remote shopping cart. When the value is False (the default) the remote shopping cart contents are not added to the retail shopping cart. Instead, the customer is sent directly to the Order Pipeline when they elect to purchase the items in their cart. This parameter is valid only in the US locale. In all other locales, the value is always False.</li>
	 *   <li>integer Quantity - (Optional) Specifies number of items to be added to the cart where N is a positive integer between 1 and 999.</li>
	 *   <li>string ResponseGroup - (Optional) Specifies the types of values to return. You can specify multiple response groups in one request by separating them with commas.</li>
	 * </ul>
	 * @param string $locale (Optional) Which Amazon-supported locale do we use?
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSECommerceService/2007-10-29/DG/CartAdd.html
	 */
	public function cart_add($offer_listing_id, $cart_id, $hmac, $opt = null, $locale = AAWS_LOCALE_US)
	{
		$opt = array();

		// Convert the required values.
		$opt['Item.1.OfferListingId'] = $offer_listing_id;
		$opt['CartId'] = $cart_id;
		$opt['HMAC'] = $hmac;

		// Convert quantity to the correct format
		if (!isset($opt['Quantity']) || empty($opt['Quantity']))
		{
			$opt['Quantity'] = 1;
		}
		$opt['Item.1.Quantity'] = $opt['Quantity'];
		unset($opt['Quantity']);

		// Convert listitemid to the correct format.
		if (!isset($opt['ListItemId']) || empty($opt['ListItemId']))
		{
			$opt['Item.1.ListItemId'] = $opt['ListItemId'];
		}
		unset($opt['ListItemId']);

		return $this->authenticate('CartAdd', $opt, $locale);
	}

	/**
	 * Cart Clear
	 * 
	 * @todo Build this method. No work done on this yet.
	 */
	public function cart_clear() {}
	
	/**
	 * Cart Create
	 * 
	 * @todo Build this method. No work done on this yet.
	 */
	public function cart_create() {}	

	/**
	 * Cart Get
	 * 
	 * @todo Build this method. No work done on this yet.
	 */
	public function cart_get() {}
	
	/**
	 * Cart Modify
	 * 
	 * @todo Build this method. No work done on this yet.
	 */
	public function cart_modify() {}


	/*%******************************************************************************************%*/
	// CUSTOMER CONTENT METHODS

	/**
	 * Customer Content Lookup
	 * 
	 * For a given customer ID, the CustomerContentLookup operation retrieves all of the information 
	 * a customer has made public about themselves on Amazon. Such information includes some or all 
	 * of the following: About Me, Birthday, City, State, Country, Customer Reviews, Customer ID, 
	 * Name, Nickname, Wedding Registry, or WishList. To find a customer ID, use the 
	 * CustomerContentSearch operation.
	 *
	 * @access public
	 * @param string $customer_id (Required) An alphanumeric token assigned by Amazon that uniquely identifies a customer. Only one CustomerId can be submitted at a time in CustomerContentLookup.
	 * @param array $opt (Optional) Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>integer ReviewPage - (Optional) A positive integer that specifies the page of reviews to read. There are ten reviews per page. For example, to read reviews 11 through 20, specify ReviewPage=2. The total number of pages is returned in the TotalPages response tag.</li>
	 *   <li>integer TagPage - (Optional) Specifies the page of results to return. There are ten results on a page. The maximum page number is 400.</li>
	 *   <li>integer TagsPerPage - (Optional) The number of tags to return that are associated with a specified item.</li>
	 *   <li>string TagSort - (Optional) Specifies the sorting order for the results. Allows 'FirstUsed', 'LastUsed', 'Name', or 'Usages' (default).</li>
	 *   <li>string ResponseGroup - (Optional) Specifies the types of values to return. You can specify multiple response groups in one request by separating them with commas. Allows 'CustomerInfo' (default), 'CustomerReviews', 'CustomerLists', 'CustomerFull', 'TaggedGuides', 'TaggedItems', 'TaggedListmaniaLists', 'TagsSummary', or 'Tags'.</li>
	 * </ul>
	 * @param string $locale (Optional) Which Amazon-supported locale do we use?
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSECommerceService/2007-10-29/DG/CustomerContentLookup.html
	 */
	public function customer_content_lookup($customer_id, $opt = null, $locale = AAWS_LOCALE_US)
	{
		$opt = array();
		$opt['CustomerId'] = $customer_id;

		return $this->authenticate('CustomerContentLookup', $opt, $locale);
	}

	/**
	 * Customer Content Search
	 * 
	 * For a given customer Email address or name, the CustomerContentSearch operation returns 
	 * matching customer IDs, names, nicknames, and residence information (city, state, and country). 
	 * In general, supplying an Email address returns unique results whereas supplying a name more 
	 * often returns multiple results.
	 *
	 * @access public
	 * @param string $email_name (Required) Either the email address or the name of the customer you want to look up the ID for.
	 * @param array $opt (Optional) Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>integer CustomerPage - (Optional) A positive integer that specifies the page of customer IDs to return. Up to twenty customer IDs are returned per page. Defaults to 1.</li>
	 *   <li>string Email - (Optional) Besides the first parameter, you can set the email address here.</li>
	 *   <li>string Name - (Optional) Besides the first parameter, you can set the name here.</li>
	 *   <li>string ResponseGroup - (Optional) Specifies the types of values to return. You can specify multiple response groups in one request by separating them with commas.</li>
	 * </ul>
	 * @param string $locale (Optional) Which Amazon-supported locale do we use?
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSECommerceService/2007-10-29/DG/CustomerContentSearch.html
	 */
	public function customer_content_search($email_name, $opt = null, $locale = AAWS_LOCALE_US)
	{
		$opt = array();

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
	 * Help
	 * 
	 * The Help operation provides information about AAWS operations and response groups. For operations, 
	 * Help lists required and optional request parameters, as well as default and optional response 
	 * groups the operation can use. For response groups, Help lists the operations that can use the 
	 * response group as well as the response tags returned by the response group in the XML response.
	 *
	 * @access public
	 * @param array $opt (Optional) Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string About - (Optional) Specifies the operation or response group about which you want more information. Allows all AAWS operations, all AAWS response groups.</li>
	 *   <li>string HelpType - (Optional) Specifies whether the help topic is an operation or response group. HelpType and About values must both be operations or response groups, not a mixture of the two. Allows 'Operation' or 'ResponseGroup'.</li>
	 *   <li>string ResponseGroup - (Optional) Specifies the types of values to return. You can specify multiple response groups in one request by separating them with commas. Allows 'Request' or 'Help'.</li>
	 * </ul>
	 * @param string $locale (Optional) Which Amazon-supported locale do we use?
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSECommerceService/2007-10-29/DG/Help.html
	 */
	public function help($opt = null, $locale = AAWS_LOCALE_US)
	{
		return $this->authenticate('Help', $opt, $locale);
	}


	/*%******************************************************************************************%*/
	// ITEM METHODS

	/**
	 * Item Lookup
	 * 
	 * Given an Item identifier, the ItemLookup operation returns some or all of the item attributes, 
	 * depending on the response group specified in the request. By default, ItemLookup returns an 
	 * item’s ASIN, DetailPageURL, Manufacturer, ProductGroup, and Title of the item.
	 *
	 * @access public
	 * @param string $item_id (Required) A positive integer that unique identifies an item. The meaning of the number is specified by IdType. That is, if IdType is ASIN, the ItemId value is an ASIN. If ItemId is an ASIN, a search index cannot be specified in the request.
	 * @param array $opt (Optional) Associative array of parameters. There are a large number available, so check the Amazon documentation page for details.
	 * @param string $locale (Optional) Which Amazon-supported locale do we use?
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSECommerceService/2007-10-29/DG/ItemLookup.html
	 */
	public function item_lookup($item_id, $opt = null, $locale = AAWS_LOCALE_US)
	{
		$opt = array();
		$opt['ItemId'] = $item_id;

		return $this->authenticate('ItemLookup', $opt, $locale);
	}

	/**
	 * Item Search
	 * 
	 * The ItemSearch operation returns items that satisfy the search criteria, including one or more 
	 * search indices.
	 * 
	 * ItemSearch is the operation that is used most often in requests. In general, when trying to 
	 * find an item for sale, you use this operation.
	 *
	 * @access public
	 * @param string $keywords (Required) A word or phrase associated with an item. The word or phrase can be in various product fields, including product title, author, artist, description, manufacturer, and so forth. When, for example, the search index equals "MusicTracks", the Keywords parameter enables you to search by song title.
	 * @param array $opt (Optional) Associative array of parameters. There are a large number available, so check the Amazon documentation page for details.
	 * @param string $locale (Optional) Which Amazon-supported locale do we use?
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSECommerceService/2007-10-29/DG/ItemSearch.html
	 */
	public function item_search($keywords, $opt = null, $locale = AAWS_LOCALE_US)
	{
		$opt = array();
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
	 * List Lookup
	 * 
	 * The ListLookup operation returns, by default, summary information about a list that you specify 
	 * in the request.
	 *
	 * @access public
	 * @param string $list_id (Required) Number that uniquely identifies a list.
	 * @param string $list_type (Required) Type of list. Accepts 'WeddingRegistry', 'Listmania', 'WishList'
	 * @param array $opt (Optional) Associative array of parameters. There are a large number available, so check the Amazon documentation page for details.
	 * @param string $locale (Optional) Which Amazon-supported locale do we use?
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSECommerceService/2007-10-29/DG/ListLookup.html
	 */
	public function list_lookup($list_id, $list_type, $opt = null, $locale = AAWS_LOCALE_US)
	{
		$opt = array();
		$opt['ListId'] = $list_id;
		$opt['ListType'] = $list_type;

		return $this->authenticate('ListLookup', $opt, $locale);
	}

	/**
	 * List Search
	 * 
	 * Given a customer name or Email address, the ListSearch operation returns the associated list 
	 * ID(s) but not the list items. To find those, use the list ID returned by ListSearch with 
	 * ListLookup.
	 * 
	 * Specifying a full name or just a first or last name in the request typically returns multiple 
	 * lists belonging to different people. Using Email as the identifier produces more filtered results.
	 *
	 * @access public
	 * @param array $opt (Optional; At least one is Required) Associative array of parameters. There are a large number available, so check the Amazon documentation page for details.
	 * @param string $locale (Optional) Which Amazon-supported locale do we use?
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSECommerceService/2007-10-29/DG/ListSearch.html
	 */
	public function list_search($opt = null, $locale = AAWS_LOCALE_US)
	{
		return $this->authenticate('ListSearch', $opt, $locale);
	}


	/*%******************************************************************************************%*/
	// SELLER METHODS

	/**
	 * Seller Listing Lookup
	 * 
	 * @todo Build this method. No work done on this yet.
	 */
	function seller_listing_lookup() {}

	/**
	 * Seller Listing Search
	 * 
	 * @todo Build this method. No work done on this yet.
	 */
	function seller_listing_search() {}

	/**
	 * Seller Lookup
	 * 
	 * @todo Build this method. No work done on this yet.
	 */
	function seller_lookup() {}


	/*%******************************************************************************************%*/
	// OTHER LOOKUP METHODS

	/**
	 * Similarity Lookup
	 * 
	 * @todo Build this method. No work done on this yet.
	 */
	function similarity_lookup() {}

	/**
	 * Tag Lookup
	 * 
	 * @todo Build this method. No work done on this yet.
	 */
	function tag_lookup() {}

	/**
	 * Transaction Lookup
	 * 
	 * @todo Build this method. No work done on this yet.
	 */
	function transaction_lookup() {}
}
?>