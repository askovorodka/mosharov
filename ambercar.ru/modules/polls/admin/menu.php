<?php

$sub='';
	   
$sub[]= array(
			"name"=>"������",
			"link"=>"?mod=polls"
	   );
	   
$sub[]= array(
			"name"=>"�������� �����",
			"link"=>"?mod=polls&action=add"
	   );

$main_menu[]=array(
				"link"=>"?mod=polls",
				"name"=>"polls",
				"title"=>"������",
				"sort"=>"5",
				"sub"=>$sub
			);

?>