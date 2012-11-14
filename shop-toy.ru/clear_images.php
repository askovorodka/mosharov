<?php 
require_once 'conf/globals.php';
require_once 'lib/class.db.php';
require_once 'lib/class.session.php';
$_SESSION['db_connections'] = 0;

//error_reporting(E_ALL);
//ini_set('display_errors','On');
		
$db = new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

$images = $db->get_all("select * from product_images");

foreach ($images as $image)
{
	$product_id = intval($image['product_id']);
	if (!empty($product_id))
	{
		$product = $db->get_single("select * from fw_products where id=" . $product_id);
		if (empty($product))
		{
			//удаляем картинки
			system("rm -rf " . ROOT . "/uploaded_files/product_images/" . $product_id);
			system("rm -rf " . ROOT . "/resized/img100x100/uploaded_files/product_images/" . $product_id);
			system("rm -rf " . ROOT . "/resized/img105x105/uploaded_files/product_images/" . $product_id);
			system("rm -rf " . ROOT . "/resized/img315x228/uploaded_files/product_images/" . $product_id);
			system("rm -rf " . ROOT . "/resized/img71x74/uploaded_files/product_images/" . $product_id);
			system("rm -rf " . ROOT . "/resized/img80x80/uploaded_files/product_images/" . $product_id);
			$db->query("delete from product_images where product_id='{$product_id}'");
			echo "product_id: {$product_id}, delete images, deleted row from database\n";
		}
	}
}

?>