<?php
ob_start("ob_gzhandler");
session_start();

error_reporting(E_ALL);


require_once '../conf/globals.php';
require_once '../lib/smarty/Smarty.class.php';
require_once '../lib/class.db.php';
require_once '../lib/class.common.php';
require_once '../lib/class.string.php';

$_SESSION['db_connections'] = 0;

/* ------------ ЗАГРУЗКА ШАБЛОНИЗАТОРА --------------------*/
$smarty = new Smarty;

$smarty->template_dir = 'templates/';
$smarty->compile_dir = '../lib/smarty/admin_templates_c/';
$smarty->cache_dir = '../lib/smarty/admin_cache/';

/* ------------ ПОДКЛЮЧАЕМСЯ К БАЗЕ ДАННЫХ -------------- */
$db=new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

//$smarty->debugging=true;

Common::load_config('admin');


if (isset($_GET['action']) && $_GET['action']=='logout') {

		setcookie('fw_login_cookie',"",time()-5555,'/','');
		session_destroy();
		header ("Location: ".BASE_URL."/admin/login.php");
		die();

}


if (isset($_POST['submit_login_form'])) {

	$check = true;
	$login = String::secure_format($_POST['login']);
	$password = String::secure_format($_POST['password']);
	
	if ($login < '1') {
		$smarty->assign("login_message",'Введите пожалуйста ваш логин');
		$check=false;
	}

	if ($password < '1') {
		$smarty->assign("login_message",'Введите пожалуйста ваш пароль');
		$smarty->assign("temp_login",$login);
		$check=false;
	}

	if ($check==true) {

		$content=$db->get_single("
			SELECT 
				fu.*,
				fg.priv,
				fg.name as priv_name
			FROM fw_users as fu, fw_users_groups as fg
			WHERE 
				fg.id=fu.group_id
				AND
				fu.login='$login' 
				AND 
				fu.status='1' 
		");
		if (!isset($content['priv'])) $content['priv']=9;
		if (!isset($content['priv_name'])) $content['priv_name']="Пользователь";

		$password_to_check = @$content['password'];
		if (empty($password_to_check) || $content['priv']>=9) {
			$smarty->assign("login_message",'Такого пользователя не существует');
		}
		else {

			if (md5($password) != $password_to_check) {
				$smarty->assign("login_message",'Неправильный пароль');
				$smarty->assign("temp_login",$login);
			}
			else {
				setcookie('fw_login_cookie',$login."|".md5($password),time()+LOGIN_LIFETIME,'/','');
				$_SESSION['fw_user'] = $content;
				header ("Location: ".BASE_URL."/admin/index.php");
			}
		}
	}

}


$smarty->display("login.html");
?>