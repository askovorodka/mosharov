<?php
ob_start();

/*
header("Content-Type: text/html; charset=windows-1251");
print_r($_SERVER['DOCUMENT_ROOT']);
echo "<br>";
print_r("http://www.".$_SERVER['HTTP_HOST']);
foreach ($_SERVER as $key=>$val)
  echo $key."=".$val."<br>";
exit;
*/

/* ---------------------- HEADERS ----------------------- */

setlocale (LC_ALL, array ('ru_RU.CP1251', 'rus_RUS.1251'));

session_start();
error_reporting(E_ALL);

function gettime() {
  list($t_usec, $t_sec) = explode(" ",microtime());
  return ((float)$t_usec + (float)$t_sec);
}
$t_starttime= gettime ();


require_once 'conf/globals.php';
require_once 'lib/smarty/Smarty.class.php';
require_once 'lib/class.db.php';
require_once 'lib/class.common.php';
require_once 'lib/class.string.php';
require_once 'lib/class.array.php';
require_once 'lib/captchaZDR.php';
require_once 'lib/class.session.php';
require_once 'modules/shop/front/class.shop.php';

$_SESSION['db_connections'] = 0;

/* ------------ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ -------------------*/
$smarty = new Smarty;

$smarty->template_dir = 'templates/';
$smarty->compile_dir = 'lib/smarty/templates_c/';
$smarty->cache_dir = 'lib/smarty/cache/';

/* ------------ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅ пїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ -------------- */
$db=new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

//пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ
$shop = new Shop($db);

define ('CAPTCHA_SALT', 'kjhfgkjhfsdkjghskjd hkjfdnkmbn ,msdnbskjh'); 


/* -------- пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅ пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅ ---------- */

Common::load_config('front');

$default_modules=$db->get_all("SELECT * FROM fw_modules WHERE default_load='1' AND status='1'");

$url=Common::get_url($_SERVER['REQUEST_URI'],SCRIPT_FOLDER);

$navigation=array();
$navigation[]=array("url" => BASE_URL,"title" => 'Главная страница');
$page_found=false;
$set_pages_url=false;
$module_found=false;
$module_name='';
$template='';
$main_module='off';
$node_content=array();
$modules_to_load=array();
$module_added=false;
$deny_access=false;
$switch_off_smarty=false;

$css[] = BASE_URL."/templates/style.css";
$css[] = BASE_URL."/javascript/colorbox/example1/colorbox.css";
//$css[]=BASE_URL."/templates/jquery.lightbox-0.5.css";
$js[]=BASE_URL."/javascript/jquery-1.5.min.js";
$js[]=BASE_URL."/javascript/colorbox/colorbox/jquery.colorbox.js";
$js[]=BASE_URL."/javascript/jquery.validate.min.js";
//$js[]=BASE_URL."/javascript/jquery.center.js";
$js[]=BASE_URL."/javascript/tools.js";
//$js[]=BASE_URL."/javascript/tools.js";

/* ------------- пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ -------------- */
if (SMARTY_DEBUGGING_SITE=='true') $smarty->debugging = true;
else $smarty->debugging = false;

/* --------------пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ ---------------*/
if(strpos(@$_SERVER["HTTP_USER_AGENT"],"MSIE"))
  $smarty->assign("browser","ie");
else
  $smarty->assign("browser","moz");

/* -------------- пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ ---------------*/

if (get_magic_quotes_gpc()) {
  $_GET=String::strips($_GET);
  $_POST=String::strips($_POST);
  $_COOKIE=String::strips($_COOKIE);
  $_REQUEST=String::strips($_REQUEST);
  if (isset($_SERVER['PHP_AUTH_USER'])) $_SERVER['PHP_AUTH_USER']=String::strips($_SERVER['PHP_AUTH_USER']);
  if (isset($_SERVER['PHP_AUTH_PW'])) $_SERVER['PHP_AUTH_PW']=String::strips($_SERVER['PHP_AUTH_PW']);
}

/* ----------------- пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ ------------------ */

$n=count($url)-1;

if ($url[$n]=="") {
  $module_url= DEFAULT_URL;
  $url[0]= DEFAULT_URL;
}
else $module_url=$url[0];

//else $module_url=$url[$n];

$node=$db->get_single("
    SELECT
      id,param_left ,param_right,param_level,url,text,title,image,meta_keywords,meta_description,module,support_modules,
  elements,template,status,access_users,access_groups,in_menu,show_nodes,show_documents,show_documents_number,show_documents_orderby,
  documents_template,name as name,
      (SELECT GROUP_CONCAT(id SEPARATOR ',') FROM fw_users WHERE FIND_IN_SET(group_id, fw_tree.access_groups)>0) as access_users_groups,
      (SELECT IF(ISNULL(access_users_groups), access_users, CONCAT(access_users,',',access_users_groups))) as access_users_list
    FROM fw_tree
    WHERE url='$module_url' AND `status`='1'
  ");

if ($node['id']!='') {
  $module_name=$node['module'];
  $node_content=$node;
  $module_found=true;
}

$current_url_pages=$url;
$current_url=implode("/",$url);
$smarty->assign("current_url",$current_url);

//пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅ пїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ
//$news=$db->get_all("SELECT * FROM fw_news WHERE status='1' ORDER BY publish_date DESC " . $limit);
//$smarty->assign("news_list",$news);

//$smarty->assign('top_product', $shop->getTopProducts(1));

//пїЅпїЅпїЅпїЅпїЅпїЅ
//$session =  new Session($db);
//$session->setSession();
//$smarty->assign('online_users', $session->getOnLine() );

$smarty->assign("base_url",BASE_URL);
$smarty->assign("base_path",BASE_PATH);
$smarty->assign("catalog_image",BASE_URL . '/uploaded_files/shop_images/');
$smarty->assign("module_url",$module_url);
$smarty->assign("default_url",DEFAULT_URL);

$smarty->assign("node_content",$node_content);
$smarty->assign("template_image",'http://'.$_SERVER['HTTP_HOST'].'/templates/img/');


if (!empty($_SESSION['fw_user'])) $smarty->assign('user_info',$_SESSION['fw_user']);


/*--- пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ ----*/
$capt = new captchaZDR;
$capt->base_path = BASE_PATH;

  /* ------- пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ-------- */

  for ($i=0;$i<count($default_modules);$i++) {
    $new_module=array("switch_default"=>'on',"name"=>$default_modules[$i]['name'],"file"=>'modules/'.$default_modules[$i]['name'].'/front/'.$default_modules[$i]['name'].'.f_main.php');
    $modules_to_load[]=$new_module;
  }

  if ($module_found) {

    if (Common::check_node_auth($node_content['access_users_list'])) {

      if ($node_content['support_modules']!='') {
        $support_modules=explode(",",$node_content['support_modules']);
        for ($s=0;$s<count($support_modules);$s++) {

          $su=$db->get_single("SELECT url FROM fw_tree WHERE module='".$support_modules[$s]."'");

          $new_module=array("switch_support"=>'on',"name"=>$support_modules[$s],"support_url"=>$su['url'],"file"=>'modules/'.$support_modules[$s].'/front/'.$support_modules[$s].'.f_main.php');

          for ($m=0;$m<sizeof($modules_to_load);$m++) {
            if ($modules_to_load[$m]['file']==$new_module['file']) {
              $modules_to_load[$m]=$modules_to_load[$m]+$new_module;
              $module_added=true;
            }
          }
          if (!$module_added) $modules_to_load[]=$new_module;
          else $module_added=false;
        }
      }

      $templates_path=BASE_PATH.'/modules/'.$module_name.'/front/templates';
      $templates_url=BASE_URL.'/modules/'.$module_name.'/front/templates';
      $smarty->assign("templates_url",$templates_url);

      $new_module=array("main_module"=>'on',"name"=>$module_name,"file"=>'modules/'.$module_name.'/front/'.$module_name.'.f_main.php');
      for ($m=0;$m<sizeof($modules_to_load);$m++) {
        if ($modules_to_load[$m]['file']==$new_module['file']) {
          $modules_to_load[$m]=$modules_to_load[$m]+$new_module;
          $module_added=true;
        }
      }
      if (!$module_added) $modules_to_load[]=$new_module;
      else $module_added=false;

    }
    else {
      $page_found=true;
      $deny_access=true;
    }

  }

  /* -------------- пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ-------------- */

  foreach ($modules_to_load as $k=>$v) {
    $switch_default = isset($v['switch_default']) ? $v['switch_default'] : 'off' ;
    $switch_support = isset($v['switch_support']) ? $v['switch_support'] : 'off' ;
    $support_url = isset($v['support_url']) ? $v['support_url'] : '' ;
    $main_module = isset($v['main_module']) ? $v['main_module'] : 'off' ;

    require_once ($v['file']);

    if ($switch_support=='on' or $switch_default=='on') {
      $support_template=$smarty->fetch(BASE_PATH.'/modules/'.$v['name'].'/front/templates/'.$v['name'].'_support.html');
      $smarty->assign($v['name'],$support_template);
    }

  }

/* -------------- пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅ -------------- */
$main_menu=$db->get_all("SELECT id,name,url,param_level,param_left,param_right FROM fw_tree WHERE param_level IN ('1') AND in_menu='1' and status='1' ORDER BY param_left");
$main_menu=String::unformat_array($main_menu,'front');
foreach ($main_menu as $key=>$val)
{
	$submenu = $db->get_all("SELECT id,name,url,param_level FROM fw_tree WHERE param_left BETWEEN '{$val['param_left']}' AND '{$val['param_right']}' AND param_level = '" . ($val['param_level'] + 1) . "' AND in_menu = '1' ORDER BY param_left");
	if (isset($submenu) && count($submenu) > 0)
	{
		$main_menu[$key]['submenu'] = $submenu;
	}
}
$smarty->assign("main_menu",$main_menu);


$shop_menu=$db->get_all("
	SELECT * 
	FROM fw_catalogue as a
	WHERE a.param_level = '1' AND a.status='1' 
	ORDER BY a.param_left");

if ($shop_menu)
{
	foreach ($shop_menu as $key=>$val)
	{
		$shop_menu[$key]['full_url'] = $shop->getFullUrlCategory($val['id'], "catalog");
		$shop_menu[$key]['children'] = $shop->getChildrenCategor($val, 2);
		if ($shop_menu[$key]['children'])
		{
			foreach ($shop_menu[$key]['children'] as $key2=>$val2)
			{
				$shop_menu[$key]['children'][$key2]['full_url'] = $shop->getFullUrlCategory($val2['id'], "catalog");
			}
			$shop_menu[$key]['full_url'] = $shop_menu[$key]['children'][0]['full_url'];
		}
	}
}

$smarty->assign("shop_menu",$shop_menu);


if (!isset($page_title)) {
  if (isset($node_content['title']) && $node_content['title']!='') $page_title=$node_content['title'];
  else $page_title=isset($node_content['name']) ? $node_content['name'] : '';
}

if (!isset($meta_description)) {
  $meta_description=isset($node_content['meta_description']) ? $node_content['meta_description'] : '';
}

if (!isset($meta_keywords)) {
  $meta_keywords=isset($node_content['meta_keywords']) ? $node_content['meta_keywords'] : '';
}

$smarty->assign("page_title",@$page_title);
$smarty->assign("meta_keywords",@$meta_keywords);
$smarty->assign("meta_description",@$meta_description);

if (!empty($page_content['id'])){
  $files_list = $db->get_all("SELECT id,ext,title FROM fw_tree_files WHERE parent='".$page_content['id']."'");
  $smarty->assign("files_list",$files_list);
}

/*-------------------пїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ-------------------- */
$t_endtime= gettime ();
$t_result=$t_endtime-$t_starttime;
$pgt=substr($t_result,0,5);

/*----------пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅ пїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ--------- */

if ($deny_access) {
  $template=BASE_PATH.'/templates/access_denided.html';
}
elseif ($page_found) {
  $template=BASE_PATH.'/modules/'.$module_name.'/front/templates/'.$template;
}
else {
  //$template=BASE_PATH.'/templates/404.html';
  $main_template=BASE_PATH . '/templates/404.html';
  //$navigation[]=array("url"=>"/","title"=>"пїЅпїЅпїЅпїЅпїЅпїЅ 404. пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅ");

}

$temp='';

for ($i=0;$i<count($navigation);$i++)
{
  $_SESSION['nav'][$i] = $navigation[$i]['title'];
  $temp.=$navigation[$i]['url']."/";
  $navigation[$i]['url']=$temp;
}



$navigation=String::unformat_array($navigation,'front');
$smarty->assign("navigation",$navigation);
$smarty->assign("base_url",BASE_URL);

$smarty->assign("template",$template);

if (isset($css)) $smarty->assign("css",$css);
if (isset($js)) $smarty->assign("js",$js);

$smarty->assign("db_connections",$_SESSION['db_connections']);
$smarty->assign("pgt",$pgt);

if (isset($page) or $set_pages_url) {
  $current_url=implode("/",$current_url_pages);
  
  $current_url = preg_replace("/&sort=([a-z]+)/i","",$current_url);
  $current_url = preg_replace("/&order=([a-z]+)/i","",$current_url);
  $current_url = preg_replace("/&page=([0-9]+)/i","",$current_url);
  
  $smarty->assign("current_url",$current_url);
}


/* ---------------- пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅ ---------------- */

if (!$switch_off_smarty){
  if (isset($template_mode) && $template_mode=='single') $smarty_display=$template;
  else {
    if (!isset($main_template)) {
      if (!isset($node_content['template']) || $node_content['template']=='') $main_template='index.html';
      else $main_template=$node_content['template'];
    }
    $smarty_display=$main_template;
  }
}

if ($page_found) header("HTTP/1.0 200 OK");
else {

  $db->query("REPLACE INTO fw_urls (url_from,url_to) VALUES('".@$_SERVER['HTTP_REFERER']."','".BASE_URL.$_SERVER['REQUEST_URI']."')");

  $smarty->assign("page_title","Ошибка 404.");
  require_once (BASE_PATH.'/modules/site_map/front/site_map.f_main.php');
  header("HTTP/1.0 404 Not Found");
}

$smarty->display($smarty_display);

/* ---------- пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅпїЅ пїЅ пїЅпїЅпїЅпїЅпїЅ---------------*/
$db->db_close();
?>