<?php

$sub='';

$sub[]= array(
			"name"=>"������ �������",
			"link"=>"?mod=forum"
	   );
	   
$sub[]= array(
			"name"=>"�������� ������",
			"link"=>"index.php?mod=forum&action=add_forum&parent=1"
	   );

$main_menu[]=array(
				"link"=>"?mod=forum",
				"name"=>"forum",
				"title"=>"�����",
				"sort"=>"7",
				"sub"=>$sub
			);

?>