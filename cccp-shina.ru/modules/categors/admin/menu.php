<?php

$sub='';

$sub[]= array(
			"name"=>"Категории",
			"link"=>"?mod=categors&action=cat_list"
	   );
$sub[]= array(
			"name"=>"Добавить категорию",
			"link"=>"?mod=categors&action=cats_list"
	   );

$sub[]= array(
			"name"=>"Статистика",
			"link"=>"?mod=categors"
	   );

$main_menu[]=array(
				"link"=>"?mod=categors",
				"name"=>"categors",
				"title"=>"Категории",
				"ico"=>"module_3.gif",
				"sort"=>"7",
				"sub"=>$sub
			);

?>