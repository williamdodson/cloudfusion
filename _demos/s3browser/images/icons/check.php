<?php
$image = $_GET['i'];
header('Content-type: image/png');

if (file_exists($image))
{
	echo readfile($image);
}
else
{
	echo readfile('generic.png');
}

?>