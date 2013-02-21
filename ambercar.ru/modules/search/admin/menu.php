<?php

$sub='';

$sub[]= array(
			"name"=>"Статистика",
			"link"=>"?mod=search"
	   );

$sub[]= array(
			"name"=>"Обновить индекс",
			"link"=>"?mod=search&action=index"
	   );

$main_menu[]=array(
				"link"=>"?mod=search",
				"name"=>"search",
				"title"=>"Поиск",
				"sort"=>"90",
				"sub"=>$sub
			);

?>