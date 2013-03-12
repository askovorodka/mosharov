<?php

require_once BASE_PATH.'/lib/class.image.php';

$smarty->register_function("banners", "show_banners");

function show_banners ($params) {

	global $db;
	global $smarty;
	
	$group_text="";
	if (isset($params['group'])) {
		$group_id=$params['group'];
		$group_text="`group`='".$group_id."' AND";
	}

	$limit="";
	if (!isset($params['all'])) $limit="LIMIT 1";

	$banner=$db->get_all("
		SELECT * FROM fw_banners 
		WHERE status='1' and showings > shown 
		AND $group_text id IN 
		(SELECT banner_id FROM fw_banners_cat 
			WHERE url LIKE '".$_SERVER['REQUEST_URI']."%' 
			GROUP BY banner_id ORDER BY LENGTH(url)) 
			AND ((end_date>'".time()."' AND start_date<'".time()."') OR (end_date='0' AND start_date='0')) 
		ORDER BY RAND() $limit");
	
	//print_r($banner);
	/*echo "
		SELECT * FROM fw_banners 
		WHERE status='1' and showings>shown 
		AND $group_text id IN 
		(SELECT banner_id FROM fw_banners_cat 
			WHERE url LIKE '".$_SERVER['REQUEST_URI']."%' 
			GROUP BY banner_id ORDER BY LENGTH(url)) 
			AND ((end_date>'".time()."' AND start_date<'".time()."') OR (end_date='0' AND start_date='0')) 
		ORDER BY RAND() $limit";*/
	
	//$banner=$db->get_all("SELECT * FROM fw_banners WHERE showings>shown AND $group_text ((end_date>'".time()."' AND start_date<'".time()."') OR (end_date='0' AND start_date='0')) ORDER BY RAND() $limit");	
	
	$global_return="";
	foreach ($banner as $key => $banner) {
		if (isset($banner['id'])) {
	
			$db->query("UPDATE fw_banners SET shown=shown+1 WHERE id='".$banner['id']."'");
		
			if ($banner['type']=='1' && $banner['image']!='') {
			
				$output=Image::image_details(BASE_PATH.'/uploaded_files/banners/'.$banner['id'].'.'.$banner['image']);
			
				$smarty->assign("width",$output['width']);
				$smarty->assign("height",$output['height']);
			}
		
			$smarty->assign("banner",$banner);
		
			$output=$smarty->fetch(BASE_PATH.'/modules/banners/front/templates/show_banners.html');

			$global_return.=$output;
		}
	}

	return $global_return;
}

?>