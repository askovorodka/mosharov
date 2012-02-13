<?php

$sub='';

$sub[]= array(
			"name"=>"Файловая система",
			"link"=>"?mod=file_manager"
	   );

$main_menu[]=array(
				"link"=>"?mod=file_manager",
				"name"=>"file_manager",
				"title"=>"Управление файлами",
				"ico"=>"module_8.gif",
				"sort"=>"90",
				"sub"=>$sub
			);

?>