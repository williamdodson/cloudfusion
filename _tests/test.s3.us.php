<?php
/**
 * S3 UNIT TESTS - UNITED STATES
 * Provides automated testing of functionality.
 *
 * @category Tarzan
 * @package UnitTests
 * @subpackage S3-US
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

class S3US extends S3Base
{
	public function __construct()
	{
		parent::__construct();
	}
}

?>