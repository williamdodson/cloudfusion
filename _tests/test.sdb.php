<?php
/**
 * SDB UNIT TESTS
 * Provides automated testing of functionality.
 *
 * @category Tarzan
 * @package UnitTests
 * @subpackage SDB
 * @version 2008.07.14
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.com Tarzan
 * @link http://sdb.amazonaws.com Amazon SDB
 * @see README
 */


/*%******************************************************************************************%*/
// Tests

require_once('../tarzan.class.php');
require_once('./_simpletest/autorun.php');

class SDB extends UnitTestCase
{
	var $class;
	var $dname;
	var $iname;
	var $query;

	public function __construct()
	{
		$this->UnitTestCase('Testing AmazonSDB');
		$this->class = new AmazonSDB();
		$this->dname = 'tarzan-test';
		$this->iname = 'tarzan-test-item';
	}

	public function test_create_domain()
	{
		$create_domain = $this->class->create_domain($this->dname);
		sleep(10);

		if ($create_domain->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($create_domain);
			$this->fail();
		}
	}

	public function test_list_domains()
	{
		$list_domains = $this->class->list_domains();

		if ($list_domains->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($list_domains);
			$this->fail();
		}
	}

	public function test_put_attributes()
	{
		$put_attributes = $this->class->put_attributes($this->dname, $this->iname, array(
			'adam' => 'eve',
			'benny' => 'joon',
			'bonnie' => 'clyde'
		), true);
		sleep(10);

		if ($put_attributes->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($put_attributes);
			$this->fail();
		}
	}

	public function test_query()
	{
		$this->query = $this->class->query($this->dname);

		if ($this->query->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($this->query);
			$this->fail();
		}
	}

	public function test_query_with_attributes()
	{
		$this->query = $this->class->query_with_attributes($this->dname);

		if ($this->query->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($this->query);
			$this->fail();
		}
	}

	public function test_get_attributes()
	{
		$get_attributes = $this->class->get_attributes($this->dname, $this->query->body->QueryResult->ItemName);

		if ($get_attributes->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($get_attributes);
			$this->fail();
		}
	}

	public function test_delete_attributes()
	{
		$delete_attributes = $this->class->delete_attributes($this->dname, $this->query->body->QueryResult->ItemName);

		if ($delete_attributes->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($delete_attributes);
			$this->fail();
		}
	}

	public function test_delete_domain()
	{
		$delete_domain = $this->class->delete_domain($this->dname);

		if ($delete_domain->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($delete_domain);
			$this->fail();
		}
	}
}

?>