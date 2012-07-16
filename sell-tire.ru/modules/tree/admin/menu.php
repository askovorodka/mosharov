<?php

$sub='';

$sub[]= array(
			"name"=>"Дерево",
			"link"=>"?mod=tree"
	   );
$sub[]= array(
			"name"=>"Добавить раздел",
			"link"=>"?mod=tree&action=add"
	   );

$main_menu[]=array(
				"link"=>"?mod=tree",
				"name"=>"tree",
				"title"=>"Структура сайта",
				"ico"=>"module_1.gif",
				"sort"=>"2",
				"sub"=>$sub
			);

?>