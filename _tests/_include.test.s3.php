<?php
/**
 * S3 UNIT TESTS - BASE
 * Provides automated testing of functionality.
 *
 * @category Tarzan
 * @package UnitTests
 * @subpackage S3
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
require_once('./_simpletest/autorun.php');

class S3Base extends UnitTestCase
{
	var $class;
	var $bucket;
	var $file;
	var $request_url;

	public function __construct()
	{
		$this->UnitTestCase('Testing AmazonS3');
		$this->class = new AmazonS3();
		$this->bucket = 'tarzan-test-us-' . strtolower($this->class->key);
		$this->file = 'test.txt';
	}

	public function test_create_bucket()
	{
		$bucket = $this->class->create_bucket($this->bucket, S3_LOCATION_US);

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

	public function test_get_bucket_locale()
	{
		$locale = $this->class->get_bucket_locale($this->bucket);

		if ($locale->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($locale);
			$this->fail();
		}
	}

	public function test_list_buckets()
	{
		$list_buckets = $this->class->list_buckets();

		if ($list_buckets->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($list_buckets);
			$this->fail();
		}
	}

	public function test_get_bucket_list()
	{
		$get_bucket_list = $this->class->get_bucket_list();
		$this->assertTrue(is_array($get_bucket_list));
	}

	public function test_set_bucket_acl()
	{
		$set_bucket_acl = $this->class->set_bucket_acl($this->bucket, S3_ACL_PRIVATE);

		if ($set_bucket_acl->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($set_bucket_acl);
			$this->fail();
		}
	}

	public function test_get_bucket_acl()
	{
		$get_bucket_acl = $this->class->get_bucket_acl($this->bucket);

		if ($get_bucket_acl->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($get_bucket_acl);
			$this->fail();
		}
	}

	public function test_head_bucket()
	{
		$head_bucket = $this->class->head_bucket($this->bucket);

		if ($head_bucket->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($head_bucket);
			$this->fail();
		}
	}

	public function test_if_bucket_exists()
	{
		$if_bucket_exists = $this->class->if_bucket_exists($this->bucket);
		$this->assertTrue($if_bucket_exists);
	}

	public function test_create_object()
	{
		$file = $this->class->create_object($this->bucket, array(
			'filename' => $this->file,
			'body' => 'Hello world!',
			'contentType' => 'text/plain',
			'acl' => S3_ACL_PUBLIC
		));

		if ($file->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($file);
			$this->fail();
		}
	}

	public function test_store_remote_file()
	{
		$store_remote_file = $this->class->store_remote_file('http://code.google.com/p/tarzan-aws/', $this->bucket, '2'.$this->file);

		if ($store_remote_file == 'http://' . $this->bucket . '.s3.amazonaws.com/2' . $this->file)
		{
			$this->pass();
		}
		else
		{
			$this->dump('http://' . $this->bucket . '.s3.amazonaws.com/2' . $this->file);
			$this->dump($store_remote_file);
			$this->fail();
		}
	}

	public function test_duplicate_object()
	{
		$copy_object = $this->class->duplicate_object($this->bucket, $this->file, 'duplicate_of_' . $this->file);

		if ($copy_object->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($copy_object);
			$this->fail();
		}
	}
	
	public function test_rename_object()
	{
		$move_object = $this->class->rename_object($this->bucket, 'duplicate_of_' . $this->file, 'renamed_duplicate_of_' . $this->file);

		if ($move_object->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($move_object);
			$this->fail();
		}
	}
	
	public function test_list_objects()
	{
		$list_objects = $this->class->list_objects($this->bucket);

		if ($list_objects->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($list_objects);
			$this->fail();
		}
	}
	
	public function test_get_object_list()
	{
		$get_object_list = $this->class->get_object_list($this->bucket);
		$this->assertTrue(is_array($get_object_list));
	}
	
	public function test_get_bucket_size()
	{
		$get_bucket_size = $this->class->get_bucket_size($this->bucket);
		$this->assertEqual($get_bucket_size, 3);
	}
	
	public function test_get_bucket_filesize()
	{
		$get_bucket_filesize = $this->class->get_bucket_filesize($this->bucket);
		$this->assertEqual($get_bucket_filesize, 13679);
	}
	
	public function test_head_object()
	{
		$head_object = $this->class->head_object($this->bucket, $this->file);

		if ($head_object->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($head_object);
			$this->fail();
		}
	}
	
	public function test_if_object_exists()
	{
		$if_object_exists = $this->class->if_object_exists($this->bucket, $this->file);
		$this->assertTrue($if_object_exists);
	}
	
	public function test_get_object()
	{
		$get_object = $this->class->get_object($this->bucket, $this->file);

		if ($get_object->isOK())
		{
			$this->request_url = $get_object->header['x-tarzan-requesturl'];
			$this->pass();
		}
		else
		{
			$this->dump($get_object);
			$this->fail();
		}
	}
	
	public function test_get_object_url()
	{
		$get_object_url = $this->class->get_object_url($this->bucket, $this->file);
		$this->assertEqual($get_object_url, 'http://' . $this->bucket . '.s3.amazonaws.com/' . $this->file);
	}

	public function test_get_torrent_url()
	{
		$get_torrent_url = $this->class->get_torrent_url($this->bucket, $this->file);
		$this->assertEqual($get_torrent_url, 'http://' . $this->bucket . '.s3.amazonaws.com/' . $this->file . '?torrent');
	}

	public function test_set_object_acl()
	{
		$set_object_acl = $this->class->set_object_acl($this->bucket, $this->file, S3_ACL_PUBLIC);

		if ($set_object_acl->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($set_object_acl);
			$this->fail();
		}
	}
	
	public function test_get_object_acl()
	{
		$get_object_acl = $this->class->get_object_acl($this->bucket, $this->file);

		if ($get_object_acl->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($get_object_acl);
			$this->fail();
		}
	}

	public function test_get_public()
	{
		$get_public = new TarzanHTTPRequest($this->request_url);
		$get_public->sendRequest();
		$get_public = new TarzanHTTPResponse($get_public->getResponseHeader(), null, $get_public->getResponseCode());

		if ($get_public->isOK())
		{
			$this->pass();
		}
		else
		{
			$this->dump($get_public);
			$this->fail();
		}
	}
	
	public function test_delete_object()
	{
		$delete_object = $this->class->delete_object($this->bucket, $this->file);

		if ($delete_object->isOK(204))
		{
			$this->pass();
		}
		else
		{
			$this->dump($delete_object);
			$this->fail();
		}
	}
	
	public function test_delete_all_objects()
	{
		$delete_all_objects = $this->class->delete_all_objects($this->bucket);
		$this->assertTrue($delete_all_objects);
	}
	
	public function test_delete_bucket()
	{
		$delete_bucket = $this->class->delete_bucket($this->bucket);

		if ($delete_bucket->isOK(204))
		{
			$this->pass();
		}
		else
		{
			$this->dump($delete_bucket);
			$this->fail();
		}
	}
}

?>