<?php

$sub='';

$sub[]= array(
			"name"=>"����������",
			"link"=>"?mod=search"
	   );

$sub[]= array(
			"name"=>"�������� ������",
			"link"=>"?mod=search&action=index"
	   );

$main_menu[]=array(
				"link"=>"?mod=search",
				"name"=>"search",
				"title"=>"�����",
				"sort"=>"90",
				"sub"=>$sub
			);

?>