<?php

$sub='';

/*$sub[]= array(
      "name"=>"Производители",
      "link"=>"?mod=shop&action=types"
     );
*/
$sub[]= array(
			"name"=>"Марка/Модель",
			"link"=>"?mod=shop&action=catalogue"
	   );
$sub[]= array(
			"name"=>"Продукты",
			"link"=>"?mod=shop&action=products_list"
	   );

$sub[]= array(
			"name"=>"Типы",
			"link"=>"?mod=shop&action=types"
	   );

/*$sub[]= array(
			"name"=>"Слова-исключения",
			"link"=>"?mod=shop&action=exclude_words"
	   );
	   
$sub[]= array(
			"name"=>"Импорт",
			"link"=>"?mod=shop&action=import_price"
	   );*/
	   
$main_menu[]=array(
				"link"=>"?mod=shop",
				"name"=>"shop",
				"title"=>"Магазин",
				"ico"=>"module_3.gif",
				"sort"=>"4",
				"sub"=>$sub
			);

?>