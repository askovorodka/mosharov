<?php

$css[]=BASE_URL.'/modules/guestbook/front/templates/guestbook.css';
require_once 'lib/class.mail.php';
$navigation[]=array("url" => $module_url,"title" => $node_content['name']);

$this_module=$db->get_single("SELECT priv FROM fw_modules WHERE name='guestbook' LIMIT 1");

	
if (isset($_SESSION['fw_user']) && $_SESSION['fw_user']['priv']<=$this_module['priv']) {
	$smarty->assign("show_admin_menu","true");
	$is_admin=true;
}
else $is_admin=false;

if (isset($_POST['submit_new_message'])) {
	
	$check=true;

	$author=String::secure_user_input($_POST['nm_name']);
	
	if (!preg_match("/^[a-z0-9_\.-]*@[a-z0-9_\.-]*\.[a-z]{0,3}$/i",$_POST['nm_mail']) && $_POST['nm_mail']!='') {
		$check=false;
		$smarty->assign("error_message","Введённый e-mail имеет неправильный формат");
	}
	else $mail=$_POST['nm_mail'];
	
	$text=Common::strip_forum_tags($_POST['nm_text']);
	
	if ($check) {
		
		if (GB_PREMODERATION=='on') {
			$status='0';
		}
		else $status='1';
		
		$db->query("INSERT INTO fw_guestbook(author,message,insert_date,author_mail,status) VALUES('$author','$text','".time()."','$mail','$status')");
    	$body=$smarty->fetch(BASE_PATH.'/modules/guestbook/admin_mail_template.txt');
        $headers  = "Content-type: text/html; charset=windows-1251 \r\n";
        $headers .= "From: <".BASE_URL.">\r\n";
		Mail::send_mail($mail,ADMIN_MAIL,"Новое сообщение на сайте ".BASE_URL,$body,"","text","standard","windows-1251");
		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
	}
}

if (preg_match("/^page_([0-9]+)$/",$url[$n])) {
	list(,$page)=explode("_",$url[$n]);
	$url=array_values($url);
	unset($url[$n]);
	unset($current_url_pages[count($current_url_pages)-1]);
}
else $page=1;

SWITCH (TRUE) {

	CASE (count($url)==1):

		$page_found=true;

		if (GB_PREMODERATION=='on') {
			$smarty->assign("premoderation","on");
		}
		
		if ($is_admin) $status='0';
		else $status='1';

		$result=$db->query("SELECT COUNT(*) FROM fw_guestbook WHERE status='$status'");
		$pager=Common::pager($result,GB_MESSAGES_PER_PAGE,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);

		$messages_list=$db->get_all("SELECT * FROM fw_guestbook WHERE status>='$status' ORDER BY insert_date DESC LIMIT ".$pager['limit']);
		
		$smarty->assign("messages_list",$messages_list);

		$template='guestbook_main.html';

	BREAK;
}

?>