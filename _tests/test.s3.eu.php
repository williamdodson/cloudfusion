<?php
/**
 * S3 UNIT TESTS - EUROPEAN UNION
 * Provides automated testing of functionality.
 *
 * @category Tarzan
 * @package UnitTests
 * @subpackage S3-EU
 * @version 2008.07.15
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.com Tarzan
 * @link http://s3.amazonaws.com Amazon S3
 * @see README
 */


/*%******************************************************************************************%*/
// Tests

require_once('../tarzan.class.php');
require_once('./_include.test.s3.php');
require_once('./_simpletest/autorun.php');

class S3EU extends S3Base
{
	public function __construct()
	{
		$this->UnitTestCase('Testing AmazonS3');
		$this->class = new AmazonS3();
		$this->bucket = 'tarzan-test-eu-' . strtolower($this->class->key);
		$this->file = 'test.txt';
	}

	public function test_create_bucket()
	{
		$bucket = $this->class->create_bucket($this->bucket, S3_LOCATION_EU);

		if ($bucket->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($bucket);
			$this->fail();
		}
	}
}

?>