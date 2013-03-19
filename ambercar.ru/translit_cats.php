<?php

require_once 'conf/globals.php';
require_once 'lib/class.db.php';
require_once 'lib/class.string.php';
require_once 'modules/shop/front/class.shop.php';
require_once 'lib/class.session.php';
$_SESSION['db_connections'] = 0;

$db = new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

$cats = $db->get_all("select * from fw_catalogue where trim(name) <> ''");

$string = new String();

foreach ($cats as $cat)
{
	$url = $string->translit(trim(str_replace(" ", "_", $cat['name'])));
	$db->query("update fw_catalogue set url='$url' where id={$cat['id']}");
}


?>