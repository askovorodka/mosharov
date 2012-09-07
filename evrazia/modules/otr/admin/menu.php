<?php

$sub='';

$sub[]= array(
			"name"=>"Редактировать решение",
			"link"=>"?mod=otr"
	   );
	   
$sub[]= array(
			"name"=>"Добавить решение",
			"link"=>"?mod=otr&action=add"
	   );

$main_menu[]=array(
				"link"=>"?mod=otr",
				"name"=>"otr",
				"title"=>"Отраслевые решения",
				"sort"=>"1",
				"sub"=>$sub
			);

?>
