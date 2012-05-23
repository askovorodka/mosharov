<?php

$sub='';

$sub[]= array(
			"name"=>"Редактировать новости",
			"link"=>"?mod=news"
	   );
	   
$sub[]= array(
			"name"=>"Добавить новость",
			"link"=>"?mod=news&action=add"
	   );

$main_menu[]=array(
				"link"=>"?mod=news",
				"name"=>"news",
				"title"=>"Новости",
				"sort"=>"1",
				"sub"=>$sub
			);

?>