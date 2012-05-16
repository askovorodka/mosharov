<?php

require_once 'conf/globals.php';
require_once 'lib/class.db.php';
require_once 'lib/class.image.php';
require_once 'modules/shop/front/class.shop.php';
require_once 'lib/class.session.php';
$_SESSION['db_connections'] = 0;

//error_reporting(E_ALL);
//ini_set('display_errors','On');
		
$db = new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

$items = $db->get_all("select * FROM images_cron");

foreach ($items as $key=>$val)
{
	if (empty($val['image']))
		continue;
	$cat_image = $db->get_single("select image from fw_catalogue where id = " . $val['cat_id']);
	if (!empty($cat_image['image']))
		continue;
	
	$check_file_name=explode(".",$val['image']);
	$ext=strtolower($check_file_name[count($check_file_name)-1]);
	$image_name = 'cat-'.$val['cat_id'].'.'.$ext;
	
	$image_from = "http://itire.ru/uploaded_files/shop_images/" . $val['image'];
	//$image_to = ROOT . '/uploaded_files/photos/cat-' . $val['cat_id'] . '.' . $ext;
	$image_to = ROOT . '/uploaded_files/photos/';
	
	system("/usr/local/bin/wget {$image_from} -P {$image_to}");
	
	copy($image_to.$val['image'], ROOT.'/uploaded_files/shop_images/' . $image_name);

	Image::resize(ROOT.'/uploaded_files/shop_images/'.$image_name,ROOT.'/uploaded_files/shop_images/'.$image_name,295,237, false);
	Image::resize(ROOT.'/uploaded_files/shop_images/'.$image_name,ROOT.'/uploaded_files/shop_images/p'.$image_name,139,100, false);
	Image::resize(ROOT.'/uploaded_files/shop_images/'.$image_name,ROOT.'/uploaded_files/shop_images/s'.$image_name,156,45, false);
	Image::resize(ROOT.'/uploaded_files/shop_images/'.$image_name,ROOT.'/uploaded_files/shop_images/c'.$image_name,98,81, false);

	system("rm " . ROOT . '/uploaded_files/photos/*');
	
	$db->query("update fw_catalogue set image='{$image_name}' where id='{$val['cat_id']}'");
	
	echo $image_from."\n";
}


?>