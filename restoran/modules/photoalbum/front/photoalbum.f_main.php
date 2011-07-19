<?php

require_once (BASE_PATH.'/lib/class.image.php');
$css[]=BASE_URL.'/modules/photoalbum/front/templates/photoalbum.css';

$smarty->assign("photos_folder",PHOTOS_FOLDER);
$smarty->assign("photoalbum_mode",PHOTOALBUM_MODE);

if (($switch_default=='on' or $switch_support=='on') && $main_module!='on') {
	
	$smarty->register_function("photoalbum", "show_photoalbum");

	function show_photoalbum ($params) {

		global $db;
		global $smarty;
		$res = $db->get_single("SELECT url FROM fw_tree WHERE module='photoalbum' LIMIT 1");
		$support_url=$res['url'];
		
		$album_id=$params['id'];
		
		$photos_list=$db->get_all("SELECT *,(SELECT COUNT(*) FROM fw_photoalbum_images WHERE parent='$album_id') AS count FROM fw_photoalbum_images WHERE parent='$album_id' ORDER BY sort_order LIMIT ".PHOTOS_PER_PAGE_SUP);
		
		for ($i=0;$i<sizeof($photos_list);$i++) {
			$photo_file=BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$photos_list[$i]['id'].'.'.$photos_list[$i]['ext'];
			$output=Image::image_details($photo_file);
			$photos_list[$i]['width']=$output['width']+20;
			$photos_list[$i]['height']=$output['height']+20;
		}
		
		if ($photos_list[0]['count']>PHOTOS_PER_PAGE_SUP) {
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
		$smarty->assign("photos_per_page_sup",PHOTOS_PER_PAGE_SUP);
		$smarty->assign("total_photos",$photos_list[0]['count']);
		
		$output=$smarty->fetch(BASE_PATH.'/modules/photoalbum/front/templates/show_photoalbum_support.html');
		
		return $output;
		
	}
	
}
else {

$navigation[]=array("url" => $module_url,"title" => $node_content['name']);
$smarty->assign("module_url",BASE_URL.'/'.$module_url);

$cl=$db->get_all("SELECT *,(SELECT COUNT(*) FROM fw_photoalbums WHERE parent=c.id AND status='1') AS albums FROM fw_photoalbum_cat c WHERE c.status='1' ORDER BY c.param_left");

$this_module=$db->get_single("SELECT priv FROM fw_modules WHERE name='guestbook' LIMIT 1");

	
if (@$_SESSION['fw_user']['priv']<=$this_module['priv']) {
	$smarty->assign("show_admin_menu","true");
	$is_admin=true;
}
else $is_admin=false;

/*-----------------��������� ��������-----------------*/

if (isset($_POST['submit_new_comment'])) {
	
	$check=true;

	$author=String::secure_user_input($_POST['nm_name']);
	$photo_id=$_POST['photo_id'];
	
	$text=String::secure_user_input($_POST['nm_text']);
	$text=Common::strip_forum_tags($text);
		
	$db->query("INSERT INTO fw_photoalbum_comments(author,comment,insert_date,photo_id) VALUES('$author','$text','".time()."','$photo_id')");
		
	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if (preg_match("/^page_[0-9]+$/",$url[$n])) {
	list(,$page)=explode("_",$url[$n]);
	$url=array_values($url);
	unset($url[$n]);
	unset($current_url_pages[count($current_url_pages)-1]);
	$n=count($url)-1;
}
else $page=1;

/*--------------------�����������---------------------*/
SWITCH (TRUE) {
	
	CASE ((preg_match("/^album_([0-9]+)$/",$url[$n])) || (@preg_match("/^album_([0-9]+)$/",$url[$n-1]) && preg_match("/^\?page=([0-9]+)$/",$url[$n]))):
	
		$cat_list=Common::get_nodes_list($cl);
		unset($url[0]);
		
		if (isset($_GET['page'])) {
			$page=$_GET['page'];
			$album_id=str_replace("album_","",$url[$n-1]);
			unset($url[$n]);
			unset($url[$n-1]);
			unset($current_url_pages[$n]);
		}
		else {
			$page=1;
			$album_id=str_replace("album_","",$url[$n]);
			unset($url[$n]);
		}
		
		
		$album=$db->get_single("SELECT *,(SELECT COUNT(*) FROM fw_photoalbum_images WHERE parent='$album_id') AS count FROM fw_photoalbums WHERE id='$album_id' AND status='1'");
		
		for ($f=0;$f<count($cat_list);$f++) {
			$url_to_check=implode("/",$url).'/';
			if ($cat_list[$f]['full_url']==$url_to_check && $cat_list[$f]['id']==$album['parent']) {
				$page_found=true;
				
				$pager=Common::pager($album['count'],PHOTOS_PER_PAGE,$page);
				
				$photos_list=$db->get_all("SELECT * FROM fw_photoalbum_images WHERE parent='$album_id' ORDER BY sort_order LIMIT ".$pager['limit']);
				
				for ($i=0;$i<sizeof($photos_list);$i++) {
					$output=Image::image_details(BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$photos_list[$i]['id'].'.'.$photos_list[$i]['ext']);
					$photos_list[$i]['width']=$output['width']+20;
					$photos_list[$i]['height']=$output['height']+20;
				}

				if ($cat_list[$f]['full_title']!='/') {
					$nav_titles=explode("/",$cat_list[$f]['full_title']);
					$nav_urls=explode("/",$cat_list[$f]['full_url']);
					unset($nav_titles[count($nav_titles)-1]);
					unset($nav_urls[count($nav_urls)-1]);
					for ($l=0;$l<count($nav_titles);$l++) {
						$navigation[]=array("url" => $nav_urls[$l],"title" => trim($nav_titles[$l]));
					}
				}
				$navigation[]=array("url" => $album['id'],"title" => $album['name']);

				$smarty->assign("total_pages",$pager['total_pages']);
				$smarty->assign("current_page",$pager['current_page']);
				$smarty->assign("pages",$pager['pages']);
				
				$smarty->assign("total_photos",count($photos_list));
						
				$smarty->assign("album",$album);
				$smarty->assign("photos_list",$photos_list);
				$template='show_photoalbum.html';
			}
	
		}
		

	BREAK;
	
	CASE (@preg_match("/^album_([0-9]+)$/",$url[$n-1]) && preg_match("/^([0-9]+)$/",$url[$n])):

		$cat_list=Common::get_nodes_list($cl);
		unset($url[0]);
	
		$album_id=str_replace("album_","",$url[$n-1]);
		$photo_id=$url[$n];
		unset($url[$n]);
		unset($url[$n-1]);
		unset($current_url_pages[$n]);
		$set_pages_url=true;
		
		$album=$db->get_single("SELECT * FROM fw_photoalbums WHERE id='$album_id'");
		
		for ($f=0;$f<count($cat_list);$f++) {
			$url_to_check=implode("/",$url).'/';
			if ($cat_list[$f]['full_url']==$url_to_check && $cat_list[$f]['id']==$album['parent']) {
				
				$photos_list=$db->get_all("SELECT * FROM fw_photoalbum_images WHERE parent='$album_id' ORDER BY sort_order");

				foreach ($photos_list as $k=>$v) {
					if ($v['id']==$photo_id) {
						$current_photo=$v;
						$page_found=true;
					}
				}
				
				if ($cat_list[$f]['full_title']!='/') {
					$nav_titles=explode("/",$cat_list[$f]['full_title']);
					$nav_urls=explode("/",$cat_list[$f]['full_url']);
					unset($nav_titles[count($nav_titles)-1]);
					unset($nav_urls[count($nav_urls)-1]);
					for ($l=0;$l<count($nav_titles);$l++) {
						$navigation[]=array("url" => $nav_urls[$l],"title" => trim($nav_titles[$l]));
					}
				}
				$navigation[]=array("url" => $album['id'],"title" => $album['name']);
				
				$cp=$current_photo['id'].'.'.$current_photo['ext'];
				if (file_exists(BASE_PATH.'/'.PHOTOS_FOLDER.'/medium-'.$cp)) {
					$smarty->assign("big_photo",$cp);
					$current_photo['image']='medium-'.$cp;
				}
				else $current_photo['image']=$cp;
				
				if ($album['switch_comments']=='1') {
					
					$result=$db->query("SELECT COUNT(*) FROM fw_photoalbum_comments WHERE photo_id='".$current_photo['id']."'");
					$pager=Common::pager($result,PHOTOALBUM_COMMENTS_PER_PAGE,$page);
			
					$smarty->assign("total_pages",$pager['total_pages']);
					$smarty->assign("current_page",$pager['current_page']);
					$smarty->assign("pages",$pager['pages']);
					
					$comments_list=$db->get_all("SELECT * FROM fw_photoalbum_comments WHERE photo_id='".$current_photo['id']."' ORDER BY insert_date DESC LIMIT ".$pager['limit']);
					$smarty->assign("comments_list",$comments_list);
				}
				
				$smarty->assign("current_photo",$current_photo);
				$smarty->assign("photos_list",$photos_list);
				$smarty->assign("switch_comments",$album['switch_comments']);
				$main_template="index_mini.html";
				$template='show_photoalbum_photos.html';

			}
		}
			
	BREAK;
	
	DEFAULT:
	
		$cat_list=Common::get_nodes_list($cl);

		unset($url[0]);

		if (isset($_GET['page'])) {
			$page=$_GET['page'];
			unset($current_url_pages[count($current_url_pages)-1]);
		}
		else $page=1;

		for ($f=0;$f<count($cat_list);$f++) {
			$url_to_check=implode("/",$url).'/';
			if ($cat_list[$f]['full_url']==$url_to_check) {
				$cat_content=$cat_list[$f];
				$page_found=true;
				$photoalbum_cat_list=array();
				
				for ($i=0;$i<sizeof($cat_list);$i++) {
					if ($cat_list[$i]['param_left']>$cat_content['param_left'] && $cat_list[$i]['param_right']<$cat_content['param_right'] && $cat_list[$i]['param_level']==$cat_content['param_level']+1) $photoalbum_cat_list[]=$cat_list[$i];
				}
				
				
				for ($i=0;$i<sizeof($photoalbum_cat_list);$i++) {
					for ($c=0;$c<sizeof($cat_list);$c++) {
						if ($cat_list[$c]['param_left']>$photoalbum_cat_list[$i]['param_left'] && $cat_list[$c]['param_right']<$photoalbum_cat_list[$i]['param_right']) $photoalbum_cat_list[$i]['subcat'][]=$cat_list[$c];
				
					}
				}
				
				$smarty->assign("count_cat",count($photoalbum_cat_list));
				$smarty->assign("cat_list",$photoalbum_cat_list);
				
				if ($cat_content['title']!='') $page_title=$cat_content['title'];
				else if ($cat_content['name']!='/') $page_title=$cat_content['name'];
				if ($cat_content['meta_keywords']!='') $meta_keywords=$cat_content['meta_keywords'];
				if ($cat_content['meta_description']!='') $meta_description=$cat_content['meta_description'];
				
				$result=$db->query("SELECT COUNT(*) FROM fw_photoalbums WHERE parent='".$cat_content['id']."' AND status='1'");
				$pager=Common::pager($result,ALBUMS_PER_PAGE,$page);
		
				$smarty->assign("total_pages",$pager['total_pages']);
				$smarty->assign("current_page",$pager['current_page']);
				$smarty->assign("pages",$pager['pages']);
					
				$albums_list=$db->get_all("SELECT *,(SELECT CONCAT(id,'.',ext) FROM fw_photoalbum_images WHERE parent=a.id ORDER BY sort_order LIMIT 1) AS image,(SELECT COUNT(*) FROM fw_photoalbum_images WHERE parent=a.id) AS photos FROM fw_photoalbums a WHERE a.parent='".$cat_content['id']."' AND status='1' ORDER BY insert_date DESC LIMIT ".$pager['limit']);
				
				if ($cat_list[$f]['full_title']!='/') {
					$nav_titles=explode("/",$cat_list[$f]['full_title']);
					$nav_urls=explode("/",$cat_list[$f]['full_url']);
					unset($nav_titles[count($nav_titles)-1]);
					unset($nav_urls[count($nav_urls)-1]);
					for ($l=0;$l<count($nav_titles);$l++) {
						$navigation[]=array("url" => $nav_urls[$l],"title" => trim($nav_titles[$l]));
					}
				}
				$smarty->assign("albums_list",$albums_list);
				$template='photoalbum_main.html';
				break;
			}
		}

}

}

?>