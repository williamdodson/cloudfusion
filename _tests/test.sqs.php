<?php
/**
 * SQS UNIT TESTS
 * Provides automated testing of functionality.
 *
 * @category Tarzan
 * @package UnitTests
 * @subpackage SQS
 * @version 2008.04.12
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.googlecode.com Tarzan
 * @link http://sqs.amazonaws.com Amazon SQS
 * @see README
 */


/*%******************************************************************************************%*/
// PREPARATION

require_once(dirname(dirname(__FILE__)) . '/tarzan.class.php');
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL);


/*%******************************************************************************************%*/
// TEST FUNCTIONS

/**
 * Get Result
 * 
 * @param TarzanHTTPResponse $obj (Required) The response object from the function call to test.
 * @return void
 */
function get_result($obj)
{
	if ((int) $obj->header['x-amz-httpstatus'] == 200)
	{
		echo '<tr class="pass"><td class="status">&#10004;</td>';
	}
	else
	{
		echo '<tr class="fail"><td class="status">&#10008;</td>';
	}
}


/*%******************************************************************************************%*/
// RUN THE TESTS

// Instantiate new AmazonSQS object.
$sqs = new AmazonSQS();

// Create a new queue for testing
$create = $sqs->create_queue('tarzan-test');
$queue = $create->body->CreateQueueResult->QueueUrl;

// List our queues
$list = $sqs->list_queues();

// Set the VisibilityTimeout queue attribute to 1.
$sattr = $sqs->set_queue_attributes($queue, array(
	'VisibilityTimeout' => '1'
));

// Get the queue attributes
$gattr = $sqs->get_queue_attributes($queue);

// Send a new test message to the queue
$send = $sqs->send_message($queue, 'Hello world!');

// Since SQS is distributed, let's give the message a few seconds to reach the queue
sleep(3);

// Receive our message from the queue
$receive = $sqs->receive_message($queue);
$receipt = $receive->body->ReceiveMessageResult->Message->ReceiptHandle;

// Since SQS is distributed, let's give the message a few seconds to be noted as "read".
sleep(3);

// Delete our test message from the queue.
$delm = $sqs->delete_message($queue, $receipt);

// Delete our test queue.
$delq = $sqs->delete_queue($queue);


/*%******************************************************************************************%*/
// OUTPUT RESULTS

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">

<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>test.sqs</title>
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen">
	</head>

	<body>
		<div id="page">
		<?php
		echo '<h1>Unit Test: ' . $sqs->service . ' (' . $sqs->api_version . ')</h1>';
		?>

		<table class="chart">
			<tbody>
				<?php get_result($create); ?>
				<td><a href="#create_queue">Create Queue</a></td></tr>

				<?php get_result($list); ?>
				<td><a href="#list_queues">List Queues</a></td></tr>

				<?php get_result($sattr); ?>
				<td><a href="#set_queue_attributes">Set Queue Attributes</a></td></tr>

				<?php get_result($gattr); ?>
				<td><a href="#get_queue_attributes">Get Queue Attributes</a></td></tr>

				<?php get_result($send); ?>
				<td><a href="#send_message">Send Message</a></td></tr>

				<?php get_result($receive); ?>
				<td><a href="#receive_message">Receive Message</a></td></tr>

				<?php get_result($delm); ?>
				<td><a href="#delete_message">Delete Message</a></td></tr>

				<?php get_result($delq); ?>
				<td><a href="#delete_queue">Delete Queue</a></td></tr>
			</tbody>
		</table>

		<?php
		echo '<h2><a name="create_queue">Create Queue</a></h2>';
		echo '<pre>'; print_r($create); echo '</pre>';

		echo '<h2><a name="list_queues">List Queues</a></h2>';
		echo '<pre>'; print_r($list); echo '</pre>';

		echo '<h2><a name="set_queue_attributes">Set Queue Attributes</a></h2>';
		echo '<pre>'; print_r($sattr); echo '</pre>';

		echo '<h2><a name="get_queue_attributes">Get Queue Attributes</a></h2>';
		echo '<pre>'; print_r($gattr); echo '</pre>';
		?>
			<div class="indent">
			<?php
			echo '<h2><a name="send_message">Send Message</a></h2>';
			echo '<pre>'; print_r($send); echo '</pre>';

			echo '<h2><a name="receive_message">Receive Message</a></h2>';
			echo '<pre>'; print_r($receive); echo '</pre>';

			echo '<h2><a name="delete_message">Delete Message</a></h2>';
			echo '<pre>'; print_r($delm); echo '</pre>';
			?>
			</div>
		<?php
		echo '<h2><a name="delete_queue">Delete Queue</a></h2>';
		echo '<pre>'; print_r($delq); echo '</pre>';
		?>
		</div>
	</body>
</html>
