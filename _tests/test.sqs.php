<?php
/**
 * SQS UNIT TESTS
 * Provides automated testing of functionality.
 *
 * @category Tarzan
 * @package UnitTests
 * @subpackage SQS
 * @version 2008.07.14
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.com Tarzan
 * @link http://sqs.amazonaws.com Amazon SQS
 * @see README
 */


/*%******************************************************************************************%*/
// Tests

require_once('../tarzan.class.php');
require_once('./_simpletest/autorun.php');

class SQS extends UnitTestCase
{
	var $class;
	var $queue;
	var $receipt;

	public function __construct()
	{
		$this->UnitTestCase('Testing AmazonSQS');
		$this->class = new AmazonSQS();
	}

	public function test_create_queue()
	{
		$create = $this->class->create_queue('tarzan-test');
		$this->queue = $create->body->CreateQueueResult->QueueUrl;

		if ($create->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($create);
			$this->fail();
		}
	}

	public function test_list_queues()
	{
		$list = $this->class->list_queues();

		if ($list->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($list);
			$this->fail();
		}
	}

	public function test_set_queue_attributes()
	{
		$sattr = $this->class->set_queue_attributes($this->queue, array(
			'VisibilityTimeout' => '1'
		));

		if ($sattr->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($sattr);
			$this->fail();
		}
	}

	public function test_get_queue_attributes()
	{
		$gattr = $this->class->get_queue_attributes($this->queue);

		if ($gattr->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($gattr);
			$this->fail();
		}
	}

	public function test_send_message()
	{
		$send = $this->class->send_message($this->queue, 'Hello world!');
		sleep(3);

		if ($send->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($send);
			$this->fail();
		}
	}

	public function test_receive_message()
	{
		$receive = $this->class->receive_message($this->queue);
		$this->receipt = $receive->body->ReceiveMessageResult->Message->ReceiptHandle;
		sleep(3);

		if ($receive->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($receive);
			$this->fail();
		}
	}

	public function test_delete_message()
	{
		$delm = $this->class->delete_message($this->queue, $this->receipt);

		if ($delm->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($delm);
			$this->fail();
		}
	}

	public function test_delete_queue()
	{
		$delq = $this->class->delete_queue($this->queue);

		if ($delq->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($delq);
			$this->fail();
		}
	}
}

?>