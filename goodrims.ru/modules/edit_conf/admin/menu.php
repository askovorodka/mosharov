<?php

$sub='';

$sub[]= array(
			"name"=>"������������� ���������",
			"link"=>"?mod=edit_conf"
	   );

$sub[]= array(
			"name"=>"��������� �������",
			"link"=>"?mod=edit_conf&action=templates"
	   );
$sub[]= array(
			"name"=>"��������� �����������",
			"link"=>"?mod=edit_conf&action=backup"
	   );

$sub[]= array(
			"name"=>"������� �����",
			"link"=>"?mod=edit_conf&action=mails"
	   );

$main_menu[]=array(
				"link"=>"?mod=edit_conf",
				"name"=>"edit_conf",
				"title"=>"���������",
				"ico"=>"module_9.gif",
				"sort"=>"92",
				"sub"=>$sub
			);

?>