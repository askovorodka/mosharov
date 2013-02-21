<?php

$sub='';

/*$sub[]= array(
      "name"=>"Производители",
      "link"=>"?mod=shop&action=types"
     );
*/

$sub[]= array(
			"name"=>"Категория",
			"link"=>"?mod=shop&action=catalogue"
	   );
$sub[]= array(
			"name"=>"Продукты",
			"link"=>"?mod=shop&action=products_list"
	   );

/*$sub[]= array(
			"name"=>"Свойства продуктов",
			"link"=>"?mod=shop&action=properties"
	   );*/
$sub[]= array(
			"name"=>"Статистика",
			"link"=>"?mod=shop"
	   );

$sub[]= array(
			"name"=>"Список заказов",
			"link"=>"?mod=shop&action=orders"
	   );

$sub[]= array(
			"name"=>"Импорт",
			"link"=>"?mod=shop&action=import"
	   );

$sub[]= array(
			"name"=>"Экспорт",
			"link"=>"?mod=shop&action=export"
	   );
	   
$sub[]= array(
			"name"=>"Лог импорта",
			"link"=>"?mod=shop&action=import_log"
	   );
	   
	   
$main_menu[]=array(
				"link"=>"?mod=shop",
				"name"=>"shop",
				"title"=>"Магазин",
				"ico"=>"module_3.gif",
				"sort"=>"4",
				"sub"=>$sub
			);

?>