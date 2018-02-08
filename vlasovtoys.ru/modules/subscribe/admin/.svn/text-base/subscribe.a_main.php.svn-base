<?php

require_once BASE_PATH.'/lib/class.mail.php';

$navigation[]=array("url" => BASE_URL."/admin/?mod=subscribe","title" => 'Почтовая рассылка');

if (isset($_GET['action'])) $action=$_GET['action'];
else $action='';

if (isset($_POST['submit_new_group'])) {
	
	$name=$_POST['new_group'];
	
	$db->query("INSERT INTO fw_subscribe_groups(name) VALUES('$name')");
	
	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if (isset($_POST['submit_save_groups'])) {
	
	if (isset($_POST['edit_group'])) {
		$names=$_POST['edit_group'];
		
		foreach ($names as $k=>$v) {
			$db->query("UPDATE fw_subscribe_groups SET name='$v' WHERE id='$k'");
		}
	}
	
	if (isset($_POST['delete_group'])) {
		
		$ids='';
		$delete_group=$_POST['delete_group'];
		foreach ($delete_group as $k=>$v) {
			$ids.=$k.',';
		}
		$ids=substr($ids,0,-1);
		
		$db->query("DELETE FROM fw_subscribe_groups WHERE id IN ($ids)");
		
	}
	
	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if (isset($_POST['submit_add_template'])) {
	
	$name=String::secure_format($_POST['template_name']);
	$template=String::secure_format($_POST['template_text']);
	
	$db->query("INSERT INTO fw_subscribe_templates(name,template) VALUES('$name','$template')");
	
	$location="index.php?mod=subscribe&action=templates";
	header("Location: $location");
}


if (isset($_POST['submit_edit_template'])) {
	
	$id=$_POST['id'];
	
	$name=String::secure_format($_POST['template_name']);
	$template=String::secure_format($_POST['template_text']);
	
	$db->query("UPDATE fw_subscribe_templates SET name='$name',template='$template' WHERE id='$id'");
	
	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if (isset($_POST['submit_new_user'])) {
	
	$mail=$_POST['new_user'];

	$db->query("REPLACE INTO fw_subscribe_list(mail,status) VALUES('$mail','1')");
	
	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if (isset($_POST['submit_save_users'])) {
	
	if (isset($_POST['edit_user'])) {
		$mails=$_POST['edit_user'];
		$group=$_POST['edit_group'];
		
		foreach ($mails as $k=>$v) {
			$db->query("UPDATE fw_subscribe_list SET mail='$v',group_id='".$group[$k]."' WHERE id='$k'");
		}
	}
	
	if (isset($_POST['delete_user'])) {
		
		$ids='';
		$delete_user=$_POST['delete_user'];
		foreach ($delete_user as $k=>$v) {
			$ids.=$k.',';
		}
		$ids=substr($ids,0,-1);
		
		$db->query("DELETE FROM fw_subscribe_list WHERE id IN ($ids)");
		
	}
	
	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if (isset($_POST['submit_send'])) {

	$text=$_POST['mail_text'];
	$subj=$_POST['mail_subj'];
	$type=$_POST['send_type'];

	$group_id=$_POST['send_to'];
	$template_id=$_POST['mail_template'];

	if ($group_id=='0') {
		$users_list=$db->get_all("SELECT mail FROM fw_subscribe_list WHERE status='1'");
	}
	else {
		$users_list=$db->get_all("SELECT mail FROM fw_subscribe_list WHERE status='1' AND group_id='$group_id'");
	}

	$mail_template=$db->get_single("SELECT template FROM fw_subscribe_templates WHERE id='$template_id'");

	$smarty->assign("text",$text);
	$smarty->assign("mail_content",$mail_template['template']);
	$body=$smarty->fetch(BASE_PATH.'/modules/subscribe/template.txt');

	foreach ($users_list as $k=>$v) { 
		Mail::send_mail($v['mail'],ADMIN_MAIL,$subj,$body,'',$type,SUBSCRIBE_TRANSPORT_METHOD,SUBSCRIBE_ENCODING);
	}
}

if ($action=="change_user_status" && isset($_GET['id'])) {
	$id=intval($_GET['id']);
	$db->query("UPDATE fw_subscribe_list SET status=IF(status='0','1','0') WHERE id='".$id."'");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
}

if ($action=='delete_inactive_users') {

	$limit_date=time()-604800;

	$db->query("DELETE FROM fw_subscribe_list WHERE reg_date<$limit_date AND status='0'");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}


SWITCH (TRUE) {

	CASE ($action=='groups'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=subscribe&action=groups","title" => 'Группы подписчиков');

		$smarty->assign("groups_list",$db->get_all("SELECT * FROM fw_subscribe_groups"));

		$template='subscribe.a_groups.html';

	BREAK;
	
	CASE($action=='viewUsersMial'):
		$items = array();
		$items = $db->get_all("SELECT id,mail FROM fw_subscribe_list ORDER BY mail");
		$items=String::unformat_array($items);
		$smarty->assign("users_list",$items);
		$template = 'subscribe.a_user_mail.html';
		$template_mode='single';
	BREAK;
	
	CASE ($action=='templates'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=subscribe&action=templates","title" => 'Шаблоны писем');

		$smarty->assign("templates_list",$db->get_all("SELECT id,name FROM fw_subscribe_templates"));

		$template='subscribe.a_templates.html';

	BREAK;

	CASE ($action=='add_template'):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=subscribe&action=templates","title" => 'Шаблоны писем');
		$navigation[]=array("url" => BASE_URL."/admin/?mod=subscribe&action=add_template","title" => 'Добавить шаблон');
		
		$smarty->assign("mode","add");

		$template='subscribe.a_edit_template.html';
	
	BREAK;
	
	CASE ($action=='edit_template'):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=subscribe&action=templates","title" => 'Шаблоны писем');
		$navigation[]=array("url" => BASE_URL."/admin/?mod=subscribe&action=edit_template","title" => 'Редактировать шаблон');
		
		$id=$_GET['id'];
		
		$t=$db->get_single("SELECT * FROM fw_subscribe_templates WHERE id='$id'");
		
		$smarty->assign("t",String::unformat_array($t));
		
		$smarty->assign("mode","edit");

		$template='subscribe.a_edit_template.html';
	
	BREAK;
	
	CASE ($action=='users'):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=subscribe&action=users","title" => 'Подписчики');
		
		if (isset($_GET['page'])) $page=$_GET['page'];
		else $page=1;
	
		$result=$db->query("SELECT COUNT(*) FROM fw_subscribe_list");
		$pager=Common::pager($result,50,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		
		$smarty->assign("users_list",$db->get_all("SELECT id,mail,status,
																(SELECT name FROM fw_subscribe_groups WHERE id=u.group_id LIMIT 1) AS group_name,
																(SELECT id FROM fw_subscribe_groups WHERE id=u.group_id LIMIT 1) AS group_id 
																FROM fw_subscribe_list u ORDER BY id DESC LIMIT ".$pager['limit']));
		
		$smarty->assign("groups_list",$db->get_all("SELECT * FROM fw_subscribe_groups"));

		$template='subscribe.a_users.html';
	
	BREAK;
	
	DEFAULT:
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=subscribe","title" => 'Отправить письмо');
		
		
		$smarty->assign("groups_list",$db->get_all("SELECT * FROM fw_subscribe_groups"));
		$smarty->assign("templates_list",$db->get_all("SELECT * FROM fw_subscribe_templates"));
		
		$template='subscribe.a_send.html';
}

?>