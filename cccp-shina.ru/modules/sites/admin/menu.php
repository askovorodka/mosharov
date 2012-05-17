<?php

$sub='';

$sub[]= array(
      "name"=>"Дата разработки",
      "link"=>"?mod=shop&action=types"
     );

$sub[]= array(
			"name"=>"Классы",
			"link"=>"?mod=shop&action=catalogue"
	   );
$sub[]= array(
			"name"=>"Сайты",
			"link"=>"?mod=shop&action=products_list"
	   );

$sub[]= array(
			"name"=>"Свойства сайтов",
			"link"=>"?mod=shop&action=properties"
	   );
$sub[]= array(
			"name"=>"Статистика",
			"link"=>"?mod=shop"
	   );

$main_menu[]=array(
				"link"=>"?mod=shop",
				"name"=>"shop",
				"title"=>"Портфолио",
				"ico"=>"module_3.gif",
				"sort"=>"4",
				"sub"=>$sub
			);

?>