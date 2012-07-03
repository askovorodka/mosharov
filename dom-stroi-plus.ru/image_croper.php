<?php 

require_once 'lib/class.image.php';

$dir = $_SERVER['DOCUMENT_ROOT'] . '/uploaded_files/shop_images/';


if (is_dir($dir))
{
	if ($dh = opendir($dir))
	{
		while(($file = readdir($dh)) !== false )
		{
			if ($file == '..' || $file == '.')
				continue;

			$check_file_name=explode(".",$file);
			$filename = $check_file_name[0];

			if (preg_match("/^\d/i",$filename))
			{
				$image = Image::image_details($_SERVER['DOCUMENT_ROOT']."/uploaded_files/shop_images/$file");
				if ($image['width'] > 800 || $image['height'] > 600)
					Image::resize($_SERVER['DOCUMENT_ROOT']."/uploaded_files/shop_images/$file", $_SERVER['DOCUMENT_ROOT']."/uploaded_files/shop_images/big-$file", 800,600, true, "#ffffff");
				else
					copy($_SERVER['DOCUMENT_ROOT']."/uploaded_files/shop_images/$file", $_SERVER['DOCUMENT_ROOT']."/uploaded_files/shop_images/big-$file");
			}
		}
	}
}


?>