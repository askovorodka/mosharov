<?php
//$_SESSION['fw_basket']=array();
if ($switch_default=='on' or $main_module=='on') {

	$js[]=BASE_URL.'/modules/shop/front/templates/shop.js';
	$js[]=BASE_URL.'/lib/JsHttpRequest/Js.js';

$post = &$_POST;
$get = &$_GET;
$session = &$_SESSION;

}
if  ($main_module=='on') {

$navigation[]=array("url" => $module_url,"title" => $node_content['name']);
$smarty->assign("module_url",BASE_URL.'/'.$module_url);

/*-----------------ÐÀÇËÈ×ÍÛÅ ÄÅÉÑÒÂÈß-----------------*/


if (isset($post['submit_edit_url'])) {
	if (trim($post['url'])!=""  && intval($post['url_id'])!=""){
		$db->query("UPDATE fw_ferms_urls SET url='".$post['url']."' WHERE id='".$post['url_id']."'");
	}
	header("Location: /ferms/");
	die();
}

if (isset($post['submit_add_ferm'])) {
	if (trim($post['name'])!=""){
		$max = $db->get_single("SELECT MAX(sort_order) as MAX FROM fw_ferms");
		$sort = $max['MAX']+1;
		$db->query("INSERT INTO fw_ferms (name,publish_date,sort_order) VALUES ('".$post['name']."',".time().",$sort)");
	}
	header("Location: /ferms/");
	die();
}
if (isset($post['submit_edit_ferm'])) {
	if (trim($post['ferm_id'])!=""){
		$db->query("UPDATE fw_ferms SET name='".$post['name']."' WHERE id='".$post['ferm_id']."'");
	}
	header("Location: /ferms/");
	die();
}
if (isset($post['submit_add_url'])) {
	if (trim($post['url'])!=""){
		$db->query("INSERT INTO fw_ferms_urls (ferm_id,url) VALUES ('".$post['ferm_id']."','".$post['url']."')");
	}
	header("Location: /ferms/");
	die();
}



if (isset($_POST['submit_rating'])) {

	$id=$_POST['id'];

	$comment=String::secure_user_input($_POST['nm_text']);
	$comment=Common::strip_forum_tags($comment);

	$author=$_SESSION['fw_user']['id'];

	if ($comment!='') {
		$db->query("INSERT INTO fw_products_comments(product_id,author,text,insert_date) VALUES('$id','$author','$comment','".time()."')");
	}

	if (isset($_POST['rating'])) {

		$rating=$_POST['rating'];

		$check_rating=explode(",",$_COOKIE['fw_rating']);
		if (!in_array($id,$check_rating)) {

			$db->query("UPDATE fw_products SET rating=rating+$rating WHERE id='$id'");

			if (!@isset($_COOKIE['fw_rating']) or $_COOKIE['fw_rating']=='') $cookie_content=$id;
			else $cookie_content=$_COOKIE['fw_rating'].','.$id;

			setcookie('fw_rating',$cookie_content,time()+315360000,'/','');
		}
	}

	$location=@$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}


/*--------------------ÎÒÎÁÐÀÆÅÍÈÅ---------------------*/
//Common::dumper($_SESSION['fw_basket']);
if (!isset($_SESSION['fw_basket'])) $_SESSION['fw_basket']=array();

SWITCH (TRUE) {

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='edit_url'):
		$item=$db->get_single("SELECT * FROM fw_ferms_urls WHERE id='".$url[$n]."'");
		if (count($item)>0)
		$item = String::unformat_array($item);
		$smarty->assign("item",$item);
		$smarty->assign("mode","edit");
		$item = $db->get_single("SELECT name FROM fw_ferms WHERE id='".$item['ferm_id']."'");
		$smarty->assign("ferm_name",$item['name']);
		$page_found=true;
		$template='ferms.f_url_add.html';
	BREAK;

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='del_url'):
		$db->query("DELETE FROM fw_ferms_urls WHERE id='".$url[$n]."'");	
  		$location=$_SERVER['HTTP_REFERER'];
  		header("Location: $location");
  		die();
	BREAK;

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='add_url'):
		$item = $db->get_single("SELECT name FROM fw_ferms WHERE id='".$url[$n]."'");
		$smarty->assign("mode","add");
		$page_found=true;
		$smarty->assign("ferm_id",$url[$n]);
		$smarty->assign("ferm_name",$item['name']);
		$template='ferms.f_url_add.html';
	BREAK;

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='del'):
		$db->query("DELETE FROM fw_ferms WHERE id='".$url[$n]."'");	
		$db->query("DELETE FROM fw_ferms_urls WHERE ferm_id='".$url[$n]."'");	
  		$location=$_SERVER['HTTP_REFERER'];
  		header("Location: $location");
  		die();
	BREAK;

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='edit'):
		$item=$db->get_single("SELECT * FROM fw_ferms WHERE id='".$url[$n]."'");
		$smarty->assign("item",$item);
		$smarty->assign("mode","edit");
		$page_found=true;
		$template='ferms.f_add.html';
	BREAK;


	CASE ($url[$n]=='add_ferm' && count($url)==2):
		$page_found=true;
		$smarty->assign("mode","add");
		$template='ferms.f_add.html';
	BREAK;

	DEFAULT:

		$item=$db->get_all("SELECT id,name,DATE_FORMAT(FROM_UNIXTIME(publish_date),'%d.%m.%Y&nbsp;%H:%m') as publish_date FROM fw_ferms ORDER BY publish_date");
		$urls = $db->get_all("SELECT id,ferm_id,url FROM fw_ferms_urls");
		if (count($item)>0)
			foreach ($item as $key=>$val){
				if (!preg_match("/^http:\/\//i",$item[$key]['name'],$matches))
					$item[$key]['url_name'] = 'http://'.$item[$key]['name'];
				else
					$item[$key]['url_name'] = $item[$key]['name'];
			}
		if (count($item)>0){
			$smarty->assign("ferms_list",$item);
			$smarty->assign("ferm_urls",$urls);
		}
		$page_found=true;
		$template='ferms.f_main.html';

	BREAK;
}

}

?>
