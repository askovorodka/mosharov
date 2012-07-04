<?php

$sub='';

$sub[]= array(
			"name"=>"Подписчики",
			"link"=>"?mod=subscribe&action=users"
	   );

$sub[]= array(
			"name"=>"Группы подписчиков",
			"link"=>"?mod=subscribe&action=groups"
	   );
$sub[]= array(
			"name"=>"Шаблоны",
			"link"=>"?mod=subscribe&action=templates"
	   );
	   
$sub[]= array(
			"name"=>"Отправить письмо",
			"link"=>"?mod=subscribe"
	   );

$main_menu[]=array(
				"link"=>"?mod=subscribe",
				"name"=>"subscribe",
				"title"=>"Рассылка",
				"sort"=>"8",
				"sub"=>$sub
			);

?>