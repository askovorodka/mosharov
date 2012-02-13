<?php

$sub='';

$sub[]= array(
      "name"=>"Редактировать вопрос",
      "link"=>"?mod=questions"
     );
     
$sub[]= array(
      "name"=>"Добавить вопрос",
      "link"=>"?mod=questions&action=add"
     );

$main_menu[]=array(
        "link"=>"?mod=questions",
        "name"=>"questions",
        "title"=>"Вопросы",
        "sort"=>"1",
        "sub"=>$sub
      );

?>