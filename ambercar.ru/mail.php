<?php 

require_once 'lib/class.mail.php';

switch ($_GET['type'])
{
	case 'phone':
		$phone = trim($_GET['phone']);
		$body = "Телефон: " . $phone;
		Mail::send_mail("shand@yandex.ru", $_SERVER['SERVER_NAME'] ." <noreply@".$_SERVER['SERVER_NAME'].">","Телефон пользователя",$body,'','text','standard','utf-8');
		break;
		
	case 'order':
		$name = trim($_GET['name']);
		$auto = trim($_GET['auto']);
		$zapchast = trim($_GET['zapchast']);
		$phone = trim($_GET['phone']);
		
		$body = "Фио: $name \n\nМарка, модель, год выпуска: $auto\n\nЗапчасть: $zapchast\n\nТелефон: $phone";
		
		Mail::send_mail("shand@yandex.ru", $_SERVER['SERVER_NAME'] ." <noreply@".$_SERVER['SERVER_NAME'].">","Заявка на запчасть",$body,'','text','standard','utf-8');
		break;
		
	case 'question':
		$name = trim($_GET['name']);
		$contacts = trim($_GET['contacts']);
		$text = trim($_GET['text']);
		
		$body = "Фио: $name \n\nКонтакты: $contacts\n\nТекст: $text";
		
		Mail::send_mail("shand@yandex.ru", $_SERVER['SERVER_NAME'] ." <noreply@".$_SERVER['SERVER_NAME'].">","Вопрос пользователя с сайта",$body,'','text','standard','utf-8');
		break;
		
}

?>