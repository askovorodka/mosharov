<?php

if ($switch_default=='on' or $switch_support=='on') {
  
  $smarty->assign("otr_list_support",$db->get_all("SELECT * FROM fw_otr ORDER BY title ASC"));
  $smarty->assign("otr_url",$support_url);
}
if  ($main_module=='on') {

require_once 'lib/class.photoalbum.php';
require_once 'lib/class.table.php';
require_once 'lib/class.form.php';
require_once 'lib/class.mail.php';

$navigation[]=array("url" => $module_url,"title" => $node_content['name']);

if (isset($_POST['submit_otr_comment'])){
      $name = $_POST['user_name'];
      $email = $_POST['user_mail'];
      $msg = $_POST['user_msg'];
      Mail::send_mail(ADMIN_MAIL,ADMIN_MAIL,"Сообщение из раздела 'Отраслевые решения'",$msg,'','text','standard','WIndows-1251');
      $smarty->assign("send_msg","Ваше сообщение отправлено администратору сайта. Спасибо.");
}

SWITCH (TRUE) {
  
  CASE (count($url)==1):
  
    $page_found=true;
    
    $otr_list=$db->get_all("SELECT * FROM fw_otr ORDER BY title ASC");
    
    $smarty->assign("otr_list",$otr_list);
    $template='otr_list.html';
  BREAK;
  
  CASE (($url[$n]=='archive' && count($url)==2) || ($url[$n-1]=='archive' && preg_match("/^page_([0-9]+)$/",$url[$n]) && count($url)==3)):
    $page_found=true;
    $navigation[]=array("url" => "archive","title" => "Архив");
    
    if (preg_match("/^page_([0-9]+)$/",$url[$n])) {
      list(,$page)=explode("_",$url[$n]);
      $url=array_values($url);
    }
    else $page=1;
    
    $result=$db->query("SELECT COUNT(*) FROM fw_news");
    $pager=Common::pager($result,NEWS_PER_PAGE_FRONT_ARCHIVE,$page);

    $smarty->assign("total_pages",$pager['total_pages']);
    $smarty->assign("current_page",$pager['current_page']);
    $smarty->assign("pages",$pager['pages']);
    $smarty->assign("mode","archive");
    
    $news_list=$db->get_all("SELECT * FROM fw_news ORDER BY publish_date DESC LIMIT ".$pager['limit']);
    
    $page_title=$node_content['name'].' - '.'Архив';
    
    $smarty->assign("news_list",$news_list);
    $template='news_list.html';
  BREAK;
  
  CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='otr' && count($url)==2):
    
    $id=$url[$n];
    $result=$db->get_single("SELECT * FROM fw_otr WHERE id='$id'");
    
    if ($result['id']>0) {
      
	// ----парсинг контекта для вставки фотоальбома, таблицы и формы -- //
			
	$photo = new Photoalbum();
	$result['text']= $photo->pregReplace($result['text'],BASE_PATH,PHOTOS_FOLDER,PHOTOS_PER_PAGE_SUP);
				
	$table = new Table();
	$result['text'] = $table->pregReplace($result['text'],BASE_PATH);

	$form = new Form();
	$result['text'] = $form->pregReplace($result['text'],BASE_PATH);

	// ---- конец парсинга контекта для вставки фотоальбома, таблицы и формы -- //
      
      
      $page_found=true;
      
      $navigation[]=array("url" => $result['title'],"title" => $result['title']);

      $page_title=$node_content['name'].' - '.$result['title'];
      
      $smarty->assign("single_otr",$result);
      $template='show_single_otr.html';
    }
    
  BREAK;
}

}
?>
