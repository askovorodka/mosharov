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

$items = $db->get_all("select * FROM fw_catalogue");

foreach ($items as $key=>$val)
{
	if (!file_exists( ROOT.'/uploaded_files/shop_images/'.$val['image'] ))
		$db->query("update fw_catalogue set image='' where id='{$val['id']}'");
}

echo "�������";

?>