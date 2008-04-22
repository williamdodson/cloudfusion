<?php
/**
 * AMAZON SIMPLE QUEUE SERVICE (SQS)
 * http://sqs.amazonaws.com
 *
 * @category Tarzan
 * @package SQS
 * @version 2008.04.12
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.googlecode.com Tarzan
 * @link http://sqs.amazonaws.com Amazon SQS
 * @see README
 */


/*%******************************************************************************************%*/
// CONSTANTS

/**
 * Specify the default queue URL.
 */
define('SQS_DEFAULT_URL', 'http://queue.amazonaws.com/');


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Container for all Amazon SQS-related methods.
 */
class AmazonSQS extends TarzanCore
{
	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->api_version = '2008-01-01';
		parent::__construct();
	}


	/*%******************************************************************************************%*/
	// QUEUES

	/**
	 * Create Queue
	 *
	 * The CreateQueue action creates a new queue. You must provide a queue name that is unique within 
	 * the scope of the queues you own. The queue is assigned a queue URL; you must use this URL when 
	 * performing actions on the queue. When you create a queue, if a queue with the same name already 
	 * exists, CreateQueue returns the queue URL with an error indicating that the queue already exists.
	 *
	 * @access public
	 * @param string $queue_name (Required) The name to use for the queue created. The queue name must be unique within the scope of all your queues.
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSSimpleQueueService/2008-01-01/SQSDeveloperGuide/Query_QueryCreateQueue.html
	 */
	public function create_queue($queue_name)
	{
		$opt['QueueName'] = $queue_name;
		return $this->authenticate('CreateQueue', $opt, SQS_DEFAULT_URL);
	}

	/**
	 * Delete Queue
	 *
	 * Deletes the queue specified by the queue URL. Normally, a queue must be empty before you can 
	 * delete it. However, you can set the request parameter ForceDeletion to true to force the deletion 
	 * of a queue even if it's not empty.
	 *
	 * @access public
	 * @param string $queue_url (Required) The URL of the queue to perform the action on.
	 * @param boolean $force_deletion (Optional) When set to true, the queue is deleted even if it is not empty. If this parameter is omitted or set to false, the queue must be empty for the DeleteQueue action to succeed. Use this parameter with care, because once you delete your messages, you cannot access them again.
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSSimpleQueueService/2008-01-01/SQSDeveloperGuide/Query_QueryDeleteQueue.html
	 */
	public function delete_queue($queue_url, $force_deletion = false)
	{
		$opt = array();
		if ($force_deletion)
		{
			$opt['ForceDeletion'] = (string) $force_deletion;
		}
		return $this->authenticate('DeleteQueue', $opt, $queue_url);
	}

	/**
	 * List Queues
	 *
	 * The ListQueues action returns a list of your queues. A maximum 1000 queue URLs are returned. If 
	 * you specify a value for the optional QueueNamePrefix parameter, only queues with a name beginning 
	 * with the specified value are returned.
	 *
	 * @access public
	 * @param string $queue_name_prefix (Optional) String to use for filtering the list results. Only those queues whose name begins with the specified string are returned.
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSSimpleQueueService/2008-01-01/SQSDeveloperGuide/Query_QueryListQueues.html
	 */
	public function list_queues($queue_name_prefix = null)
	{
		$opt = array();
		if ($queue_name_prefix)
		{
			$opt['QueueNamePrefix'] = $queue_name_prefix;
		}
		return $this->authenticate('ListQueues', $opt, SQS_DEFAULT_URL);
	}

	/**
	 * Get Queue Attributes
	 *
	 * Gets one or all attributes of a queue.
	 *
	 * @access public
	 * @param string $queue_url (Required) The URL of the queue to perform the action on.
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSSimpleQueueService/2008-01-01/SQSDeveloperGuide/Query_QueryGetQueueAttributes.html
	 */
	public function get_queue_attributes($queue_url)
	{
		$opt = array();
		$opt['Attribute'] = 'All';
		return $this->authenticate('GetQueueAttributes', $opt, $queue_url);
	}

	/**
	 * Set Queue Attributes
	 *
	 * Sets an attribute of a queue. Currently, you can set only the VisibilityTimeout attribute for a 
	 * queue. See Visibility Timeout for more information.
	 *
	 * @access public
	 * @param string $queue_url (Required) The URL of the queue to perform the action on.
	 * @param array $opt Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>integer VisibilityTimeout - (Optional) Must be an integer from 0 to 7200 (2 hours).</li>
	 * </ul>
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSSimpleQueueService/2008-01-01/SQSDeveloperGuide/Query_QueryGetQueueAttributes.html
	 */
	public function set_queue_attributes($queue_url, $opt = null)
	{
		return $this->authenticate('SetQueueAttributes', $opt, $queue_url);
	}


	/*%******************************************************************************************%*/
	// MESSAGES

	/**
	 * Send Message
	 *
	 * The SendMessage action delivers a message to the specified queue.
	 *
	 * @access public
	 * @param string $queue_url (Required) The URL of the queue to perform the action on.
	 * @param string $message (Required) Message size cannot exceed 256 KB. Allowed Unicode characters (according to http://www.w3.org/TR/REC-xml/#charsets): #x9 | #xA | #xD | [#x20-#xD7FF] | [#xE000-#xFFFD] | [#x10000-#x10FFFF]
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSSimpleQueueService/2008-01-01/SQSDeveloperGuide/Query_QuerySendMessage.html
	 */
	public function send_message($queue_url, $message)
	{
		return $this->authenticate('SendMessage', null, $queue_url, $message);
	}

	/**
	 * Receive Message
	 *
	 * Retrieves one or more messages from the specified queue, including the message body and message 
	 * ID of each message. Messages returned by this action stay in the queue until you delete them. 
	 * However, once a message is returned to a ReceiveMessage request, it is not returned on subsequent 
	 * ReceiveMessage requests for the duration of the VisibilityTimeout. If you do not specify a 
	 * VisibilityTimeout in the request, the overall visibility timeout for the queue is used for the 
	 * returned messages. A default visibility timeout of 30 seconds is set when you create the queue. 
	 * You can also set the visibility timeout for the queue by using SetQueueAttributes. See Visibility 
	 * Timeout for more information.
	 *
	 * @access public
	 * @param string $queue_url (Required) The URL of the queue to perform the action on.
	 * @param array $opt Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>integer NumberOfMessages - (Optional) Maximum number of messages to return, from 1 to 256. Not necessarily all the messages in the queue are returned. If there are fewer messages in the queue than NumberOfMessages, the maximum number of messages returned is the current number of messages in the queue. Defaults to 1 message.</li>
	 *   <li>integer VisibilityTimeout - (Optional) An integer from 0 to 86400 (24 hours). Defaults to 30 seconds.</li>
	 * </ul>
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSSimpleQueueService/2008-01-01/SQSDeveloperGuide/Query_QueryReceiveMessage.html
	 */
	public function receive_message($queue_url, $opt = null)
	{
		return $this->authenticate('ReceiveMessage', $opt, $queue_url);
	}

	/**
	 * Delete Message
	 *
	 * The DeleteMessage action unconditionally removes the specified message from the specified queue. Even if 
	 * the message is locked by another reader due to the visibility timeout setting, it is still deleted from 
	 * the queue.
	 *
	 * @access public
	 * @param string $queue_url (Required) The URL of the queue to perform the action on.
	 * @param string $receipt_handle (Required) The receipt handle of the message to return.
	 * @return object A TarzanHTTPResponse response object.
	 * @see http://docs.amazonwebservices.com/AWSSimpleQueueService/2008-01-01/SQSDeveloperGuide/Query_QueryDeleteMessage.html
	 */
	public function delete_message($queue_url, $receipt_handle)
	{
		$opt = array();
		$opt['ReceiptHandle'] = $receipt_handle;
		return $this->authenticate('DeleteMessage', $opt, $queue_url);
	}


	/*%******************************************************************************************%*/
	// HELPER/UTILITY METHODS

	/**
	 * Get Queue Size
	 * 
	 * Retrieves the approximate number of messages in the queue.
	 * 
	 * @todo Implement this method.
	 */
	public function get_queue_size()
	{
		
	}
}
?>