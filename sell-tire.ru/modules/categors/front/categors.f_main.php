<?php
//$_SESSION['fw_basket']=array();
if ($switch_default=='on' or $main_module=='on') {

	$js[]=BASE_URL.'/modules/shop/front/templates/shop.js';
	$js[]=BASE_URL.'/lib/JsHttpRequest/Js.js';


}
if  ($main_module=='on') {

$css[]=BASE_URL.'/modules/shop/front/templates/shop.css';

$navigation[]=array("url" => $module_url,"title" => $node_content['name']);
$smarty->assign("module_url",BASE_URL.'/'.$module_url);

/*-----------------пюгкхвмше деиярбхъ-----------------*/


if (isset($post['submit_add_cat']) &&  trim($post['text'])!=""){
echo "123";exit;
	$floor = explode("\n",$post['text']);
	if (count($floor)>0)
		foreach ($floor as $key=>$val)
			$db->query("INSERT INTO fw_categors (name) VALUES('".$val."')");
	$location=$_SERVER['HTTP_REFERER'];
  	header("Location: $location");
  	die();
}



/*--------------------нрнапюфемхе---------------------*/

SWITCH (TRUE) {


	DEFAULT:
		$page_found=true;
		$cat_list = array();
		$cat_list = $db->get_all("SELECT * FROM fw_categors");
		$smarty->assign("cat_list",$cat_list);
		$template = 'categors.f_main.html';
	BREAK;

}

}

?>