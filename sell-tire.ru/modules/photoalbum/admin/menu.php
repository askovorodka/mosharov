<?php

$sub='';
	   
$sub[]= array(
			"name"=>"������� �����������",
			"link"=>"?mod=photoalbum&action=cat"
	   );
	   
 $sub[]= array(
			"name"=>"������� ����������",
			"link"=>"?mod=photoalbum&action=albums_list"
	   );

$sub[]= array(
			"name"=>"����������",
			"link"=>"?mod=photoalbum"
	   );

$main_menu[]=array(
				"link"=>"?mod=photoalbum",
				"name"=>"photoalbum",
				"title"=>"����������",
				"sort"=>"6",
				"sub"=>$sub
			);

?>