<?php
/**
 * File: Amazon SQS Queue
 * 	Queue-centric version of the Amazon SQS class.
 *
 * Version:
 * 	2008.11.09
 * 
 * Copyright:
 * 	2006-2008 LifeNexus Digital, Inc., and contributors.
 * 
 * License:
 * 	Simplified BSD License - http://opensource.org/licenses/bsd-license.php
 * 
 * See Also:
 * 	Tarzan - http://tarzan-aws.com
 * 	Amazon SQS - http://aws.amazon.com/sqs
 */

class SQSQueue_Exception extends SQS_Exception {}

class AmazonSQSQueue extends AmazonSQS
{
	var $queue;

	public function __construct($queue_url, $key = null, $secret_key = null)
	{
		$this->api_version = '2008-01-01';
		$this->queue_url = $queue_url;
		parent::__construct($key, $secret_key);
	}

	public function delete_queue($returnCurlHandle = null)
	{
		$opt = array();
		$opt['returnCurlHandle'] = $returnCurlHandle;
		return $this->authenticate('DeleteQueue', $opt, $this->queue_url);
	}

	public function get_queue_attributes($returnCurlHandle = null)
	{
		$opt = array();
		$opt['AttributeName'] = 'All';
		$opt['returnCurlHandle'] = $returnCurlHandle;
		return $this->authenticate('GetQueueAttributes', $opt, $this->queue_url);
	}

	public function set_queue_attributes($opt = null)
	{
		if (!$opt) $opt = array();

		if (isset($opt['VisibilityTimeout']))
		{
			$opt['Attribute.Name'] = 'VisibilityTimeout';
			$opt['Attribute.Value'] = $opt['VisibilityTimeout'];
			unset($opt['VisibilityTimeout']);
		}
		return $this->authenticate('SetQueueAttributes', $opt, $this->queue_url);
	}

	public function send_message($message, $returnCurlHandle = null)
	{
		$opt = array();
		$opt['returnCurlHandle'] = $returnCurlHandle;
		return $this->authenticate('SendMessage', $opt, $this->queue_url, $message);
	}

	public function receive_message($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('ReceiveMessage', $opt, $this->queue_url);
	}

	public function delete_message($receipt_handle, $returnCurlHandle = null)
	{
		$opt = array();
		$opt['ReceiptHandle'] = $receipt_handle;
		$opt['returnCurlHandle'] = $returnCurlHandle;
		return $this->authenticate('DeleteMessage', $opt, $this->queue_url);
	}

	public function get_queue_size()
	{
		$opt = array();
		$opt['AttributeName'] = 'ApproximateNumberOfMessages';
		$response = $this->authenticate('GetQueueAttributes', $opt, $this->queue_url);
		return (integer) $response->body->GetQueueAttributesResult->Attribute->Value;
	}
}
?>