<?php
exit();
require_once 'conf/globals.php';
require_once 'lib/class.db.php';
require_once 'lib/class.image.php';
require_once 'modules/shop/front/class.shop.php';
require_once 'lib/class.session.php';
$_SESSION['db_connections'] = 0;

//error_reporting(E_ALL);
//ini_set('display_errors','On');
		
$db = new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

$items = $db->get_all("select b.id, b.ext, b.parent, b.sort_order FROM fw_products as a left join fw_products_images as b on a.id=b.parent where a.status='1' ");

foreach ($items as $key=>$val)
{
	$filename = $val['id'] . '.' . $val['ext'];
	$file = ROOT . 'uploaded_files/shop_images/' . $filename;
	if (!is_file($file))	continue;
	//заводим новый ID для фотки
	$db->query("insert into fw_products_images (parent) values ('{$val['parent']}')");
	$newid=mysql_insert_id();
	$newfilename = $newid . '.' . $val['ext'];
	$newfile = ROOT . 'uploaded_files/shop_images/' . $newfilename;

	Image::resize($file, ROOT . "uploaded_files/shop_images/small-$newfilename", 64,74, false, "#FFFFFF");
	Image::resize($file, ROOT . "uploaded_files/shop_images/medium-$newfilename", 149,144, false, "#FFFFFF");
	Image::resize($file, ROOT . "uploaded_files/shop_images/big-$newfilename", 156,206, false, "#FFFFFF");
	Image::resize($file, ROOT . "uploaded_files/shop_images/super-$newfilename", 800,600, false, "#FFFFFF");
	
	system("rename " .$file . " " . $newfile);
	
	$db->query("update fw_products_images set ext='{$val['ext']}', sort_order='{$val['sort_order']}' where id='$newid'");
	system("rm -rf ". ROOT . "uploaded_images/shop_images/*".$filename);
	$db->query("delete from fw_products_images where id='{$val['id']}'");
	
	echo "--delete: " . $file . ", --add newfile: " . $newfilename ."\n";
}


?>