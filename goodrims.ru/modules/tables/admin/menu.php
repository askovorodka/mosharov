<?php

$sub='';

$sub[]= array(
			"name"=>"������ ������",
			"link"=>"?mod=tables"
	   );
$sub[]= array(
			"name"=>"�������� �������",
			"link"=>"?mod=tables&action=add"
	   );

$main_menu[]=array(
				"link"=>"?mod=tables",
				"name"=>"tables",
				"title"=>"�������",
				"sort"=>"3",
				"sub"=>$sub
			);

?>