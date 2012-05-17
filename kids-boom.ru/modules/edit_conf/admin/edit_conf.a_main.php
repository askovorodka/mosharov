<?php

if (isset($_GET['action'])) $action=$_GET['action'];
else $action='';


if (isset($_POST['submit_add_mail_template'])){
	Common::check_priv("$priv");
	$name = $_POST['name'];
	$key = trim($_POST['key']);
	$template = $_POST['template'];
	
	$item = $db->get_single("SELECT mail_key FROM fw_mails_templates WHERE mail_key='$key'");
	if (strlen(trim($item['mail_key']))>0){
		die("Ошибка, такой ключ шаблона уже есть.");
	}
	else{
		$db->query("INSERT INTO fw_mails_templates (mail_key,name,template) VALUES ('$key','$name','$template')");
		header("Location: ?mod=edit_conf&action=mails");
	}
}

if (isset($_POST['submit_edit_mail_template'])){
	Common::check_priv("$priv");
	$name = $_POST['name'];
	$key = trim($_POST['key']);
	$template = $_POST['template'];
	
	$db->query("UPDATE fw_mails_templates SET name='$name',template='$template' WHERE mail_key='$key'");
	header("Location: ?mod=edit_conf&action=edit_mail_template&id=$key");
}


if (isset($_POST['submit_edit_conf'])) {

	Common::check_priv("$priv");

	foreach ($_POST as $k => $v) {
		$v=String::secure_format($v);
		$result=$db->query("UPDATE fw_conf SET conf_value='$v' WHERE conf_key='$k'");
	}
	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");

}

if (isset($_POST['submit_add_template'])) {

	Common::check_priv("$priv");

	$name=$_POST['template_name'];
	$file=$_POST['template_file'];

	$db->query("INSERT INTO fw_templates(name,file) VALUES('$name','$file')");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");

}

if (isset($_POST['submit_edit_templates'])) {

	$temlpate_name=$_POST['temlpate_name'];
	$temlpate_file=$_POST['temlpate_file'];

	for ($i=0;$i<count($temlpate_name);$i++) {
		$id=key($temlpate_name);
		$name=String::secure_format($temlpate_name[key($temlpate_name)]);
		$file=$temlpate_file[key($temlpate_name)];
		$db->query("UPDATE fw_templates SET name='$name',file='$file' WHERE id='$id'");
		next($temlpate_name);
	}
}

if ($action=='delete_mail_template') {

	Common::check_priv("$priv");

	$key=$_GET['id'];

	$db->query("DELETE FROM fw_mails_templates WHERE mail_key='$key'");

	header("Location: ?mod=edit_conf&action=mails");
}


if ($action=='delete_template') {

	Common::check_priv("$priv");

	$id=$_GET['id'];

	$db->query("DELETE FROM fw_templates WHERE id='$id'");

	header("Location: ?mod=edit_conf&action=templates");
}

SWITCH (TRUE) {

	CASE ($action=='mails'):
		$navigation[]=array("url" => BASE_URL."/admin/?mod=edit_conf&action=mails","title" => 'Доступные шаблоны писем');
		$mails_list=$db->get_all("SELECT * FROM fw_mails_templates");
		$smarty->assign("mails_list",$mails_list);
		$template='edit_conf.a_mails_templates.html';
	BREAK;
	
	CASE ($action=='templates'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=edit_conf&action=templates","title" => 'Доступные шаблоны');

		$templates_list=$db->get_all("SELECT * FROM fw_templates");

		$smarty->assign("templates_list",$templates_list);
		$template='edit_conf.a_templates.html';


	BREAK;


	CASE ($action=='edit_mail_template'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=edit_conf&action=mails","title" => 'Доступные шаблоны писем');
		$navigation[]=array("url" => BASE_URL."/admin/?mod=edit_conf&action=templates","title" => 'Редактировать шаблон');

		$temp=$db->get_single("SELECT * FROM fw_mails_templates where mail_key='".$_GET['id']."'");
		$temp = String::unformat_array($temp);
		$smarty->assign("name",$temp['name']);
		$smarty->assign("key",$temp['mail_key']);
		$smarty->assign("text",$temp['template']);
		$smarty->assign("mode","edit");
		$template='edit_conf.a_mails_templates.html';


	BREAK;

	CASE ($action=='backup'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=edit_conf&action=backup","title" => 'Резервное копирование');

		if ($_SESSION['fw_user']['priv']=='0') $smarty->assign("is_dev",true);

		define('PATH', BASE_PATH.'/backup/');
		define('URL',  BASE_URL.'/backup/');
		define('LIMIT', 1);
		define('SC', 1);
		define('GS', 1);

		define('DBNAMES', DB_NAME);

		define('C_DEFAULT', 1);
		define('C_RESULT', 2);
		define('C_ERROR', 3);

		if (isset($_POST['submit_backup'])) {

			Common::check_priv("$priv");

			require_once BASE_PATH.'/lib/class.db_backup.php';

			$dumper=new dumper();

			$dumper->backup($_POST['filter'],$_POST['pack'],$_POST['pack_rate']);

			$smarty->assign("file_name",$dumper->filename);
			$smarty->assign("tables_list",$dumper->tables_list);
			$smarty->assign("table_size",$dumper->table_size);
			$smarty->assign("file_size",$dumper->file_size);

			$smarty->assign("tables_count",$dumper->tables_count);
			$smarty->assign("rows_count",$dumper->rows_count);

			$smarty->assign("action","backup");
		}

		if (isset($_POST['submit_restore'])) {

			Common::check_priv("0");

			require_once BASE_PATH.'/lib/class.db_backup.php';

			$dumper=new dumper();

			if (isset($_POST['file']) && $_POST['file']!='') {
				$dumper->restore($_POST['file']);
			}

			$smarty->assign("file_date",$dumper->file_date);
			$smarty->assign("q_number",$dumper->q_number);
			$smarty->assign("t_number",$dumper->t_number);
			$smarty->assign("r_number",$dumper->r_number);

			$smarty->assign("action","restore");
		}


		if ($_SESSION['fw_user']['priv']=='0') {
			foreach (glob(BASE_PATH."/backup/".DB_NAME."_*.*") as $filename) {
			   	$filename=explode("/",$filename);
				$files_list[]=$filename[count($filename)-1];
			}

			if (isset($files_list)) $smarty->assign("files_list",$files_list);
		}

		$smarty->assign("db_name",DB_NAME);

		$template='edit_conf.a_backup.html';


	BREAK;

	DEFAULT:

		$navigation[]=array("url" => BASE_URL."/admin/?mod=edit_conf","title" => 'Редактировать настройки');

		$conf_list=$db->get_all("SELECT * FROM fw_conf where status = 1 ORDER BY section,name");
		$conf_list=String::unformat_array($conf_list);
    	$cur_list=$db->get_all("SELECT * FROM fw_currency WHERE status=1");
      	$cur_list=String::unformat_array($cur_list);

		$smarty->assign("conf_list",$conf_list);
		$smarty->assign("cur_list",$cur_list);
}

?>