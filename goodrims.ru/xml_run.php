<?php

require_once 'conf/globals.php';
require_once 'lib/class.db.php';
require_once 'modules/shop/front/class.shop.php';
require_once 'lib/class.session.php';
$_SESSION['db_connections'] = 0;

//error_reporting(E_ALL);
//ini_set('display_errors','On');
		
$db = new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

$item = $db->get_single("select conf_value FROM fw_conf WHERE conf_key='MARKET_RUNNING'");

if ($item['conf_value'] == '1')
{
	system('/usr/local/bin/wget "http://itire.ru/yandex.php" -O /dev/null');
	$db->query("update fw_conf set conf_value='0' where conf_key='MARKET_RUNNING' ");
}

?>