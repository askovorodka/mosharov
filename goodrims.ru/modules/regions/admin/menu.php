<?php

$sub='';

$sub[]= array(
			"name"=>"Регионы",
			"link"=>"?mod=regions&action=regions"
	   );

$sub[]= array(
      "name"=>"Города",
      "link"=>"?mod=regions&action=citys_list"
     );

$sub[]= array(
      "name"=>"Метро",
      "link"=>"?mod=regions&action=metros_list"
     );

$sub[]= array(
      "name"=>"Фирмы",
      "link"=>"?mod=regions&action=firms_list"
     );

$main_menu[]=array(
				"link"=>"?mod=regions",
				"name"=>"regions",
				"title"=>"Где заказать",
				"ico"=>"module_3.gif",
				"sort"=>"4",
				"sub"=>$sub
			);

?>