<?php

$sub='';

$sub[]= array(
      "name"=>"������������� ������",
      "link"=>"?mod=questions"
     );
     
$sub[]= array(
      "name"=>"�������� ������",
      "link"=>"?mod=questions&action=add"
     );

$main_menu[]=array(
        "link"=>"?mod=questions",
        "name"=>"questions",
        "title"=>"�������",
        "sort"=>"1",
        "sub"=>$sub
      );

?>