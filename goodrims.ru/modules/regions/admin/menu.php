<?php

$sub='';

$sub[]= array(
			"name"=>"�������",
			"link"=>"?mod=regions&action=regions"
	   );

$sub[]= array(
      "name"=>"������",
      "link"=>"?mod=regions&action=citys_list"
     );

$sub[]= array(
      "name"=>"�����",
      "link"=>"?mod=regions&action=metros_list"
     );

$sub[]= array(
      "name"=>"�����",
      "link"=>"?mod=regions&action=firms_list"
     );

$main_menu[]=array(
				"link"=>"?mod=regions",
				"name"=>"regions",
				"title"=>"��� ��������",
				"ico"=>"module_3.gif",
				"sort"=>"4",
				"sub"=>$sub
			);

?>