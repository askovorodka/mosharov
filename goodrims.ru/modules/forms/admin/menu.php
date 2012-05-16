<?php

$sub='';

$sub[]= array(
			"name"=>"Список форм отправки",
			"link"=>"?mod=forms"
	   );
$sub[]= array(
			"name"=>"Добавить форму",
			"link"=>"?mod=forms&action=add"
	   );
	   
$main_menu[]=array(
				"link"=>"?mod=forms",
				"name"=>"forms",
				"title"=>"Формы отправки",
				"sort"=>"3",
				"sub"=>$sub
			);

?>