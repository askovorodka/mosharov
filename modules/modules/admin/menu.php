<?php

$sub='';

$sub[]= array(
			"name"=>"Модули сайта",
			"link"=>"index.php?mod=modules"
	   );
$sub[]= array(
			"name"=>"Установить модуль",
			"link"=>"index.php?mod=modules&action=install"
	   );

$main_menu[]=array(
				"link"=>"index.php?mod=modules",
				"name"=>"modules",
				"title"=>"Модули сайта",
				"ico"=>"",
				"sort"=>"91",
				"sub"=>$sub
			);

?>