<?php
class S3Browser
{
	var $s3;
	var $views;
	var $options;

	function __construct($s3, $options)
	{
		$this->s3 = $s3;
		$this->views = array();
		$this->options = $options;
	}

	function is_public($item)
	{
		if (isset($item->body->AccessControlList->Grant))
		{
			foreach ($item->body->AccessControlList->Grant as $grant)
			{
				if (isset($grant->Grantee->URI) && (string) $grant->Grantee->URI == 'http://acs.amazonaws.com/groups/global/AllUsers' && (string) $grant->Permission == 'READ')
				{
					return true;
				}
			}
		}
		
		return false;
	}

	function generate($bucket = null, $folder = null)
	{
		echo '<h3>Bucket: ' . $bucket . '</h3>';

		$contents = $this->s3->cache_response('list_objects', $this->options['cache'], $this->options['cache_duration'], array($bucket));

		$handles = array();
		foreach ($contents->body->Contents as $item)
		{
			$handles[] = $this->s3->get_object_acl($bucket, $item->Key, true);
		}

		$http = new TarzanHTTPRequest(null);
		$object_acl = $this->s3->cache_response(array($http, 'sendMultiRequest'), $this->options['cache'], $this->options['cache_duration'], array($handles));

		$template = file_get_contents($this->options['templates'] . '/default.tmpl');
		$pre = explode('{S3-LOOP}', $template);
		$content = explode('{S3-ENDLOOP}', $pre[1]);
		$post = $content[1];
		$content = $content[0];
		$pre = $pre[0];

		echo $pre;
		$i = 0;
		$zi = 0;

		foreach ($contents->body->Contents as $item)
		{
			if ($this->is_public($object_acl[$i]) && (integer) $item->Size > 10)
			{
				$loop = $content;
				$extension = array_pop(explode('.', (string) $item->Key));

				$loop = str_replace('{S3-ZEBRA}', ($zi % 2) ? 'zebra' : '', $loop);
				$loop = str_replace('{S3-FILENAME}', (string) $item->Key, $loop);
				$loop = str_replace('{S3-FILEURL}', 'http://' . $this->s3->vhost . '/' . (string) $item->Key, $loop);
				$loop = str_replace('{S3-TYPE}', strtoupper($extension), $loop);
				$loop = str_replace('{S3-SIZE}', $this->s3->util->size_readable((integer) $item->Size), $loop);
				$loop = str_replace('{S3-DATE}', date('j M Y, g:i a', strtotime((string) $item->LastModified)), $loop);
				$loop = str_replace('{S3-ICON}', './images/icons/check.php?i=' . strtolower($extension) . '.png', $loop);
				$loop = str_replace('{S3-EXTENSION}', strtoupper($extension), $loop);

				echo $loop;
				$zi++;
			}

			$i++;
		}

		echo $post;
	}
}

?>