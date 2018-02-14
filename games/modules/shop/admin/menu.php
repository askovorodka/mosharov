<?php
$sub='';

$sub[]= array(
    "name"=>"Категории",
    "link"=>"?mod=shop&action=catalogue"
);
$sub[]= array(
    "name"=>"Продукты",
    "link"=>"?mod=shop&action=products_list"
);
$sub[]= array(
    "name"=>"Список заказов",
    "link"=>"?mod=shop&action=orders"
);

$main_menu[]=array(
    "link"=>"?mod=shop",
    "name"=>"shop",
    "title"=>"Магазин",
    "ico"=>"module_3.gif",
    "sort"=>"4",
    "sub"=>$sub
);

?>