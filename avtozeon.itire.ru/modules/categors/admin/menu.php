<?php

$sub='';

$sub[]= array(
			"name"=>"���������",
			"link"=>"?mod=categors&action=cat_list"
	   );
$sub[]= array(
			"name"=>"�������� ���������",
			"link"=>"?mod=categors&action=cats_list"
	   );

$sub[]= array(
			"name"=>"����������",
			"link"=>"?mod=categors"
	   );

$main_menu[]=array(
				"link"=>"?mod=categors",
				"name"=>"categors",
				"title"=>"���������",
				"ico"=>"module_3.gif",
				"sort"=>"7",
				"sub"=>$sub
			);

?>