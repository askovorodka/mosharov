<?php

$sub='';

$sub[]= array(
			"name"=>"��������� ��������",
			"link"=>"?mod=banners"
	   );
	   
$sub[]= array(
			"name"=>"������ ��������",
			"link"=>"?mod=banners&action=groups_list"
	   );

$main_menu[]=array(
				"link"=>"?mod=banners",
				"name"=>"banners",
				"title"=>"�������",
				"sort"=>"1",
				"sub"=>$sub
			);

?>