<?php 

	$subject = "��������������� ������ http://www." . $_SERVER['SERVER_NAME'];
	$message = '��� �����: '. '<br>��� ������: ';

	$headers  = "Content-type: text/html; charset=windows-1251 \r\n";
	$headers .= "From: <noreply@".$_SERVER['SERVER_NAME'].".ru>\r\n";

	if (mail('andrey.schmitz@gmail.com', $subject, $message, $headers))
		echo 1;

?>