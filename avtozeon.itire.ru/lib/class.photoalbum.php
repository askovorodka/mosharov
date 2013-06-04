<?php
class Photoalbum{

	function pregReplace($content,$base_path,$photos_folder,$photos_per_page_up){

			if (preg_match_all('/{photoalbum\sid="\d{1,2}"}/',$content,$matches))
				if (is_array($matches))
					foreach ($matches as $key=>$val)
						foreach ($matches[$key] as $key2=>$val2)
							if (preg_match("/\d{1,2}/", $matches[$key][$key2], $submathes)){
								$photoalbum_id = intval($submathes[0]);
								$out_photoalbum = $this->show_photoalbum(array("id"=>$photoalbum_id),$base_path,$photos_folder,$photos_per_page_up);
								if (strlen(trim($out_photoalbum))>0)
									$content = str_replace($matches[$key][$key2],$out_photoalbum,$content);
							}
				
			return $content;
	}
	
	function show_photoalbum ($params,$base_path,$photos_folder,$photos_per_page_sup) {

		global $db;
		global $smarty;
		$res = $db->get_single("SELECT url FROM fw_tree WHERE module='photoalbum' LIMIT 1");
		$support_url=$res['url'];
		
		$album_id=$params['id'];
		
		$photos_list=$db->get_all("SELECT *,(SELECT COUNT(*) FROM fw_photoalbum_images WHERE parent='$album_id') AS count FROM fw_photoalbum_images WHERE parent='$album_id' ORDER BY sort_order LIMIT ".$photos_per_page_sup);
		
		for ($i=0;$i<sizeof($photos_list);$i++) {
			$photo_file=$base_path.'/'.$photos_folder.'/'.$photos_list[$i]['id'].'.'.$photos_list[$i]['ext'];
			$output=Image::image_details($photo_file);
			$photos_list[$i]['width']=$output['width']+20;
			$photos_list[$i]['height']=$output['height']+20;
		}
		
		if ($photos_list[0]['count']>$photos_per_page_sup) {
			$cl=$db->get_all("SELECT *,(SELECT parent FROM fw_photoalbums WHERE id='$album_id') AS album FROM fw_photoalbum_cat c WHERE c.status='1' ORDER BY c.param_left");
			$album_parent=$cl[0]['album'];
			$cl=Common::get_nodes_list($cl);
			
			foreach ($cl as $k=>$v) {
				if ($v['id']==$album_parent) $album_url=$v['full_url'];
			}
			
			$album_url=$support_url.$album_url.'album_'.$album_id;

			$smarty->assign("album_url",$album_url);
		}
		
		$smarty->assign("photos_list",$photos_list);
		$smarty->assign("base_path",$base_path);
		$smarty->assign("photos_folder",$photos_folder);
		$smarty->assign("photos_per_page_sup",$photos_per_page_sup);
		$smarty->assign("total_photos",$photos_list[0]['count']);
		
		$output=$smarty->fetch($base_path.'/modules/photoalbum/front/templates/show_photoalbum_support.html');
		
		return $output;
		
	}

}

?>