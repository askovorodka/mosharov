<?php

require_once BASE_PATH.'/lib/class.image.php';

if ($url[$n]!='login' && $url[$n]!='register' && count($url)!=2) {

	$check_auth=Common::check_auth('user');
	if ($check_auth!='1') {
		header ("Location: ".BASE_URL."/$module_url/login/");
		die();
	}
}

require_once 'lib/class.mail.php';
require_once 'lib/class.replace.php';
require_once 'lib/class.password.php';
require_once 'modules/shop/front/class.shop.php';
$navigation[]=array("url" => $module_url,"title" => $node_content['name']);
$smarty->assign("module_url",BASE_URL.'/'.$module_url);

if (count($_GET)>0) {
	unset($url[$n]);
	unset($current_url_pages[count($current_url_pages)-1]);
	$n=count($url)-1;
}

$cur_site=$db->get_single("SELECT kurs,znak FROM fw_currency WHERE id=".CURRENCY_SITE);
$cur_site=String::unformat_array($cur_site);
$cur_site2=$db->get_single("SELECT kurs,znak FROM fw_currency WHERE id=".CURRENCY_SITE2);
$cur_site2=String::unformat_array($cur_site2);

$cur_admin=$db->get_single("SELECT kurs,znak FROM fw_currency WHERE id=".CURRENCY_ADMIN);
$cur_admin=String::unformat_array($cur_admin);
$smarty->assign("currency_site",$cur_site);
$smarty->assign("currency_site2",$cur_site2);

$shop = new Shop($db);
/*-----------------РАЗЛИЧНЫЕ ДЕЙСТВИЯ-----------------*/


if (isset($_POST['submit_restore'])){

      $email = $_POST['email'];

      $item = $db->get_single("SELECT id,login FROM fw_users WHERE mail='".$email."'");

      if ($item['id'] != ""){
            $pwd = new Password();
            $password = $pwd->generate();
            $db->query("UPDATE fw_users SET password='".md5($password)."' WHERE id=".intval($item['id']));

            $subject = "Регистрационные данные http://www." . $_SERVER['SERVER_NAME'];
            $message = 'Ваш логин: ' . $item['login'] . '<br>Ваш пароль: ' .$password;
            $message .= '<br>Авторизация: http://' . $_SERVER['SERVER_NAME'] . '/cabinet/login/';
			
            $headers  = "Content-type: text/html; charset=windows-1251 \r\n";
            $headers .= "From: <noreply@".$_SERVER['SERVER_NAME'].".ru>\r\n";

            mail($_POST['email'], $subject, $message, $headers);

            $smarty->assign("error_message",'На ваш E-mail выслан новый пароль');
      }

      else
            $smarty->assign("error_message",'Такой e-mail отсутствует');

}


if (isset($_POST['submit_login'])) {

	$check = true;

	$login=String::secure_format($_POST['email']);
	if (isset($_POST['submit_login_top']))$top=$_POST['submit_login_top'];
	if (isset($_POST['submit_login_basket']))$basket=$_POST['submit_login_basket'];
	$password=$_POST['password'];


	if (trim($password) == "") {
		$smarty->assign("error_message",'Введите пожалуйста ваш пароль');
		$smarty->assign("email",$login);
		$check=false;
	}

	if (trim($login) == "") {
		$smarty->assign("error_message",'Введите пожалуйста ваш логин');
		$check=false;
	}
	
	if ($check==true) {

		$content=$db->get_single("SELECT * FROM fw_users WHERE login='$login' AND status='1'");
		$password_to_check = @$content['password'];
		if (empty($password_to_check)) {
			$smarty->assign("error_message",'Такого пользователя не существует');
			$smarty->assign("email",$login);
			//echo 'Такого пользователя не существует';
			//echo "error2";
			//die();
		}
		else {

			if (sha1($password) != $password_to_check) {
				$smarty->assign("error_message",'Неправильный пароль');
				$smarty->assign("email",$login);
				//echo 'Неправильный пароль';
				//echo sha1($password) . " - " . $password_to_check;
				//echo "error2";
				//die();
			}
			else {
				setcookie('fw_login_cookie',$login."|".sha1($password),time()+LOGIN_LIFETIME,'/','');
				$_SESSION['fw_user'] = $content;
				
				if (!empty($_SESSION['fw_basket']))
				{
					header("Location: ".BASE_URL.'/catalog/basket/step1/');
					die();
				}
				
				//header("Location: ".BASE_URL.'/cabinet/');
				//echo 1;
				//die();
				if ($_SERVER['HTTP_REFERER']==BASE_URL.'/'.$module_url.'/login') header ("Location:". BASE_URL.'/'.$module_url);
				else {
					$location=$_SERVER['HTTP_REFERER'];
					header ("Location: $location");

				}
			}

		}
	}

	//exit();

}

if ($url[$n]=='logout' && count($url)==2) {

	setcookie('fw_login_cookie',"",time()-5555,'/','');
	session_destroy();
	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();

}

if (isset($_POST['submit_user_register'])) {

	$registration_success=true;
    //$pwd = new Password();
	//$password=$pwd->generate();
	$login=String::secure_user_input($_POST['useremail']);
	$name=String::secure_user_input(iconv('utf-8','windows-1251',$_POST['username']));
	$password=String::secure_user_input(iconv('utf-8','windows-1251',$_POST['pass']));
	$phone=String::secure_user_input($_POST['phone']);
	$address=String::secure_user_input(iconv('utf-8','windows-1251',$_POST['address']));

	//если юзер не ввел пароль
	if (empty($password))
	{
	    $pwd = new Password();
		$password=$pwd->generate();
	}
	
	if (!preg_match("/^([0-9A-z\._-]+)@([0-9A-z\._-]+)\.([A-z]+)$/",$login)) {
		$registration_success=false;
		$smarty->assign("error_message","Неправильный формат e-mail адреса");
		echo "error1";
		exit();
		
	}
	else {
		$result=$db->get_all("SELECT login FROM fw_users WHERE login='$login'");
		if (count($result)>0) {
			$registration_success=false;
			$smarty->assign("error_message","Пользователь с таким почтовым адресом уже существует.");
			echo "error2";
			exit();
		}
	}

	if (isset($_FILES['avatar']['tmp_name']) && $_FILES['avatar']['tmp_name']!='') {

		$avatar=$_FILES['avatar']['name'];
		$tmp=$_FILES['avatar']['tmp_name'];

		$trusted_formats=array("gif","jpg","jpeg","png");

		$output=Image::image_details($tmp);

		$check_file_name=explode(".",$avatar);
		$ext=$check_file_name[count($check_file_name)-1];

		if (!in_array($output['format'],$trusted_formats)) {
			$smarty->assign("error","Разрешены аватары форматов jpg, jpeg, gif и png");
			$registration_success=false;
		}

		if ($output['width']>1600 or $output['height']>1600) {

			$smarty->assign("error","Слишком большой аватар!");
			$registration_success=false;
		}

	}
	else $ext='';

	if (isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['tmp_name']!='') {

		$photo=$_FILES['photo']['name'];
		$tmp=$_FILES['photo']['tmp_name'];

		$trusted_formats=array("gif","jpg","jpeg","png");

		$output=Image::image_details($tmp);

		$check_file_name=explode(".",$photo);
		$u_photo=$check_file_name[count($check_file_name)-1];

		if (!in_array($output['format'],$trusted_formats)) {
			$smarty->assign("error","Разрешены фотографии форматов jpg, jpeg, gif и png");
			$registration_success=false;
		}

		if ($output['width']>1600 or $output['height']>1600) {

			$smarty->assign("error","Слишком большая фотография!");
			$registration_success=false;
		}

	}
	else $u_photo='';


	if ($registration_success==false)
	{
		$smarty->assign("temp",$_POST);
		exit();
	}
	else {
		$smarty->assign("registration_success","1");
		
		$db->query("INSERT INTO fw_users(login, password, name, mail, tel, reg_date, priv, status, address) VALUES('{$login}','".sha1($password)."','{$name}','{$login}','{$phone}','".time()."','9','1', '{$address}')");
		
		$to_id=mysql_insert_id();
		if (isset($_FILES['avatar']['tmp_name']) && $_FILES['avatar']['tmp_name']!='')
		{
			if (move_uploaded_file($tmp, BASE_PATH.'/uploaded_files/avatars/'.$to_id.'.'.$ext))
			{
				chmod(BASE_PATH.'/uploaded_files/avatars/'.$to_id.'.'.$ext, 0644);
				Image::image_resize(BASE_PATH.'/uploaded_files/avatars/'.$to_id.'.'.$ext,BASE_PATH.'/uploaded_files/avatars/'.$to_id.'.'.$ext,120,120);

			}
		}

		if (isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['tmp_name']!='')
		{

			if (move_uploaded_file($tmp, BASE_PATH.'/uploaded_files/profile_photos/'.$to_id.'.'.$u_photo))
			{
				chmod(BASE_PATH.'/uploaded_files/profile_photos/'.$to_id.'.'.$u_photo, 0644);
				Image::image_resize(BASE_PATH.'/uploaded_files/profile_photos/'.$to_id.'.'.$u_photo,BASE_PATH.'/uploaded_files/profile_photos/small-'.$to_id.'.'.$u_photo,400,400);

			}
		}

		$smarty->assign("site",BASE_URL);
		setcookie('fw_login_cookie',$login."|".sha1($password),time()+LOGIN_LIFETIME,'/','');
		$_SESSION['fw_user'] = $db->get_single("SELECT * FROM fw_users WHERE id='".mysql_insert_id()."'");
		$mail_template = $db->get_single("SELECT template FROM fw_mails_templates WHERE mail_key='REGISTOR_MAIL'");
		
		$smarty->assign("site_url",BASE_URL);
		$smarty->assign("login",$login);
		$smarty->assign("password",$password);
		$message_body=$smarty->fetch($templates_path.'/registration_mail.txt');
		$message_body = $mail_template['template'];
		$message_body = str_replace("{site_url}",BASE_URL,$message_body);
		$message_body = str_replace("{login}",$login,$message_body);
		$message_body = str_replace("{password}",$password,$message_body);
		
        $headers  = "Content-type: text/html; charset=windows-1251 \r\n";
        $headers .= "From: <noreply@".$_SERVER['SERVER_NAME'].".ru>\r\n";

		Mail::send_mail($login,"register@".$_SERVER['SERVER_NAME'],"Регистрация на сайте ".BASE_URL,$message_body,"","html","standard","windows-1251");
		//Mail::send_mail(ADMIN_MAIL,"register@".$_SERVER['SERVER_NAME'],"Регистрация на сайте ".BASE_URL,$message_body,"","html","standard","windows-1251");
		
		echo 1;
		exit();
		//перенаправляем на второй шак в корзину
		if ($_SERVER['HTTP_REFERER'] && preg_match("/basket\/step1/i",$_SERVER['HTTP_REFERER']))
		{
			header("location:".BASE_URL."/catalog/basket/step2/");
			exit();
		}

    }

}

if (isset($_POST['submit_edit_user'])) {

	$check=true;
	$id=$_SESSION['fw_user']['id'];
	//$password=String::secure_user_input($_POST['edit_user_password']);
	//$old_password=String::secure_user_input($_POST['old_password']);
	$mail=String::secure_user_input($_POST['mail']);
	$old_mail=String::secure_user_input($_POST['old_mail']);
	$name=String::secure_user_input($_POST['name']);
	$place=String::secure_user_input($_POST['place']);
	//$work=String::secure_user_input($_POST['work']);
	$site=String::secure_user_input($_POST['site']);
	//$about=String::secure_user_input($_POST['about']);
	//$signature=String::secure_user_input($_POST['signature']);
	//$send_forum_answers=String::secure_user_input($_POST['send_forum_answers']);
	//if (substr_count($site,"http://")==0 && $site!='') $site='http://'.$site;
	/*if ($password>'1') {
		if (!preg_match("/^([0-9A-z_]+)$/",$password)) {
			$check=false;
			$smarty->assign("error_message","Неправильный формат пароля - допустимы латинские буквы, цифры и символ подчёркивания.");
		}
		else
			$password = md5($password);
	}
	else $password=$old_password;*/

	if ($old_mail!=$mail)
	{
		if (!preg_match("/^([0-9A-z\._-]+)@([0-9A-z\._-]+)\.([A-z]+)$/",$mail)) {
			$check=false;
			$smarty->assign("error_message","Неправильный формат e-mail адреса");
		}
		else {
			$result=$db->get_all("SELECT login FROM fw_users WHERE mail='$mail'");
			if (count($result)>0) {
				$check=false;
				$smarty->assign("error_message","Пользователь с таким почтовым адресом уже существует.");
			}
		}
	}

	if (isset($_FILES['avatar']['tmp_name']) && $_FILES['avatar']['tmp_name']!='') {

		$avatar=$_FILES['avatar']['name'];
		$tmp=$_FILES['avatar']['tmp_name'];

		$trusted_formats=array("gif","jpg","jpeg","png");

		$output=Image::image_details($tmp);

		$check_file_name=explode(".",$avatar);
		$ext=$check_file_name[count($check_file_name)-1];

		if (!in_array($output['format'],$trusted_formats)) {
			$smarty->assign("error_message","Разрешены аватары форматов jpg, jpeg, gif и png");
			$registration_success=false;
		}

		if ($output['width']>1600 or $output['height']>1600) {
			$smarty->assign("error","Слишком большой аватар!");
			$registration_success=false;
		}

	}
	else $ext=String::secure_user_input($_POST['old_avatar']);


	if (isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['tmp_name']!='') {

		$photo=$_FILES['photo']['name'];
		$tmp=$_FILES['photo']['tmp_name'];

		$trusted_formats=array("gif","jpg","jpeg","png");

		$output=Image::image_details($tmp);

		$check_file_name=explode(".",$photo);
		$u_photo=$check_file_name[count($check_file_name)-1];

		if (!in_array($output['format'],$trusted_formats)) {
			$smarty->assign("error_message","Разрешены фотографии форматов jpg, jpeg, gif и png");
			$registration_success=false;
		}

		if ($output['width']>1600 or $output['height']>1600) {
			$smarty->assign("error","Слишком большая фотография!");
			$registration_success=false;
		}

	}
	else $u_photo=String::secure_user_input($_POST['old_photo']);

	if ($check==true) {

		$db->query("UPDATE fw_users SET
										name='$name',
										mail='$mail',
										place='$place',
										site='$site'
									 WHERE id='".$_SESSION['fw_user']['id']."'");

		if (isset($_FILES['avatar']['tmp_name']) && $_FILES['avatar']['tmp_name']!='') {

			if (move_uploaded_file($tmp, BASE_PATH.'/uploaded_files/avatars/'.$id.'.'.$ext)) {
				chmod(BASE_PATH.'/uploaded_files/avatars/'.$id.'.'.$ext, 0644);
				Image::image_resize(BASE_PATH.'/uploaded_files/avatars/'.$id.'.'.$ext,BASE_PATH.'/uploaded_files/avatars/'.$id.'.'.$ext,120,120);

			}
		}

		if (isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['tmp_name']!='') {

			if (move_uploaded_file($tmp, BASE_PATH.'/uploaded_files/profile_photos/'.$id.'.'.$u_photo)) {
				chmod(BASE_PATH.'/uploaded_files/profile_photos/'.$id.'.'.$u_photo, 0644);
				Image::image_resize(BASE_PATH.'/uploaded_files/profile_photos/'.$id.'.'.$u_photo,BASE_PATH.'/uploaded_files/profile_photos/small-'.$id.'.'.$u_photo,400,400);

			}
		}

	}

}

if (isset($_POST['submit_add_album'])) {

	$parent=$_SESSION['fw_user']['id'];
	$name=String::secure_format($_POST['edit_name']);
	$description=String::secure_format($_POST['edit_description']);

	if ($name=='') $name='Новый альбом';

	$get_order=$db->get_single("SELECT MAX(sort_order) AS sort_order FROM fw_user_albums WHERE parent='$parent'");
	$sort_order=$get_order['sort_order']+1;

	$db->query("INSERT INTO fw_user_albums(parent,name,description,insert_date,status,sort_order) VALUES('$parent','$name','$description','".time()."','1','$sort_order')");
	header("Location: ".BASE_URL."/users/photoalbum/edit/".mysql_insert_id());
}

if (isset($_POST['submit_edit_album'])) {

	$name=String::secure_format($_POST['edit_name']);
	$description=String::secure_format($_POST['edit_description']);
	$status=$_POST['edit_status'];

	$id=$_POST['id'];

	$db->query("UPDATE fw_user_albums SET name='$name',description='$description',status='$status' WHERE id='$id'");
}


if (isset($_POST['submit_add_photo'])) {

	$check=true;

	$parent=$_POST['parent'];
	$title=String::secure_format($_POST['add_photo_title']);
	$file_name=$_FILES['add_new_photo']['name'];
	$tmp=$_FILES['add_new_photo']['tmp_name'];

	$trusted_formats=explode(",",ALLOWED_FORMATS);

	$output=Image::image_details($_FILES['add_new_photo']['tmp_name']);

	$check_file_name=explode(".",$file_name);
	$ext=$check_file_name[count($check_file_name)-1];

	if (!in_array($output['format'],$trusted_formats)) {
		$smarty->assign("error","Разрешены картинки форматов ".ALLOWED_FORMATS);
		$check=false;
	}

	list($max_width,$max_height)=explode("x",PHOTO_MAX_SIZE);


	if ($output['width']>$max_width or $output['height']>$max_height) {
		$resize_main=true;
	}
	else $resize_main=false;

	if (filesize($tmp)>PHOTO_MAX_FILESIZE*1000) {
		$smarty->assign("error","Размер фотографии не должен привышать ".PHOTO_MAX_FILESIZE."Кб");
		$check=false;
	}

	if ($check) {

		$order=$db->get_single("SELECT MAX(sort_order)+1 AS s_order FROM fw_user_images WHERE parent='$parent'");
		if ($order['s_order']=='') $order=1;
		else $order=$order['s_order'];

		$filesize=round(filesize($tmp)/1000,2);
		$result=$db->query("INSERT INTO fw_user_images(parent,title,ext,sort_order,insert_date) VALUES('$parent','$title','$ext','$order','".time()."')");
		$id=mysql_insert_id();
		if (move_uploaded_file($tmp, BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/'.$id.'.'.$ext)) {
			chmod(BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/'.$id.'.'.$ext, 0644);
			Image::image_resize(BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/'.$id.'.'.$ext,BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/small-'.$id.'.'.$ext,PREVIEW1_WIDTH,PREVIEW1_HEIGTH);
						if ($output['width']>PREVIEW2_WIDTH or $output['height']>PREVIEW2_HEIGHT) Image::image_resize(BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/'.$id.'.'.$ext,BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/medium-'.$id.'.'.$ext,PREVIEW2_WIDTH,PREVIEW2_HEIGTH);
			if ($resize_main) Image::image_resize(BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/'.$id.'.'.$ext,BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/'.$id.'.'.$ext,$max_width,$max_height);
			if (isset($_POST['add_photo_watermark'])) Image::image_add_logo(BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/'.$id.'.'.$ext,BASE_PATH.'/lib/watermark/watermark.png');
			$smarty->assign("message","Фотография успешно добавлена");
		}
		else {
			$result=$db->query("DELETE FROM fw_user_images WHERE id='".mysql_insert_id()."'");
			$smarty->assign("error","Фотография не была загружена!");
		}

		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
	}

}


if (isset($_POST['submit_save_photos'])) {

	$check=true;

	if (isset($_POST['delete_photos'])) {
		$delete_photos=$_POST['delete_photos'];
		for ($i=0;$i<count($delete_photos);$i++) {
			$values.=$delete_photos[$i];
			if ($i!=count($delete_photos)-1) $values.=',';

			foreach (glob(BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/'.$delete_photos[$i].".*") as $filename) {
				unlink($filename);
			}
			foreach (glob(BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/'."*-".$delete_photos[$i].".*") as $filename) {
				unlink($filename);
			}
		}
		$db->query("DELETE FROM fw_user_images WHERE id IN ($values)");
		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
	}


	if (@in_array('1',$_POST['order_changed'])) {

		$order_changed=array_keys($_POST['order_changed'],"1");
		$order=$_POST['edit_order'];

		for ($i=0;$i<count($order_changed);$i++) {
			$new_order=$order[$order_changed[$i]];
			$db->query("UPDATE fw_user_images SET sort_order='$new_order' WHERE id='".$order_changed[$i]."'");
		}
	}

	if (@in_array('1',$_POST['title_changed'])) {

		$title_changed=array_keys($_POST['title_changed'],"1");
		$title=$_POST['edit_title'];

		for ($i=0;$i<count($title_changed);$i++) {
			$new_title=$title[$title_changed[$i]];
			$db->query("UPDATE fw_user_images SET title='$new_title' WHERE id='".$title_changed[$i]."'");
		}
	}

	if (@in_array('1',$_POST['link_changed'])) {

		$link_changed=array_keys($_POST['link_changed'],"1");
		$link=$_POST['edit_link'];

		for ($i=0;$i<count($link_changed);$i++) {
			$new_link=$link[$link_changed[$i]];
			$db->query("UPDATE fw_user_images SET link='$new_link' WHERE id='".$link_changed[$i]."'");
		}
	}

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}


if (isset($_POST['submit_new_message'])) {

	$check=true;

	$from=$_SESSION['fw_user']['id'];
	$to=String::secure_user_input($_POST['to']);
	$subject=String::secure_user_input($_POST['subject']);
	$text=String::secure_user_input($_POST['text']);

	$check_user=$db->get_single("SELECT id,mail FROM fw_users WHERE login='$to'");

	if (!isset($check_user['id'])) {

		$check=false;
		$smarty->assign("error_message","Пользователя, которому вы пытаетесь отправить сообщение, не существует");
	}
	else {
		$to=$check_user['id'];
	}


	if ($check) {

		$messages_count=$db->get_single("SELECT COUNT(*) AS count FROM fw_messages WHERE `to`='$to'");

		if ($messages_count['count']>=MAX_MESSAGES) $db->query("DELETE FROM fw_messages WHERE `to`='$to' ORDER BY publish_date LIMIT 1");

		$db->query("INSERT INTO fw_messages(`from`,`to`,`subject`,`text`,`publish_date`) VALUES('$from','$to','$subject','$text','".time()."')");

		if ($check_user['mail']!='') {
			$smarty->assign("site_url",BASE_URL);
			$smarty->assign("answer_url",BASE_URL.'/users/messages/new/?to='.$from);
			$smarty->assign("cabinet_url",BASE_URL.'/cabinet/');
			$smarty->assign("author",$_SESSION['fw_user']['name']);
			$smarty->assign("message",$text);
			$message_body=$smarty->fetch($templates_path.'/new_message_notification.txt');
			Mail::send_mail($check_user['mail'],ADMIN_MAIL,"Новое личное сообщение на сайте ".BASE_URL,$message_body,"","text","standard","windows-1251");
		}

		$smarty->assign("message","Сообщение отправлено");
	}
}

if (count($url)==4 && $url[$n-2]=='messages' && $url[$n-1]=='delete') {

	$page_found=true;

	$id=$url[$n];

	$db->query("DELETE FROM fw_messages WHERE id='$id' AND (`to`='".$_SESSION['fw_user']['id']."' OR `from`='".$_SESSION['fw_user']['id']."')");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if (isset($_POST['submit_edit_albums'])) {

	$sort_order=$_POST['sort_order'];


	foreach ($sort_order as $k=>$v) {

		if (preg_match("/^[0-9]*$/",String::secure_user_input($v))) {
			$db->query("UPDATE fw_user_albums SET sort_order='".String::secure_user_input($v)."' WHERE id='".String::secure_user_input($k)."'");
		}
	}

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

/*--------------------ОТОБРАЖЕНИЕ---------------------*/


SWITCH (TRUE){


	CASE ($url[$n]=='login' && count($url)==2):

		$navigation[]=array("url" => 'register',"title" => 'Войти');

		$page_found=true;
		$template='cabinet_login.html';

	BREAK;

	CASE ($url[$n]=='register' && count($url)==2):

		$navigation[]=array("url" => 'register',"title" => 'Стать своим');

		$smarty->assign("mode","register");

		$page_found=true;
		$template='edit_user.html';

	BREAK;

	CASE ($url[$n]=='profile' && count($url)==2):

		$navigation[]=array("url" => 'profile',"title" => 'Редактировать свои данные');
		$profile=$db->get_single("SELECT * FROM fw_users WHERE id='".$_SESSION['fw_user']['id']."'");
		$profile=String::unformat_array($profile);
		$smarty->assign("profile",$profile);
		$smarty->assign("mode","edit");
		$page_found=true;
		$template='edit_user.html';

	BREAK;

	CASE ($url[$n]=='photoalbum' && count($url)==2):

		$navigation[]=array("url" => 'photoalbum',"title" => 'Мой фотоальбом');

		$photoalbums_list=$db->get_all("SELECT * FROM fw_user_albums WHERE parent='".$_SESSION['fw_user']['id']."'");

		$smarty->assign("photoalbums_list",$photoalbums_list);

		$page_found=true;
		$template='photoalbums_list.html';

	BREAK;

	CASE ($url[$n]=='add' && $url[$n-1]=='photoalbum' && count($url)==3):

		$navigation[]=array("url" => 'photoalbum',"title" => 'Мой фотоальбом');
		$navigation[]=array("url" => 'add',"title" => 'Добавить альбом');

		$smarty->assign("mode","add");

		$page_found=true;
		$template='edit_album.html';

	BREAK;

	CASE (count($url)==4 && $url[$n-1]=='edit' && $url[$n-2]=='photoalbum'):

		$id=$url[$n];

		$navigation[]=array("url" => 'photoalbum',"title" => 'Мой фотоальбом');
		$navigation[]=array("url" => 'add',"title" => 'Редактировать альбом');

		$album=$db->get_single("SELECT * FROM fw_user_albums WHERE id='$id'");

		$smarty->assign("album",$album);

		$photos_list=$db->get_all("SELECT * FROM fw_user_images WHERE parent='$id' ORDER BY sort_order");
		$photos_count=count($photos_list);

		$smarty->assign("photos_height",PREVIEW1_HEIGTH+10);
		$smarty->assign('photos_list',$photos_list);

		$smarty->assign('photos_count',$photos_count);

		$smarty->assign("mode","edit");

		$page_found=true;
		$template='edit_album.html';

	BREAK;

	CASE (count($url)==4 && $url[$n-1]=='delete' && $url[$n-2]=='photoalbum'):

		$id=$url[$n];

		$page_found=true;

		$albums_id=$id;

		$photos=$db->get_all("SELECT id,ext FROM fw_user_images WHERE parent IN ($albums_id)");

		foreach ($photos as $k=>$v) {
			$files_to_delete[]=$v['id'].'.'.$v['ext'];
			$files_to_delete[]='small-'.$v['id'].'.'.$v['ext'];
			$files_to_delete[]='medium-'.$v['id'].'.'.$v['ext'];
		}

		$db->query("DELETE FROM fw_user_images WHERE parent IN ($albums_id)");
		$db->query("DELETE FROM fw_user_albums WHERE id IN ($albums_id)");

		foreach ($files_to_delete as $k=>$v) {
			unlink(BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/'.$v);
		}

		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");

	BREAK;

	CASE (count($url)==2 && $url[$n]=='messages'):

		$page_found=true;

		$navigation[]=array("url" => 'messages',"title" => 'Личные сообщения');

		$id=$_SESSION['fw_user']['id'];

		$messages_list=$db->get_all("SELECT *,
												(SELECT name FROM fw_users WHERE id=`from`) AS `from`
												FROM fw_messages WHERE `to`='$id'");

		$smarty->assign("messages_list",$messages_list);

		$messages_list2=$db->get_all("SELECT *,
												(SELECT name FROM fw_users WHERE id=`to`) AS `to`
												FROM fw_messages WHERE `from`='$id'");

		$smarty->assign("messages_list2",$messages_list2);

		$template='messages_list.html';

	BREAK;

	CASE (count($url)==3 && $url[$n-1]=='messages' && preg_match("/^[0-9]*$/",$url[$n])):

		$navigation[]=array("url" => 'messages',"title" => 'Личные сообщения');

		$id=$url[$n];
		$user=$_SESSION['fw_user']['id'];

		$message=$db->get_single("SELECT *,
											(SELECT name FROM fw_users WHERE id=`from`) AS author,
											(SELECT login FROM fw_users WHERE id=`from`) AS author_login
											FROM fw_messages WHERE (`to`='$user' OR `from`='$user') AND id='$id'");

		if (isset($message['id'])) {

			$page_found=true;

			if ($message['subject']=='') $message['subject']='Нет темы';

			$message['text']=nl2br($message['text']);

			$navigation[]=array("url" => '',"title" => $message['subject']);

			$db->query("UPDATE fw_messages SET `read`='1' WHERE `to`='$user' AND id='$id'");

			$smarty->assign("message",$message);

			$template='single_message.html';
		}

	BREAK;

	CASE (count($url)==3 && $url[$n-1]=='messages' && $url[$n]=='new'):

		$page_found=true;

		$navigation[]=array("url" => 'messages',"title" => 'Личные сообщения');
		$navigation[]=array("url" => 'new',"title" => 'Новое сообщение');

		$id=$_SESSION['fw_user']['id'];

		if (isset($_GET['to'])) $smarty->assign("to",$_GET['to']);
		if (isset($_GET['comment'])) {
			$res=$db->get_single("SELECT text FROM fw_messages WHERE id='".intval($_GET['comment'])."' AND (`to`='".$id."' OR `from`='".$id."')");
			if (count($res)>0) $smarty->assign("comment",$res['text']);
		}

		$template='new_message.html';

	BREAK;


  CASE ($url[$n]=='orders' && count($url)==2):

    $navigation[]=array("url" => 'orders',"title" => 'История заказов');

    $orders_list=$db->get_all("SELECT *  FROM fw_orders WHERE user='".$_SESSION['fw_user']['id']."' ORDER BY insert_date DESC");
    $orders_list=String::unformat_array($orders_list,'front');

    foreach ($orders_list as $key=>$val)
    {
    	$orders_list[$key]['products_list'] = $db->get_all("
    	select a.*, b.name, b.price, b.article, (a.product_count * b.price) as total_price
    	from fw_orders_products as a
    	left join fw_products as b on a.product_id = b.id 
    	where a.order_id = '{$val['id']}' ");
    	foreach ($orders_list[$key]['products_list'] as $key2=>$val2)
    	{
    		$orders_list[$key]['products_list'][$key2]['full_url'] = $shop->getFullUrlProduct( $val2['product_id'], "catalog" );
    	}
    }
    
    $page_found=true;
    $smarty->assign("orders_list",$orders_list);
    $smarty->assign("currency",DEFAULT_CURRENCY);
    $template='orders.html';

  BREAK;


  CASE ($url[$n]=='restore' && count($url)==2):

	   //echo $pwd->replaceMailContent(array("{login}"=>$login,"{password}"=>$password,"{site_url}"=>$site_url), $item['template']);
	   
	   $navigation[]=array("url" => 'profile',"title" => 'Восстановление пароля');
       $page_found=true;
       $template='restore_pwd.html';

  BREAK;


  CASE ($url[$n]=='history_orders' && count($url)==2):

  		if (empty($_SESSION['fw_user'])){
  			header("Location: /cabinet/");
  			exit;
  		}
        $navigation[]=array("url" => 'history_orders',"title" => 'История заказов');
  		$page_found=true;

		$profile=$db->get_single("SELECT *,(SELECT COUNT(*) FROM fw_orders WHERE user=u.id) AS orders FROM fw_users u WHERE u.id='".$_SESSION['fw_user']['id']."'");
		$profile=String::unformat_array($profile,'front');

        $orders_list = $db->get_all("SELECT a.id,a.user,a.insert_date,a.status,
									b.product_id,b.order_id,b.product_count,
									c.name,c.small_description,c.price,c.article FROM fw_products
									as c INNER JOIN (fw_orders as a INNER JOIN fw_orders_products as b
									ON b.order_id=a.id) ON c.id=b.product_id
									WHERE a.user='".$_SESSION['fw_user']['id']."'"
		);

        $search = array("'<FONT[^>]*?>'", "'</FONT>'", "'<font[^>]*?>'", "'</font>'");

        $replace = new Replace();

        if (count($orders_list)){
        	foreach($orders_list as $key=>$val){
              	$price = $orders_list[$key]['price'];
                $orders_list[$key]['price']=number_format(($orders_list[$key]['price'] * $cur_admin['kurs'])/$cur_site['kurs'],2);
                $orders_list[$key]['price2']=number_format(($price * $cur_admin['kurs'])/$cur_site2['kurs'],2);
                $orders_list[$key]['small_description'] = $replace->getReplace($search,"",$orders_list[$key]['small_description']);
        	}
        }

        if (count($orders_list)>0){
        	$orders_list=String::unformat_array($orders_list,'front');
        	$smarty->assign("orders_list",$orders_list);
        }


  		$template='cabinet_orders.html';

  BREAK;

  DEFAULT:

		if (count($url)==1) $page_found=true;
		$profile=$db->get_single("SELECT * FROM fw_users u WHERE u.id='".$_SESSION['fw_user']['id']."'");
		$profile=String::unformat_array($profile,'front');
		$smarty->assign("temp",$profile);
		$main=$smarty->fetch($templates_path.'/cabinet_main_new.html');
		$smarty->assign("main",$main);
		$smarty->assign("content",$node_content['elements']);

}


?>