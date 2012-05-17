<?php

$sub='';

$sub[]= array(
			"name"=>"Список форумов",
			"link"=>"?mod=forum"
	   );
	   
$sub[]= array(
			"name"=>"Добавить раздел",
			"link"=>"index.php?mod=forum&action=add_forum&parent=1"
	   );

$main_menu[]=array(
				"link"=>"?mod=forum",
				"name"=>"forum",
				"title"=>"Форум",
				"sort"=>"7",
				"sub"=>$sub
			);

?>