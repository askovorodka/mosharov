<?php

$sub='';

$sub[]= array(
			"name"=>"������ ���� ��������",
			"link"=>"?mod=forms"
	   );
$sub[]= array(
			"name"=>"�������� �����",
			"link"=>"?mod=forms&action=add"
	   );
	   
$main_menu[]=array(
				"link"=>"?mod=forms",
				"name"=>"forms",
				"title"=>"����� ��������",
				"sort"=>"3",
				"sub"=>$sub
			);

?>