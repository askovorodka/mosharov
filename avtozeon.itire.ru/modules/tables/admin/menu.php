<?php

$sub='';

$sub[]= array(
			"name"=>"Список таблиц",
			"link"=>"?mod=tables"
	   );
$sub[]= array(
			"name"=>"Добавить таблицу",
			"link"=>"?mod=tables&action=add"
	   );

$main_menu[]=array(
				"link"=>"?mod=tables",
				"name"=>"tables",
				"title"=>"Таблицы",
				"sort"=>"3",
				"sub"=>$sub
			);

?>