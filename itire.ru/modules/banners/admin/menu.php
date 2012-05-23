<?php

$sub='';

$sub[]= array(
			"name"=>"Рекламная кампании",
			"link"=>"?mod=banners"
	   );
	   
$sub[]= array(
			"name"=>"Группы",
			"link"=>"?mod=banners&action=groups_list"
	   );

$main_menu[]=array(
				"link"=>"?mod=banners",
				"name"=>"banners",
				"title"=>"Баннеры",
				"sort"=>"1",
				"sub"=>$sub
			);

?>