<?php

$sub='';

$sub[]= array(
      "name"=>"���� ����������",
      "link"=>"?mod=ferms&action=types"
     );

$sub[]= array(
			"name"=>"�����",
			"link"=>"?mod=ferms&action=ferms_list"
	   );
$sub[]= array(
			"name"=>"�������� ����",
			"link"=>"?mod=ferms&action=urls_list"
	   );

$sub[]= array(
			"name"=>"����������",
			"link"=>"?mod=ferms"
	   );

$main_menu[]=array(
				"link"=>"?mod=ferms",
				"name"=>"ferms",
				"title"=>"�����",
				"ico"=>"module_3.gif",
				"sort"=>"6",
				"sub"=>$sub
			);

?>