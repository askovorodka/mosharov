<?php
if ($switch_default=='on' or $main_module=='on') {
	//$js[]=BASE_URL.'/modules/shop/front/templates/shop.js';
	//$js[]=BASE_URL.'/lib/JsHttpRequest/Js.js';
}
if  ($main_module=='on') {

$post = &$_POST;
$get = &$_GET;
$session = &$_SESSION;

$navigation[]=array("url" => $module_url,"title" => $node_content['name']);
$smarty->assign("module_url",BASE_URL.'/'.$module_url);

require_once 'lib/class.delItem.php';

/*-----------------ÐÀÇËÈ×ÍÛÅ ÄÅÉÑÒÂÈß-----------------*/


if (isset($post['submit_del_links']) && is_array($post['delInner'])){
	foreach ($post['delInner'] as $key=>$val)
		$db->query("DELETE FROM fw_inner WHERE proj_url_text_id='$key' AND ferm_url_id='$val'");
	$location=$_SERVER['HTTP_REFERER'];
  	header("Location: $location");
  	die();
}

if (isset($post['submit_add_project_ferms']) && is_array($post['sel'])){
	foreach ($post['sel'] as $key=>$val)
		if (intval($key)!="" && intval($val)!="")
			$db->query("REPLACE INTO fw_inner (proj_url_text_id,ferm_url_id,publish_date) VALUES ('$val','$key','".time()."')");
  	header("Location: /projects/links/".$post['url_id']);
  	die();
}

if (isset($post['submit_del_text']) && is_array($post['che1'])){
	foreach ($post['che1'] as $key=>$val)
		$db->query("DELETE FROM fw_project_url_text WHERE id='$key'");
	$location=$_SERVER['HTTP_REFERER'];
  	header("Location: $location");
  	die();
}

if (isset($post['submit_add_text']) && intval($post['url_id'])!=""  &&  trim($post['text'])!=""){
	$floor = explode("\n",$post['text']);
	if (count($floor)>0)
		foreach ($floor as $key=>$val)
			$db->query("INSERT INTO fw_project_url_text (url_id,text) VALUES('".$post['url_id']."','".$val."')");
	$location=$_SERVER['HTTP_REFERER'];
  	header("Location: $location");
  	die();
}

if (isset($post['submit_add_project'])) {
	if (trim($post['name'])!=""){
		$max = $db->get_single("SELECT MAX(sort_order) as MAX FROM fw_projects");
		$sort = $max['MAX']+1;
		$db->query("INSERT INTO fw_projects (name,publish_date,sort_order) VALUES ('".$post['name']."',".time().",$sort)");
	}
	header("Location: /projects/");
	die();
}

if (isset($post['submit_edit_project'])) {
	if (trim($post['project_id'])!=""){
		$db->query("UPDATE fw_projects SET name='".$post['name']."' WHERE id='".$post['project_id']."'");
	}
	header("Location: /projects/");
	die();
}

if (isset($post['submit_add_url'])) {
	if (trim($post['url'])!=""){
		$db->query("INSERT INTO fw_project_urls (name,p_id,url) VALUES ('".$post['name']."','".$post['p_id']."','".$post['url']."')");
	}
	header("Location: /projects/");
	die();
}

if (isset($post['submit_edit_url'])) {
	if (trim($post['url'])!=""  && intval($post['url_id'])!=""){
		$db->query("UPDATE fw_project_urls SET name='".$post['name']."',url='".$post['url']."' WHERE id='".$post['url_id']."'");
	}
	header("Location: /projects/");
	die();
}


/*--------------------ÎÒÎÁÐÀÆÅÍÈÅ---------------------*/

SWITCH (TRUE) {


	//CASE (@$url[$n-1]=='view_urls' && @preg_match("/^\?project_id=[0-9]+$/",$url[$n]) && isset($_GET['project_id']) && count($url)==3):
	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='view_urls'):

		/*$page_found=true;
		require_once BASE_PATH."/lib/JsHttpRequest/config.php";
		require_once BASE_PATH."/lib/JsHttpRequest/Php.php";

		$JsHttpRequest =& new Subsys_JsHttpRequest_Php("windows-1251");

		$_RESULT = array(
		  "val"=> 'hello'
		);

		$switch_off_smarty=true;

		echo "<b>REQUEST_URI:</b> ".$_SERVER['REQUEST_URI']."<br>";
		echo "<b>Loader used:</b> ".$JsHttpRequest->LOADER;*/

		//$page_found=true;
		$items = $db->get_all("SELECT id,url FROM fw_project_urls WHERE p_id='".$url[$n]."'");

		$output = '<?xml version="1.0" encoding="windows-1251" standalone="yes"?>';
		$output .= '<response>';
		if (count($items)>0)
			foreach ($items as $key=>$val){
				$output .= '<item>';
				$output .= '<id>'.$items[$key]['id'].'</id>';
				$output .= '<url>'.$items[$key]['url'].'</url>';
				$output .= '</item>';
			}
		$output .= '</response>';

		$switch_off_smarty=true;
		if (ob_get_length()) ob_clean();
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate('D, d M Y H:i:s') . " GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-Type: text/xml");
		echo $output;
		die();
	
	BREAK;

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='links_add' && count($url)==3):
		$page_found=true;

		$ferms_list = $db->get_all("SELECT id,name,DATE_FORMAT(FROM_UNIXTIME(publish_date),'%d.%m.%Y %H:%m') as publish_date FROM fw_ferms");
		$ferm_urls = $db->get_all("SELECT * FROM fw_ferms_urls");
		$url_item = $db->get_single("SELECT a.id,a.p_id,a.url,a.name,
		(SELECT COUNT(*) FROM fw_project_url_text WHERE url_id=a.id) as count_text,
		(SELECT name FROM fw_projects WHERE id=a.p_id) as p_name FROM fw_project_urls as a WHERE id='".$url[$n]."'");
		$url_texts = $db->get_all("SELECT * FROM fw_project_url_text WHERE url_id='".$url[$n]."'");

		$count_inner = $db->get_all("
				SELECT a.id, b.id, b.url_id, c.proj_url_text_id 
				FROM fw_project_urls AS a
				INNER JOIN (
				fw_project_url_text AS b
				INNER JOIN fw_inner AS c ON b.id = c.proj_url_text_id
				) ON a.id = b.url_id WHERE a.id='".$url[$n]."'");		
		
		$smarty->assign("ferms_list",$ferms_list);
		$smarty->assign("count_inner",count($count_inner));
		$smarty->assign("ferm_urls",$ferm_urls);
		$smarty->assign("url_item",$url_item);
		$smarty->assign("url_texts",$url_texts);
		$template = 'projects.f_links_add.html';
	BREAK;

	CASE ((preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='links' && count($url)==3) || (preg_match("/^([0-9]+)$/",$url[$n]) && preg_match("/^([0-9]+)$/",$url[$n-1]) && $url[$n-2]=='links' && count($url)==4)):
		$page_found=true;
		$count_inner = array();
		if (count($url)==4){ 
			$text_id=$url[$n]; 
			$where = " AND a.proj_url_text_id='$text_id' ";
			unset($url[$n]);
			$n--;
		}
		else
			$where = "";
			
		$item = $db->get_single("SELECT * FROM fw_project_url_text as a WHERE a.url_id='".$url[$n]."'");
		$smarty->assign("text_list",$item);
		$url_item = $db->get_single("SELECT a.id,a.p_id,a.url,a.name,
		(SELECT COUNT(*) FROM fw_project_url_text WHERE url_id=a.id) as count_text,
		(SELECT name FROM fw_projects WHERE id=a.p_id) as p_name FROM fw_project_urls as a WHERE id='".$url[$n]."'");
		
		$inner = $db->get_all("SELECT a.*, 
		(SELECT url_id FROM fw_project_url_text WHERE id=a.proj_url_text_id) as url_id,
		(SELECT text FROM fw_project_url_text WHERE id=a.proj_url_text_id) as url_text,
		(SELECT url FROM fw_ferms_urls WHERE id=a.ferm_url_id) as url_ferm,
		DATE_FORMAT(FROM_UNIXTIME(a.publish_date),'%d.%m.%Y') as date,
		(SELECT COUNT(*) FROM fw_inner WHERE ferm_url_id=a.ferm_url_id) as count_ferms 
		FROM fw_inner as a WHERE (SELECT url_id FROM fw_project_url_text WHERE id=a.proj_url_text_id)='".$url[$n]."' $where ");

		$count_inner = $db->get_all("
				SELECT a.id, b.id, b.url_id, c.proj_url_text_id 
				FROM fw_project_urls AS a
				INNER JOIN (
				fw_project_url_text AS b
				INNER JOIN fw_inner AS c ON b.id = c.proj_url_text_id
				) ON a.id = b.url_id WHERE a.id='".$url[$n]."'");		
		
		if (count($inner)>0)
			foreach ($inner as $key=>$val){
				if (strlen(trim($inner[$key]['url_text']))>0){
					$inner[$key]['url_text'] = str_replace("#a#","<u>",$inner[$key]['url_text']);
					$inner[$key]['url_text'] = str_replace("#/a#","</u>",$inner[$key]['url_text']);
				}
			}
		$smarty->assign("inner_list",$inner);
		$smarty->assign("count_inner",count($count_inner));
		$smarty->assign("url_item",$url_item);
		$template = 'projects.f_links_main.html';
	BREAK;

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='text' && count($url)==3):
		$page_found=true;

		$item=array("");
		$item = $db->get_all("SELECT *,(SELECT COUNT(*) FROM fw_inner WHERE proj_url_text_id=a.id) as count_texts FROM fw_project_url_text as a WHERE a.url_id='".$url[$n]."'");
		if (count($item)>0){
			$item = String::unformat_array($item);
			foreach ($item as $key=>$val){
				$item[$key]['text'] = str_replace("#a#","<u>",$item[$key]['text']);
				$item[$key]['text'] = str_replace("#/a#","</u>",$item[$key]['text']);
			}
		}
		
		$url_item = $db->get_single("SELECT a.id,a.p_id,a.url,a.name,
		(SELECT COUNT(*) FROM fw_project_url_text WHERE url_id=a.id) as count_text,
		(SELECT name FROM fw_projects WHERE id=a.p_id) as p_name FROM fw_project_urls as a WHERE id='".$url[$n]."'");

		$count_inner = $db->get_all("
				SELECT a.id, b.id, b.url_id, c.proj_url_text_id 
				FROM fw_project_urls AS a
				INNER JOIN (
				fw_project_url_text AS b
				INNER JOIN fw_inner AS c ON b.id = c.proj_url_text_id
				) ON a.id = b.url_id WHERE a.id='".$url[$n]."'");		

		$smarty->assign("url_item",$url_item);
		$smarty->assign("count_inner",count($count_inner));
		$smarty->assign("text_list",$item);
		$template = 'projects.f_text_main.html';
	BREAK;

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='del'):
		//$db->query("DELETE FROM fw_projects WHERE id='".$url[$n]."'");	
		//$db->query("DELETE FROM fw_project_urls WHERE p_id='".$url[$n]."'");	
		/*$db->query("DELETE FROM fw_projects,
								fw_project_urls,
								fw_project_url_text,
								fw_inner 
								USING 
							 	fw_projects,
								fw_project_urls,
								fw_project_url_text,
								fw_inner  
					WHERE (fw_projects.id=fw_project_urls.p_id 
						AND fw_project_urls.id=fw_project_url_text.url_id 
						AND fw_project_url_text.id=fw_inner.proj_url_text_id) 
					AND fw_projects.id='".$url[$n]."'");*/
		/*$db->query("DELETE  fw_projects,
							fw_project_urls,
							fw_project_url_text,
							fw_inner
							FROM fw_projects 
							RIGHT JOIN (fw_project_urls RIGHT JOIN 
								(fw_project_url_text RIGHT JOIN fw_inner ON fw_project_url_text.id=fw_inner.proj_url_text_id) ON 
								fw_project_urls.id=fw_project_url_text.url_id) ON fw_projects.id=fw_project_urls.p_id  WHERE 
								fw_projects.id='".$url[$n]."'
							");*/
		$del = new delItem();
		$del->delProject($url[$n]);
		
  		$location=$_SERVER['HTTP_REFERER'];
  		header("Location: $location");
  		die();
	BREAK;

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='del_url'):
		$db->query("DELETE FROM fw_project_urls WHERE id='".$url[$n]."'");	
  		$location=$_SERVER['HTTP_REFERER'];
  		header("Location: $location");
  		die();
	BREAK;

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='edit'):
		$item=$db->get_single("SELECT * FROM fw_projects WHERE id='".$url[$n]."'");
		$smarty->assign("item",$item);
		$smarty->assign("mode","edit");
		$page_found=true;
		$template='projects.f_add.html';
	BREAK;

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='edit_url'):
		$item=$db->get_single("SELECT * FROM fw_project_urls WHERE id='".$url[$n]."'");
		if (count($item)>0)
		$item = String::unformat_array($item);
		$smarty->assign("item",$item);
		$smarty->assign("mode","edit");
		$item = $db->get_single("SELECT name FROM fw_projects WHERE id='".$item['p_id']."'");
		$smarty->assign("project_name",$item['name']);
		$page_found=true;
		$template='projects.f_url_add.html';
	BREAK;

	CASE ($url[$n]=='add_project' && count($url)==2):
		$page_found=true;
		$smarty->assign("mode","add");
		$template='projects.f_add.html';
	BREAK;

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='add_url'):
		$item = $db->get_single("SELECT name FROM fw_projects WHERE id='".$url[$n]."'");
		$smarty->assign("mode","add");
		$page_found=true;
		$smarty->assign("project_id",$url[$n]);
		$smarty->assign("project_name",$item['name']);
		$template='projects.f_url_add.html';
	BREAK;


	DEFAULT:


		$item=$db->get_all("SELECT id,name,DATE_FORMAT(FROM_UNIXTIME(publish_date),'%d.%m.%Y&nbsp;%H:%m') as publish_date FROM fw_projects ORDER BY publish_date");
		$urls = $db->get_all("SELECT id,p_id,url,name,(SELECT count(*) FROM fw_project_url_text WHERE url_id=fw_project_urls.id) as count_texts FROM fw_project_urls");
		if (count($item)>0)
			foreach ($item as $key=>$val){
				if (!preg_match("/^http:\/\//i",$item[$key]['name'],$matches))
					$item[$key]['url_name'] = 'http://'.$item[$key]['name'];
				else
					$item[$key]['url_name'] = $item[$key]['name'];
			}
		if (count($item)>0){
			$smarty->assign("projects_list",$item);
			$smarty->assign("project_urls",$urls);
		}
		$page_found=true;
		$template='projects.f_main.html';

	BREAK;
}

}

?>
