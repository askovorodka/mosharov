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

$items = $db->get_all("select * FROM fw_products_images");

foreach ($items as $key=>$val)
{
	if (file_exists(ROOT.'/uploaded_files/shop_images/800-'.$val['id'].'.'.$val['ext']))
	{
		//Image::resize(ROOT.'/uploaded_files/shop_images/'.$val['id'].'.'.$val['ext'],ROOT.'/uploaded_files/shop_images/800-'.$val['id'].'.'.$val['ext'],800,800, false, "#FFFFFF");
        Image::image_resize(BASE_PATH."/uploaded_files/shop_images/800-$id.$ext", BASE_PATH."/uploaded_files/shop_images/resized-$id.$ext", 132,174);
		chmod(ROOT.'/uploaded_files/shop_images/resized-'.$val['id'].'.'.$val['ext'],0755);
		echo $val['id']."\n";
	}
}


?>