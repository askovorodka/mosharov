<?php
$sub='';

$sub[]= array(
			"name"=>"���������",
			"link"=>"?mod=shop&action=catalogue"
	   );
$sub[]= array(
			"name"=>"��������",
			"link"=>"?mod=shop&action=products_list"
	   );
$sub[]= array(
		"name"=>"������ �������",
		"link"=>"?mod=shop&action=orders"
);

$main_menu[]=array(
				"link"=>"?mod=shop",
				"name"=>"shop",
				"title"=>"�������",
				"ico"=>"module_3.gif",
				"sort"=>"4",
				"sub"=>$sub
			);

?>