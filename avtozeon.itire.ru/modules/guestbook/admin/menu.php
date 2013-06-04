<?php

$sub='';

$sub[]= array(
      "name"=>"Редактировать сообщение",
      "link"=>"?mod=guestbook"
     );

$sub[]= array(
      "name"=>"Добавить сообщение",
      "link"=>"?mod=guestbook&action=add"
     );

$main_menu[]=array(
        "link"=>"?mod=guestbook",
        "name"=>"guestbook",
        "title"=>"FAQ",
        "sort"=>"7",
        "sub"=>$sub
      );

?>
