<?php

$sub='';

$sub[]= array(
      "name"=>"������������� ���������",
      "link"=>"?mod=guestbook"
     );

$sub[]= array(
      "name"=>"�������� ���������",
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
