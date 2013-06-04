<?php
$name=$_POST[name];
$email=$_POST[email];
$theme=$_POST[theme];
$message=$_POST[message];


$mes="<strong>Имя: </strong>".$name."<br> <strong>E-mail: </strong>".$email."<br> <strong>Сообщение: </strong>".$message;

echo $mes;


$headers .= "Content-type: text/html; charset=windows-1251\r\n";
$headers .= "Mime-Version: 1.0\r\n";


mail("dom-stroi-plus@mail.ru",$theme,$mes, $headers);	

$hst="http://dom-stroi-plus.ru/dom-stroi-plus/item_28/";
echo "<script language='JavaScript'> document.location.href ='".$hst."';</script>";
?>