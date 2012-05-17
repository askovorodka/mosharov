<?php

$sub='';
	   
$sub[]= array(
			"name"=>"Разделы фотоальбома",
			"link"=>"?mod=photoalbum&action=cat"
	   );
	   
 $sub[]= array(
			"name"=>"Альбомы фотографий",
			"link"=>"?mod=photoalbum&action=albums_list"
	   );

$sub[]= array(
			"name"=>"Статистика",
			"link"=>"?mod=photoalbum"
	   );

$main_menu[]=array(
				"link"=>"?mod=photoalbum",
				"name"=>"photoalbum",
				"title"=>"Фотоальбом",
				"sort"=>"6",
				"sub"=>$sub
			);

?>