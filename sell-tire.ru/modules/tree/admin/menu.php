<?php

$sub='';

$sub[]= array(
			"name"=>"������",
			"link"=>"?mod=tree"
	   );
$sub[]= array(
			"name"=>"�������� ������",
			"link"=>"?mod=tree&action=add"
	   );

$main_menu[]=array(
				"link"=>"?mod=tree",
				"name"=>"tree",
				"title"=>"��������� �����",
				"ico"=>"module_1.gif",
				"sort"=>"2",
				"sub"=>$sub
			);

?>