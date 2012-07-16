<?php

$sub='';

$sub[]= array(
			"name"=>"Редактировать настройки",
			"link"=>"?mod=edit_conf"
	   );

$sub[]= array(
			"name"=>"Доступные шаблоны",
			"link"=>"?mod=edit_conf&action=templates"
	   );
$sub[]= array(
			"name"=>"Резервное копирование",
			"link"=>"?mod=edit_conf&action=backup"
	   );

$sub[]= array(
			"name"=>"Шаблоны писем",
			"link"=>"?mod=edit_conf&action=mails"
	   );

$main_menu[]=array(
				"link"=>"?mod=edit_conf",
				"name"=>"edit_conf",
				"title"=>"Настройки",
				"ico"=>"module_9.gif",
				"sort"=>"92",
				"sub"=>$sub
			);

?>