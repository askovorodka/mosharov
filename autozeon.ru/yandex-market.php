<?php
require_once ($_SERVER["DOCUMENT_ROOT"]."/.inc/_site_config.php");
require_once ($_SERVER["DOCUMENT_ROOT"]."/_timestat.php");
$CATALOG['category_level']=Array();
$top_parent_pmid=0; //ID верхнего уровня
//$top_parent_ccid=0;
$top_parent_category_id=0;
$top_parent_group_id=0;
$top_parent_collection_id=0;
$top_parent_tovgrup_id=0;
$top_parent_docscollection_id=0;
$thislevel=0;
$thiscatlevel=0;
require_once ($_SERVER["DOCUMENT_ROOT"]."/admin/lib/funcs.php"); //
dbconnect ($db_server, $db_user, $db_pass, $db_name);
require_once $_SERVER['DOCUMENT_ROOT']."/admin/lib/catalogfuncs.php";
require_once ($_SERVER["DOCUMENT_ROOT"]."/admin/lib/documentfuncs.php");
require_once ($_SERVER["DOCUMENT_ROOT"]."/admin/valuti_autoupdate.php"); 
require_once $_SERVER['DOCUMENT_ROOT']."/admin/lib/commonfuncs.php";
require_once $_SERVER['DOCUMENT_ROOT']."/admin/lib/groupfuncs.php";
require_once $_SERVER['DOCUMENT_ROOT']."/admin/lib/collectionfuncs.php";

require_once ($_SERVER["DOCUMENT_ROOT"]."/admin/lib/razdelfuncs.php");


function dbconnect ($db_server, $db_user, $db_pass, $db_name) {
	if ($dbLink=@mysql_connect ($db_server, $db_user, $db_pass, $db_name))
	{ 
		#print "<p>С базой соединились</p>";
	} else {
//		die ('Не могу подключиться к базе ');
	}

	if (mysql_select_db ($db_name))
	{ 
		#print "<p>выбрали базу</p>";
	} else {
		die ('Не могу выбрать базу!');
	}
$result=mysql_query ("SET NAMES cp1251");
} //function dbconnect 




// require('includes/application_top.php');
// Set number of columns in listing
// reset($currencies->currencies);
//print "Текущая валюта:$currency"."<br>";

//require $_SERVER['DOCUMENT_ROOT']."/.inc/_start.php";
//include ($_SERVER["DOCUMENT_ROOT"]."/.inc/_incvars.php")

$config=get_config();
//print_r ($config);

$yandex_market_name=toxml_replace ($config['yandex_market_name']);
$yandex_market_company=toxml_replace ($config['yandex_market_company']);

echo"<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n";
// не забудь использовать \" вместо " в строковых параметрах заключенных в "" и \n (перевод строки) после каждого тега
echo"<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n";
//выводим дату и время:
//открываем тег
echo"<yml_catalog date=\"";
// собственно выводим дату и время функцией date:
echo date('Y-m-d H:i');
//закрываем тег
echo"\">\n\n"; 
echo"<shop>\n";
echo"<name>$yandex_market_name</name>\n";
echo"<company>$yandex_market_company</company>\n";
echo"<url>http://".$_SERVER['HTTP_HOST']."/</url>\n\n";
// Выставляем курс
echo"<currencies>\n";
// Жесткая привязка к курсу
kurs_valuti ();
echo"</currencies>\n\n";
// Прописываем категории


user_market_tovars_list ();


// Конец категорий

echo"</shop>\n";
echo"</yml_catalog>\n";

if ($_GET['stat']=='true') {

	print "\nКАТЕГОРИЙ: ".$CATALOG['total_xml_categories']."\n";
	print "\nТОВАРОВ: ".$CATALOG['total_xml_towars']."\n";
}
?>