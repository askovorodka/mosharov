<?php

require_once (BASE_PATH.'/lib/class.mail.php');

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';


/*------------------------- ВЫПОЛНЯЕМ РАЗЛИЧНЫЕ ДЕЙСТВИЯ ---------------------*/




if ($action=="change_message_status" && isset($_GET['id'])) {
	$id=intval($_GET['id']);
	$db->query("UPDATE fw_guestbook SET status=IF(status='0','1','0') WHERE id='".$id."'");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
}


if (isset($_POST['submit_add_guestbook'])) {

  Common::check_priv("$priv");

  $check=true;

  $author=String::secure_format($_POST['edit_guestbook_author']);
  $message=String::secure_format($_POST['edit_guestbook_message']);
  $tema=String::secure_format($_POST['edit_guestbook_tema']);
  $author_mail=String::secure_format($_POST['edit_guestbook_mail']);


  if ($check) {
    $result=$db->query("INSERT INTO fw_guestbook (tema,author,message,author_mail,insert_date) VALUES('$tema','$author','$message','$author_mail','".time()."')");
  }
}




if (isset($_POST['submit_edit_guestbook'])) {

  Common::check_priv("$priv");

  $check=true;

  $id=$_POST['id'];
  $author=String::secure_format($_POST['edit_guestbook_author']);
  $message=String::secure_format($_POST['edit_guestbook_message']);
  $answer=String::secure_format($_POST['edit_guestbook_answer']);
  $author_mail=String::secure_format($_POST['edit_guestbook_mail']);
  $status=String::secure_format($_POST['status']);
  $tema=String::secure_format($_POST['edit_guestbook_tema']);


  if (isset($_POST['update_time'])) $time=time();
  else $time=mktime($_POST['edit_guestbook_date_hour'],$_POST['edit_guestbook_date_minutes'],0,$_POST['edit_guestbook_date_month'],$_POST['edit_guestbook_date_day'],$_POST['edit_guestbook_date_year']);

  if ($check) {
    $smarty->assign("success_message","Сообщение успешно отредактировано!");
    $result=$db->query("UPDATE fw_guestbook SET tema='$tema',answer='$answer',status='$status',author='$author',message='$message',author_mail='$author_mail',insert_date='$time' WHERE id='$id'");
  }
}



if ($action=='show' && isset($_GET['id'])) {

	Common::check_priv("$priv");

	$id=$_GET['id'];

	$db->query("UPDATE fw_guestbook SET status='1' WHERE id='$id'");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if ($action=='hide' && isset($_GET['id'])) {

	Common::check_priv("$priv");

	$id=$_GET['id'];

	$db->query("UPDATE fw_guestbook SET status='0' WHERE id='$id'");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if ($action=='delete' && isset($_GET['id'])) {

	Common::check_priv("$priv");

	$id=$_GET['id'];

	$db->query("DELETE FROM fw_guestbook WHERE id='$id' LIMIT 1");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if ($action=='delete_msg' && isset($_GET['id'])) {

	Common::check_priv("$priv");

	$id=$_GET['id'];

	$db->query("DELETE FROM fw_guestbook WHERE id='$id' LIMIT 1");

  	header ("Location: index.php?mod=guestbook");
  	die();
}

if (isset($_POST['submit_edit_message'])) {

	$id=$_POST['id'];

	$text=Common::strip_forum_tags($_POST['message_text']);
	$author=$_POST['message_author'];
	$mail=$_POST['message_author_mail'];

	$answer=Common::strip_forum_tags($_POST['message_answer']);

	$db->query("UPDATE fw_guestbook SET author='$author',author_mail='$mail',message='$text',answer='$answer' WHERE id='$id'");

	if (isset($_POST['send_answer']) && $mail!='') {
		$smarty->assign("site_url",BASE_URL);
		$smarty->assign("message",$text);
		$smarty->assign("answer",$answer);

		$body=$smarty->fetch(BASE_PATH.'/modules/guestbook/answer_template.txt');

		Mail::send_mail($mail,ADMIN_MAIL,"Ответ на ваше сообщение",$body,'','html','standard','Windows-1251');
	}

	$smarty->assign("refresh_parent","true");

}

/*--------------------------------- ОТОБРАЖЕНИЕ ------------------------------*/

SWITCH (TRUE) {

  	CASE ($action=='add'):
    	$navigation[]=array("url" => BASE_URL."/admin/?mod=guestbook&action=add","title" => 'Добавить собщение');
    	$smarty->assign("mode","add");
    	$template='guestbook.a_edit.html';
  	BREAK;



	CASE ($action=='edit' && isset($_GET['id'])):

		Common::check_priv("$priv");

		$id=$_GET['id'];

		$message=$db->get_single("SELECT * FROM fw_guestbook WHERE id='$id' LIMIT 1");


		$message['message']=Common::add_forum_tags($message['message']);

		$message=String::unformat_array($message);

		$smarty->assign("message",$message);

		$template='guestbook.a_edit_message.html';
		$template_mode='single';

	BREAK;


  CASE ($action=='edit_msg' && isset($_GET['id'])):

    $id=$_GET['id'];
    $navigation[]=array("url" => BASE_URL."/admin/?mod=guestbook","title" => 'Редактировать сообщение');
    $guestbook=$db->get_single("SELECT * FROM fw_guestbook WHERE id='$id'");
    $guestbook=String::unformat_array($guestbook);
    $smarty->assign("guestbook",$guestbook);
    $smarty->assign("mode","edit");
    $template='guestbook.a_edit.html';

  BREAK;


	DEFAULT:

    if (isset($_GET['page'])) $page=$_GET['page'];
    else $page=1;

    $result=$db->query("SELECT COUNT(*) FROM fw_guestbook");
    $pager=Common::pager($result,GB_MESSAGES_PER_PAGE,$page);

    $smarty->assign("total_pages",$pager['total_pages']);
    $smarty->assign("current_page",$pager['current_page']);
    $smarty->assign("pages",$pager['pages']);

    $guestbook_list=$db->get_all("SELECT * FROM fw_guestbook ORDER BY insert_date DESC LIMIT ".$pager['limit']);
    $guestbook_list=String::unformat_array($guestbook_list);
    if (count($guestbook_list)>0) $smarty->assign("guestbook_list",$guestbook_list);

	BREAK;

}

?>