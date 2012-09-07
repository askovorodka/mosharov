<?php

$sub='';
	   
$sub[]= array(
			"name"=>"Опросы",
			"link"=>"?mod=polls"
	   );
	   
$sub[]= array(
			"name"=>"Добавить опрос",
			"link"=>"?mod=polls&action=add"
	   );

$main_menu[]=array(
				"link"=>"?mod=polls",
				"name"=>"polls",
				"title"=>"Опросы",
				"sort"=>"5",
				"sub"=>$sub
			);

?>