<?php

if (!$_SERVER['REQUEST_URI'])
	die("Error request string");

if (empty($_GET['type']) || empty($_GET['image']))
	die("Error arguments");

require_once 'conf/globals.php';
require_once 'lib/class.db.php';
require_once 'lib/class.image.php';
require_once 'modules/shop/front/class.shop.php';
require_once 'lib/class.session.php';
$_SESSION['db_connections'] = 0;

$db = new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

$width = 0;
$height = 0;
$crope = true;

switch ($_GET['type'])
{
	case 'img100x100':
		$width = 100;
		$height = 100;
	break;

	case 'img193x143':
		$width = 193;
		$height = 143;
	break;

	case 'img136x100':
		$width = 136;
		$height = 100;
	break;

	case 'img400x300':
		$width = 400;
		$height = 300;
	break;
	
	default:
		die("Error type");
	break;
}


$dirs_array = explode("/", $_GET['image']);
$rst_image = ROOT . $_GET['image'];

if (!file_exists($rst_image))
{
	die("��� ����");
}

$image_root = ROOT . 'resized/' . $_GET['type'];

if (!file_exists($image_root))
	mkdir($image_root,0777,true);

if (count($dirs_array))
{
	for ($i=0; $i < count($dirs_array)-1; $i++)
	{
		$image_root .= "/" . $dirs_array[$i];
		if (!file_exists($image_root))
			mkdir($image_root,0777,true);
	}
	
	
	$dst_image = $image_root . "/" . $dirs_array[count($dirs_array)-1];
	if (file_exists($rst_image) && !file_exists($dst_image))
	{
		list($w,$h,$image_type) = @getimagesize($rst_image);
		Image::resize($rst_image, $dst_image, $width, $height, $crope);
	}
	
	header('Content-Type: ' . image_type_to_mime_type($image_type));
    header('Content-Length: ' . @filesize($dst_image));
    readfile($dst_image);
	
}

?>