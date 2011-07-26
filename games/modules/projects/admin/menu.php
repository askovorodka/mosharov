<?php

$sub='';

$sub[]= array(
      "name"=>"Дата разработки",
      "link"=>"?mod=projects&action=types"
     );

$sub[]= array(
			"name"=>"Проекты",
			"link"=>"?mod=projects&action=projects_list"
	   );
$sub[]= array(
			"name"=>"Страницы проектов",
			"link"=>"?mod=projects&action=urls_list"
	   );

$sub[]= array(
			"name"=>"Статистика",
			"link"=>"?mod=projects"
	   );

$main_menu[]=array(
				"link"=>"?mod=projects",
				"name"=>"projects",
				"title"=>"Проекты",
				"ico"=>"module_3.gif",
				"sort"=>"5",
				"sub"=>$sub
			);

?>