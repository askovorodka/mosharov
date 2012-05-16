<?php

$sub='';

$sub[]= array(
      "name"=>"Дата разработки",
      "link"=>"?mod=ferms&action=types"
     );

$sub[]= array(
			"name"=>"Фермы",
			"link"=>"?mod=ferms&action=ferms_list"
	   );
$sub[]= array(
			"name"=>"Страницы ферм",
			"link"=>"?mod=ferms&action=urls_list"
	   );

$sub[]= array(
			"name"=>"Статистика",
			"link"=>"?mod=ferms"
	   );

$main_menu[]=array(
				"link"=>"?mod=ferms",
				"name"=>"ferms",
				"title"=>"Фермы",
				"ico"=>"module_3.gif",
				"sort"=>"6",
				"sub"=>$sub
			);

?>