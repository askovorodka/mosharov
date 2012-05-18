<?php

$sub='';

$sub[]= array(
			"name"=>"Группы пользователей",
			"link"=>"?mod=users&action=groups"
	   );

$sub[]= array(
			"name"=>"Список пользователей",
			"link"=>"?mod=users"
	   );
$sub[]= array(
			"name"=>"Добавить пользователя",
			"link"=>"?mod=users&action=add_user"
	   );

$main_menu[]=array(
				"link"=>"?mod=users",
				"name"=>"users",
				"title"=>"Пользователи",
				"ico"=>"module_7.gif",
				"sort"=>"89",
				"sub"=>$sub
			);

?>