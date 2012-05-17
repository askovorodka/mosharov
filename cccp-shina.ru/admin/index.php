<?php
ob_start("ob_gzhandler");
session_start();

/*session_start();
error_reporting(E_ALL);
ini_set('display_errors','On');*/

setlocale (LC_ALL, array ('ru_RU.CP1251', 'rus_RUS.1251'));

require_once '../conf/globals.php';
require_once '../lib/smarty/Smarty.class.php';
require_once '../lib/class.db.php';
require_once '../lib/class.common.php';
require_once '../lib/class.string.php';
require_once '../lib/class.rss.php';
require_once '../lib/class.array.php';
require_once '../lib/class.users.php';


$_SESSION['db_connections'] = 0;

/* ------------ гюцпсгйю ьюакнмхгюрнпю --------------------*/
$smarty = new Smarty;

$smarty->template_dir = 'templates/';
$smarty->compile_dir = '../lib/smarty/admin_templates_c/';
$smarty->cache_dir = '../lib/smarty/admin_cache/';

/* ------------ ондйкчвюеляъ й аюге дюммшу -------------- */
$db=new db();
$users = new Users();

//$smarty->debugging=true;

Common::load_config('admin');

$check_auth=Common::check_auth();
if ($check_auth=='0' && @$_GET['action']!='edit_post') {
  header ("Location: ".BASE_URL."/admin/login.php");
  die();
}

$modules_list=$db->get_all("SELECT * FROM fw_modules WHERE priv>='".$_SESSION['fw_user']['priv']."' AND status='1'");


$navigation[]=array("url" => BASE_URL."/admin/","title" => 'цКЮБМЮЪ');

/* --опнбепъел апюсгеп йкхемрю х цпсгхл мсфмши педюйрнп --*/

if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE")) {
  $smarty->assign("editor_mode","editor.js");
  $smarty->assign("browser","ie");
}
else {
  $smarty->assign("editor_mode","moz/editor.js");
  $smarty->assign("browser","moz");
}

if (get_magic_quotes_gpc()) {
  $_GET=String::strips($_GET);
  $_POST=String::strips($_POST);
  $_COOKIE=String::strips($_COOKIE);
  $_REQUEST=String::strips($_REQUEST);
  if (isset($_SERVER['PHP_AUTH_USER'])) $_SERVER['PHP_AUTH_USER']=String::strips($_SERVER['PHP_AUTH_USER']);
  if (isset($_SERVER['PHP_AUTH_PW'])) $_SERVER['PHP_AUTH_PW']=String::strips($_SERVER['PHP_AUTH_PW']);
}


/* --------------ондйкчвюел мсфмши лндскэ ----------------*/
if (isset($_GET['mod'])) {

  $smarty->assign("current_module",$_GET['mod']);

  for ($m=0;$m<count($modules_list);$m++) {

    if ($_GET['mod']==$modules_list[$m]['name']){

      $priv=$modules_list[$m]['priv'];

      $module_url='../modules/'.$modules_list[$m]['name'];
      $module_path=BASE_PATH.'/modules/'.$modules_list[$m]['name'];

      require_once '../modules/'.$modules_list[$m]['name'].'/admin/'.$modules_list[$m]['name'].'.a_main.php';
	
      if (!isset($template)) $template=BASE_PATH.'/modules/'.$modules_list[$m]['name']."/admin/templates/".$modules_list[$m]['name'].".a_main.html";
      else $template=BASE_PATH.'/modules/'.$modules_list[$m]['name']."/admin/templates/".$template;

      $smarty->assign("template",$template);

    }
  }
}
else {

  require_once 'main.php';
  $smarty->assign("template","main.html");
}
/* --------- цемепхпсел цкюбмне лемч юдлхмйх -------------*/
$main_menu = '';
for ($m=0;$m<count($modules_list);$m++) {
  $menu_file='../modules/'.$modules_list[$m]['name'].'/admin/menu.php';
  if (file_exists($menu_file)) require_once "$menu_file";
}

function cmp ($a,$b) {
  return ($a['sort'] > $b['sort']) ? 1 : -1;
  }
  usort($main_menu,"cmp");

/* ----------------------мюбхцюжхъ -----------------------*/

$smarty->assign("navigation",$navigation);

/*-----------------------RSS онрнй---------------------- */

/*if (RSS_SHOW == 'true') {

  $rss = new lastRSS;

  $rss->cache_dir = $smarty->cache_dir;
  $rss->cache_time = 3600; // one hour

  if ($rs = $rss->get(RSS_URL."?domain=".$_SERVER['HTTP_HOST'])) {
    $item = MyArray::random_from_array($rs['items']);
    $item['description'] = html_entity_decode($item['description']);
    $smarty->assign("rss_news",$item);
  }
}*/

/*--------- оепедю╗л ялюпрх пюгкхвмше оепелеммше ---------*/

$smarty->assign("main_menu",$main_menu);
$smarty->assign("base_url",BASE_URL);
$smarty->assign("base_path",BASE_PATH);
$smarty->assign("editor_style",EDITOR_MODE);
$smarty->assign("user_login",$_SESSION['fw_user']['login']);
$smarty->assign("user_priv",$_SESSION['fw_user']['name']);

if (isset($template_mode) && $template_mode=='single') $smarty->display($template);
else $smarty->display("index.html");
?>