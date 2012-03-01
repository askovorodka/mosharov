<?php

require_once '../lib/class.image.php';

$navigation[]=array("url" => BASE_URL."/admin/?mod=news","title" => 'Новости');

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

$news_years_list=$db->get_all("SELECT YEAR(FROM_UNIXTIME(publish_date)) AS year FROM fw_news GROUP BY year ORDER BY publish_date DESC");
$smarty->assign("news_years_list", $news_years_list);

if (!isset($year) || $_GET['year']=='') {
	$where="1";
}
else {
	$where="YEAR(FROM_UNIXTIME(publish_date))='".$year."'";
	$limit="";
	$smarty->assign("year", $year);
}

/*------------------------- ВЫПОЛНЯЕМ РАЗЛИЧНЫЕ ДЕЙСТВИЯ ---------------------*/

if ($action=="change_status" && isset($_GET['id'])) {
	$id=intval($_GET['id']);
	$db->query("UPDATE fw_news SET status=IF(status='0','1','0') WHERE id='".$id."'");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
}

if (isset($_POST['submit_add_news'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$title=String::secure_format($_POST['edit_news_title']);
	$small_text=String::secure_format($_POST['edit_news_small_text']);
	$text=String::secure_format($_POST['edit_news_text']);
	$lang=String::secure_format($_POST['lang']);
	$status="1";
	
	if ($_FILES['edit_news_image']['name']!='') {
		
		$file_name=$_FILES['edit_news_image']['name'];
		$tmp=$_FILES['edit_news_image']['tmp_name'];
		
		$trusted_formats=array('jpg','jpeg','gif','png','JPG');
		
		$check_file_name=explode(".",$file_name);
		$ext=$check_file_name[count($check_file_name)-1];
		if (!in_array($ext,$trusted_formats)) {
			$smarty->assign("error_message","Разрешены картинки форматов jpg, jpeg, gif и png");
			$check=false;
		}
		
		/*if (filesize($tmp)>200000000) {
			$smarty->assign("error_message","Размер фотографии не должен привышать 2Mb");
			$check=false;
		}*/
	}
	
	if ($check) {
	
		$result=$db->query("INSERT INTO fw_news (title,small_text,text,status,publish_date, lang) VALUES('$title','$small_text','$text','$status','".time()."', '{$lang}')");
		if ($result) { 
			$smarty->assign("success_message","Новость успешно добавлена!");
			if (@$file_name!='') {
				$id=mysql_insert_id();
				$image_name = md5($id . rand(1,1000)).".".$ext;
				if (move_uploaded_file($tmp, BASE_PATH.'/uploaded_files/news/'.$image_name)) {
					chmod(BASE_PATH.'/uploaded_files/news/'.$image_name, 0777);
					Image::image_resize(BASE_PATH.'/uploaded_files/news/'.$image_name, BASE_PATH.'/uploaded_files/news/resized-'.$image_name,NEWS_IMAGE_WIDTH,NEWS_IMAGE_WIDTH);
					//Image::resize(BASE_PATH.'/uploaded_files/news/'.$image_name, BASE_PATH.'/uploaded_files/news/resized-'.$image_name,NEWS_IMAGE_WIDTH,NEWS_IMAGE_WIDTH);
					unlink(BASE_PATH.'/uploaded_files/news/'.$image_name);
					$result=$db->query("UPDATE fw_news SET image='resized-{$image_name}' WHERE id='".mysql_insert_id()."'");
				}
				header("Location: index.php?mod=news&action=edit&id=".$id);
			}
		}
	}
	

die();
	
}

if ($action=='delete' && isset($_GET['id'])) {
	
	Common::check_priv("$priv");
	
	$id=$_GET['id'];
	$db->query("DELETE FROM fw_news WHERE id='$id'");
	foreach (glob(BASE_PATH.'/uploaded_files/news/'."*".$id.".*") as $filename) {
		unlink($filename);
	}
	header ("Location: index.php?mod=news");
	die();
}

if (isset($_POST['submit_edit_news'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$id=$_POST['id'];
	$title=String::secure_format($_POST['edit_news_title']);
	$small_text=String::secure_format($_POST['edit_news_small_text']);
	$text=String::secure_format($_POST['edit_news_text']);
	$status=String::secure_format($_POST['edit_news_status']);
	$lang=String::secure_format($_POST['lang']);
	
	$time=mktime($_POST['edit_news_date_hour'],$_POST['edit_news_date_minutes'],0,$_POST['edit_news_date_month'],$_POST['edit_news_date_day'],$_POST['edit_news_date_year']);

	if ($_FILES['edit_news_image']['name']!='') {
	
		$file_name=$_FILES['edit_news_image']['name'];
		$tmp=$_FILES['edit_news_image']['tmp_name'];
		
		$trusted_formats=array('jpg','jpeg','gif','png','JPG');
		
		$check_file_name=explode(".",$file_name);
		$ext=$check_file_name[count($check_file_name)-1];
		if (!in_array($ext,$trusted_formats)) {
			$smarty->assign("error_message","Разрешены картинки форматов jpg, jpeg, gif и png");
			$check=false;
		}
		
		/*if (filesize($tmp)>200000000)
		{
			$smarty->assign("error_message","Размер фотографии не должен привышать 2Mb");
			$check=false;
		}*/
	}
	
	if ($check) {
		$smarty->assign("success_message","Новость успешно отредактирована!");
		if (@$file_name!='')
		{
			$image_name = md5($id . rand(1,1000)).'.'.$ext;
			if (move_uploaded_file($tmp, BASE_PATH.'/uploaded_files/news/'.$image_name)) {
				chmod(BASE_PATH.'/uploaded_files/news/'.$image_name,0644);
				Image::image_resize(BASE_PATH.'/uploaded_files/news/'.$image_name,BASE_PATH.'/uploaded_files/news/resized-'.$image_name,NEWS_IMAGE_WIDTH,NEWS_IMAGE_WIDTH);
				unlink(BASE_PATH.'/uploaded_files/news/'.$image_name);
			}
			$image='resized-'.$image_name;
		}
		else $image=$_POST['old_image'];
		
		if (isset($_POST['delete_image'])) {
			$image='';
			unlink(BASE_PATH.'/uploaded_files/news/'.$_POST['old_image']);
		}
		$result=$db->query("UPDATE fw_news SET lang='{$lang}', title='$title',small_text='$small_text',text='$text',status='$status',publish_date='$time',image='$image' WHERE id='$id'");
	}
}

/*--------------------------------- ОТОБРАЖЕНИЕ ------------------------------*/

SWITCH (TRUE) {
	
	CASE ($action=='add'):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=news&action=add","title" => 'Добавить новость');
		
		$smarty->assign("mode","add");
		$template='news.a_edit.html';
	
	BREAK;
	
	CASE ($action=='edit' && isset($_GET['id'])):
	
		$id=$_GET['id'];
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=news","title" => 'Редактировать новость');
		
		$news=$db->get_single("SELECT * FROM fw_news WHERE id='$id'");
		$news=String::unformat_array($news);
		$smarty->assign("news",$news);
		
		$smarty->assign("mode","edit");
		$template='news.a_edit.html';
	
	BREAK;
	
	
	DEFAULT:
	
		if (isset($_GET['page'])) $page=$_GET['page'];
		else $page=1;
		
		if (isset($_GET['year']) && intval($_GET['year'])>0)
			$cond = " WHERE YEAR(FROM_UNIXTIME(publish_date))='".$_GET['year']."' ";
		else
			$cond = "";
	
		$result=$db->query("SELECT COUNT(*) FROM fw_news $cond");
		$pager=Common::pager($result,NEWS_PER_PAGE,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		
		$news_list=$db->get_all("SELECT * FROM fw_news $cond ORDER BY publish_date DESC LIMIT ".$pager['limit']);
		$news_list=String::unformat_array($news_list);
		if (count($news_list)>0) $smarty->assign("news_list",$news_list);


}

?>