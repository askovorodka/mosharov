<?php

$navigation[]=array("url" => BASE_URL."/admin/?mod=users","title" => 'Пользователи');

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

/*------------------------- ВЫПОЛНЯЕМ РАЗЛИЧНЫЕ ДЕЙСТВИЯ ---------------------*/
if (isset($_POST['submit_add_group'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$name=String::secure_format($_POST['edit_group_name']);
	$priv=intval($_POST['edit_group_priv']);

	$res=$db->get_all("SELECT id FROM fw_users_groups WHERE priv='".$priv."'");

	if (count($res)==0) $db->query("INSERT INTO fw_users_groups (name,priv) VALUES('$name','$priv')");

	header ("Location: ?mod=users&action=groups");

}

if (isset($_POST['submit_edit_group'])) {
	
	Common::check_priv("$priv");
	
	$id=intval($_POST['id']);
	$check=true;
	
	$name=String::secure_format($_POST['edit_group_name']);
	$priv=intval($_POST['edit_group_priv']);

	$db->query("UPDATE fw_users_groups SET name='$name', priv='$priv' WHERE id='".$id."'");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();

}

if ($action=="change_user_status" && isset($_GET['id'])) {
  $id=intval($_GET['id']);
  $db->query("UPDATE fw_users SET status=IF(status='0','1','0') WHERE id='".$id."'");

  $location=$_SERVER['HTTP_REFERER'];
  header ("Location: $location");
  die();
}

if (isset($_POST['submit_add_user'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$name=String::secure_format($_POST['edit_user_name']);
	$login=String::secure_format($_POST['edit_user_login']);
	$mail=String::secure_format($_POST['edit_user_mail']);
	$tel=String::secure_format($_POST['edit_user_tel']);
	$deliver=String::secure_format($_POST['edit_user_deliver']);
	$priv=$_POST['edit_user_priv'];
	$status=String::secure_format($_POST['edit_user_status']);
	
	$password=md5($_POST['edit_user_password']);
	
	$check_if_exists=$db->get_all("SELECT id FROM fw_users WHERE login='$login'");
	if (count($check_if_exists)>0) {
		$check=false;
		$smarty->assign("error_message",'Пользователь с таким логином уже существует');
	}
	
	if ($check) {
		$db->query("INSERT INTO fw_users(login,password,name,mail,tel,deliver,group_id,status,reg_date) VALUES('$login','$password','$name','$mail','$tel','$deliver','$priv','$status','".time()."')");
		header("Location: ?mod=users");
	}
}

if (isset($_POST['submit_edit_user'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$id=$_POST['id'];
	
	$name=String::secure_format($_POST['edit_user_name']);
	$login=String::secure_format($_POST['edit_user_login']);
	$mail=String::secure_format($_POST['edit_user_mail']);
	$tel=String::secure_format($_POST['edit_user_tel']);
	$deliver=String::secure_format($_POST['edit_user_deliver']);
	$priv=$_POST['edit_user_priv'];
	$status=String::secure_format($_POST['edit_user_status']);
	
	if ($_POST['edit_user_password']=='') $password=$_POST['old_password'];
	else $password=md5($_POST['edit_user_password']);
	
	if ($login!=$_POST['old_login']) {
		$check_if_exists=$db->get_all("SELECT id FROM fw_users WHERE login='$login'");
		if (count($check_if_exists)>0) {
			$check=false;
			$smarty->assign("error_message",'Пользователь с таким логином уже существует');
		}
	}
	
	if ($check) {
		$db->query("UPDATE fw_users SET login='$login',password='$password',name='$name',mail='$mail',tel='$tel',deliver='$deliver',group_id='$priv',status='$status' WHERE id='$id'");
	}
}

if ($action=='delete_user' && isset($_GET['id'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	$id=$_GET['id'];
	
	if ($id==$_SESSION['fw_user']['id']) {
		$check=false;
		$smarty->assign("error_message",'Вы не можете удалить сами себя!');
	}
	
	if ($check) {
		$db->query("DELETE FROM fw_users WHERE id='$id'");
	}
}

if ($action=='delete_group' && isset($_GET['id'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	$id=$_GET['id'];
	
	if ($id==$_SESSION['fw_user']['group_id']) {
		$check=false;
//		$smarty->assign("error_message",'Вы не можете удалить свою группу!');
	}
	
	if ($check) {
		$db->query("DELETE FROM fw_users_groups WHERE id='$id'");

//		$location=$_SERVER['HTTP_REFERER'];
	}

	header ("Location: ?mod=users&action=groups");
	die();

}
/*--------------------------------- ОТОБРАЖЕНИЕ ------------------------------*/

SWITCH (TRUE) {
	
	CASE ($action=='add_user'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=users&action=add_users","title" => 'Добавить пользователя');
		
/*
		for ($i=0;$i<count($priv_value);$i++) {
			if ($priv_value[$i]>=$_SESSION['fw_user']['priv']) {
				$priv_list[$i]['value']=$priv_value[$i];
				$priv_list[$i]['name']=$priv_name[$i];
			}
		}
*/
		$priv_list=$db->get_all("SELECT *, priv as value FROM fw_users_groups");
		$smarty->assign("priv_list",$priv_list);
		$smarty->assign("mode","add");
		$template='users.a_edit.html';

	BREAK;
	
	CASE ($action=='add_group'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=users&action=add_users","title" => 'Добавить группу');
		
/*
		for ($i=0;$i<count($priv_value);$i++) {
			if ($priv_value[$i]>=$_SESSION['fw_user']['priv']) {
				$priv_list[$i]['value']=$priv_value[$i];
				$priv_list[$i]['name']=$priv_name[$i];
			}
		}
*/
		$priv_list=$db->get_all("SELECT * FROM fw_users_groups");
		$smarty->assign("priv_list",$priv_list);
		$smarty->assign("mode","add");
		$template='users.a_edit_group.html';

	BREAK;
	
	CASE ($action=='edit_user'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=users&action=edit_users","title" => 'Редактировать пользователя');

		if (isset($_GET['id'])) $id = $_GET['id'];
		
		$user=$db->get_single("SELECT *, (SELECT name FROM fw_users_groups WHERE id=fw_users.group_id) as priv_name FROM fw_users WHERE id='$id'");
		$user=String::unformat_array($user);

		$priv_list=$db->get_all("SELECT *, priv as value FROM fw_users_groups");

//		$user['priv_name']=str_replace($priv_value,$priv_name,$user['priv']);
/*
		for ($i=0;$i<count($priv_value);$i++) {
			if ($priv_value[$i]>=$_SESSION['fw_user']['priv']) {
				$priv_list[$i]['value']=$priv_value[$i];
				$priv_list[$i]['name']=$priv_name[$i];
			}
		}
*/		
		$smarty->assign("user",$user);
		$smarty->assign("id",$id);
		$smarty->assign("priv_list",$priv_list);
		$smarty->assign("mode","edit");
		$template='users.a_edit.html';

	BREAK;
	
	CASE ($action=='edit_group'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=users&action=edit_users","title" => 'Редактировать группу');

		if (isset($_GET['id'])) $id = $_GET['id'];
		
		$group=$db->get_single("SELECT * FROM fw_users_groups WHERE id='$id'");
		$group=String::unformat_array($group);

		$priv_list=$db->get_all("SELECT *, priv as value FROM fw_users_groups");

//		$user['priv_name']=str_replace($priv_value,$priv_name,$user['priv']);
/*
		for ($i=0;$i<count($priv_value);$i++) {
			if ($priv_value[$i]>=$_SESSION['fw_user']['priv']) {
				$priv_list[$i]['value']=$priv_value[$i];
				$priv_list[$i]['name']=$priv_name[$i];
			}
		}
*/		
		$smarty->assign("group",$group);
		$smarty->assign("id",$id);
		$smarty->assign("priv_list",$priv_list);
		$smarty->assign("mode","edit");
		$template='users.a_edit_group.html';

	BREAK;
	
	CASE ($action=='groups'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=users&action=groups","title" => 'Группы пользователей');
		
		$priv_list=$db->get_all("SELECT *, priv as value, (SELECT COUNT(id) FROM fw_users WHERE group_id=fw_users_groups.id) as users FROM fw_users_groups ORDER BY priv");
		$smarty->assign("priv_list",$priv_list);
		$template='users.a_main_groups.html';

	BREAK;

	DEFAULT:

		if (isset($_GET['page'])) $page=$_GET['page'];
		else $page=1;

		if (isset($_GET['groups'])  &&  intval($_GET['groups'])>0) $cond="  WHERE group_id='".intval($_GET['groups'])."'  ";
		else $cond="";
		
		if (isset($_GET['char']) && strlen(trim($_GET['char']))>0){
			if ($cond=="") 
				$cond2 = " WHERE UPPER(name) LIKE '".$_GET['char']."%' ";
			else
				$cond2 = " AND UPPER(name) LIKE '".$_GET['char']."%' ";
		}
		else
			$cond2="";
	
		$result=$db->query("SELECT COUNT(*) FROM fw_users $cond $cond2 ");
		$pager=Common::pager($result,USERS_PER_PAGE,$page);
		
		$groups=$db->get_all("SELECT * FROM fw_users_groups");

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		$smarty->assign("groups",$groups);
		
		$users=$db->get_all("SELECT *, (SELECT name FROM fw_users_groups WHERE id=fw_users.group_id) as priv FROM fw_users $cond $cond2 ORDER BY priv,reg_date DESC LIMIT ".$pager['limit']);
		$users=String::unformat_array($users);
		
		$char_list = $db->get_all("SELECT UPPER(MID(name,1,1)) as STR, ASCII(UPPER(MID(name,1,1))) as STR_CODE FROM fw_users GROUP BY STR");
		$char_list=String::unformat_array($char_list);
		
		$smarty->assign("users_list",$users);
		$smarty->assign("char_list",$char_list);

}

?>