<?php

$sub='';

$sub[]= array(
			"name"=>"������ �������������",
			"link"=>"?mod=users&action=groups"
	   );

$sub[]= array(
			"name"=>"������ �������������",
			"link"=>"?mod=users"
	   );
$sub[]= array(
			"name"=>"�������� ������������",
			"link"=>"?mod=users&action=add_user"
	   );

$main_menu[]=array(
				"link"=>"?mod=users",
				"name"=>"users",
				"title"=>"������������",
				"ico"=>"module_7.gif",
				"sort"=>"89",
				"sub"=>$sub
			);

?>