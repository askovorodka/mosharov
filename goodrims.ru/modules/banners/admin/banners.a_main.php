<?php

require_once '../lib/class.image.php';

$navigation[]=array("url" => BASE_URL."/admin/?mod=banners","title" => 'Баннеры');

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

/*------------------------- ВЫПОЛНЯЕМ РАЗЛИЧНЫЕ ДЕЙСТВИЯ ---------------------*/

if (isset($_POST['submit_add_banner'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$name=String::secure_format($_POST['name']);
	$group=String::secure_format($_POST['group']);
	$url=String::secure_format($_POST['url']);
	
	$type=String::secure_format($_POST['type']);
	$showings=String::secure_format($_POST['showings']);
	
	if ((strlen(trim($_POST['start_Month']))>0) && (strlen(trim($_POST['start_Day']))>0) && (strlen(trim($_POST['start_Year']))>0)){
		$start_date = mktime(0,0,0,$_POST['start_Month'],$_POST['start_Day'],$_POST['start_Year']);
		$end_date = mktime(0,0,0,$_POST['end_Month'],$_POST['end_Day'],$_POST['end_Year']);
	}
	
	/*if ($_POST['start_date']!='' && $_POST['end_date']!='') {
		list($s_day,$s_month,$s_year)=explode(".",$_POST['start_date']);
		list($e_day,$e_month,$e_year)=explode(".",$_POST['end_date']);
		
		$start_date=mktime(0,0,0,$s_month,$s_day,$s_year);
		$end_date=mktime(0,0,0,$e_month,$e_day,$e_year);
		
	}*/
	else {
		$start_date=0;
		$end_date=0;
	}
	
	$status=intval($_POST['status']);
	
	if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='') {
		
		$file_name=$_FILES['image']['name'];
		$tmp=$_FILES['image']['tmp_name'];
		
		$trusted_formats=explode(",",'gif,jpg,jpeg,swf,png');
		
		$output=Image::image_details($tmp);
	
		$check_file_name=explode(".",$file_name);
		$ext=$check_file_name[count($check_file_name)-1];
		
		if (!in_array($output['format'],$trusted_formats)) {
			$smarty->assign("error","Разрешены картинки форматов gif,jpg,jpeg,swf");
			$check=false;
		}
	}
	else $ext='';

	if ($check) {
		
		$result=$db->query("INSERT INTO fw_banners (name,`group`,target_url,type,showings,start_date,end_date,status,image) VALUES('$name','$group','$url','$type','$showings','$start_date','$end_date','$status','$ext')");
		
		//echo "INSERT INTO fw_banners (name,`group`,target_url,type,showings,start_date,end_date,status,image) VALUES('$name','$group','$url','$type','$showings','$start_date','$end_date','$status','$ext')"; exit();
		
		$id=mysql_insert_id();
	
		if (isset($file_name) && $file_name!='') {
			if (move_uploaded_file($tmp, BASE_PATH.'/uploaded_files/banners/'.$id.'.'.$ext)) {
				chmod(BASE_PATH.'/uploaded_files/banners/'.$id.'.'.$ext, 0644);
			}
		}
		
		if (isset($_POST['edit_banners_cat'])) {
			
			$dealer_cat=$_POST['edit_banners_cat'];
			$values='';
			foreach ($dealer_cat as $k=>$v) {
				$values.="($id,'$v'),";
			}
			$values=substr($values,0,-1);
			
			$db->query("DELETE FROM fw_banners_cat WHERE banner_id='$id'");
			
			$db->query("INSERT INTO fw_banners_cat(banner_id,url) VALUES $values");
		}
		
		$location='index.php?mod=banners&action=edit_banner&id='.$id;
		header("Location: $location");
	}
}

if ($action=='delete_group' && isset($_GET['id'])) {
	
	$id=$_GET['id'];
	$db->query("DELETE FROM fw_banners_groups WHERE id='$id'");
	
	header ("Location: ?mod=banners&action=groups_list");
	die();
}


if ($action=='delete' && isset($_GET['id'])) {
	
	Common::check_priv("$priv");
	
	$id=$_GET['id'];
	$db->query("DELETE FROM fw_banners WHERE id='$id'");
	foreach (glob(BASE_PATH."/uploaded_files/banners/$id.*") as $filename) {
		unlink($filename);
	}
	
	header ("Location: ?mod=banners");
	die();
}

if (isset($_POST['submit_edit_banner'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$id=$_POST['id'];
	
	$name=String::secure_format($_POST['name']);
	$group=String::secure_format($_POST['group']);
	$url=String::secure_format($_POST['url']);
	
	$type=String::secure_format($_POST['type']);
	$showings=String::secure_format($_POST['showings']);
	
	/*if ($_POST['start_date']!='' && $_POST['end_date']!='') {
		list($s_day,$s_month,$s_year)=explode(".",$_POST['start_date']);
		list($e_day,$e_month,$e_year)=explode(".",$_POST['end_date']);
		
		$start_date=mktime(0,0,0,$s_month,$s_day,$s_year);
		$end_date=mktime(0,0,0,$e_month,$e_day,$e_year);
	}*/
	if ((strlen(trim($_POST['start_Month']))>0) && (strlen(trim($_POST['start_Day']))>0) && (strlen(trim($_POST['start_Year']))>0)){
		$start_date = mktime(0,0,0,$_POST['start_Month'],$_POST['start_Day'],$_POST['start_Year']);
		$end_date = mktime(0,0,0,$_POST['end_Month'],$_POST['end_Day'],$_POST['end_Year']);
	}
	
	else {
		$start_date=0;
		$end_date=0;
	}
	
	$status=intval($_POST['status']);
	
	if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='') {
		
		$file_name=$_FILES['image']['name'];
		$tmp=$_FILES['image']['tmp_name'];
		
		$trusted_formats=explode(",",'gif,jpg,jpeg,application/x-shockwave-flash');
		
		$output=Image::image_details($tmp);
	
		$check_file_name=explode(".",$file_name);
		$ext=$check_file_name[count($check_file_name)-1];

		if (!in_array($output['format'],$trusted_formats)) {
			$check=false;
		}
	}
	else $ext=$_POST['old_ext'];
	
	if (isset($_POST['delete_image'])) {
		foreach (glob(BASE_PATH."/uploaded_files/banners/$id.*") as $filename) {
			unlink($filename);
		}
		$ext='';
	}

	if ($check) {

		$db->query("UPDATE fw_banners SET
											name='$name',
											`group`='$group',
											target_url='$url',
											type='$type',
											showings='$showings',
											status='$status',
											start_date='$start_date',
											end_date='$end_date',
											image='$ext'
										WHERE id='$id'");
	
		if (isset($file_name) && $file_name!='') {
			if (move_uploaded_file($tmp, BASE_PATH.'/uploaded_files/banners/'.$id.'.'.$ext)) {
				chmod(BASE_PATH.'/uploaded_files/banners/'.$id.'.'.$ext, 0644);
			}
		}
		

		$db->query("DELETE FROM fw_banners_cat WHERE banner_id='$id'");

		if (isset($_POST['edit_banners_cat'])) {
			
			$dealer_cat=$_POST['edit_banners_cat'];

			$values='';
			foreach ($dealer_cat as $k=>$v) {
				$values.="($id,'$v'),";
			}
			$values=substr($values,0,-1);
			
			$db->query("INSERT INTO fw_banners_cat(banner_id,url) VALUES $values",1);
		}

		$location='index.php?mod=banners&action=edit_banner&id='.$id;
		header("Location: $location");
	}
}

if (isset($_POST['submit_add_group'])) {
	
	Common::check_priv("$priv");
	
	$name=String::secure_user_input($_POST['name']);
	
	$db->query("INSERT INTO fw_banners_groups(name) VALUES('$name')");
	
	$location='index.php?mod=banners&action=groups_list';
	header ("Location: $location");
	die();
	
}

if (isset($_POST['submit_edit_group'])) {
	
	Common::check_priv("$priv");
	
	$name=String::secure_user_input($_POST['name']);
	$id=String::secure_user_input($_POST['id']);
	
	$db->query("UPDATE fw_banners_groups SET name='$name' WHERE id='$id'");
	
	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
	
}

/*--------------------------------- ОТОБРАЖЕНИЕ ------------------------------*/

SWITCH (TRUE) {
	
	CASE ($action=='groups_list'):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=banners&action=groups_list","title" => 'Группы баннеров');
		
		if (isset($_GET['page'])) $page=$_GET['page'];
		else $page=1;
	
		$result=$db->query("SELECT COUNT(*) FROM fw_banners_groups");
		$pager=Common::pager($result,BANNERS_PER_PAGE,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		
		$groups_list=$db->get_all("SELECT * FROM fw_banners_groups LIMIT ".$pager['limit']);
		
		$smarty->assign("groups_list",$groups_list);
		$template='banners.a_groups_list.html';
	
	BREAK;
	
	CASE ($action=='add_group'):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=banners&action=groups_list","title" => 'Группы баннеров');
		$navigation[]=array("url" => BASE_URL."/admin/?mod=banners&action=add","title" => 'Добавить группу');
		
		$smarty->assign("mode","add");
		$template='banners.a_edit_group.html';
	
	BREAK;
	
	CASE ($action=='edit_group' && isset($_GET['id'])):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=banners&action=groups_list","title" => 'Группы баннеров');
		$navigation[]=array("url" => BASE_URL."/admin/?mod=banners&action=edit","title" => 'Редактировать группу');
		
		$id=$_GET['id'];
		
		$group=$db->get_single("SELECT * FROM fw_banners_groups WHERE id='$id'");
		$smarty->assign("group",$group);
		
		$smarty->assign("mode","edit");
		$template='banners.a_edit_group.html';
	
	BREAK;
	
	CASE ($action=='add_banner'):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=banners&action=add","title" => 'Добавить кампанию');
		
		$smarty->assign("groups_list",$db->get_all("SELECT * FROM fw_banners_groups"));
		
		$cl=Common::generate_main_menu();
		
		$smarty->assign("cat_checkboxes",$cl);
		$smarty->assign("curdate",time());
		$smarty->assign("curdate2",time());
		$smarty->assign("cat_checked",array());
		
		$smarty->assign("mode","add");
		$template='banners.a_edit.html';
	
	BREAK;
	
	CASE ($action=='edit_banner' && isset($_GET['id'])):
	
		$id=$_GET['id'];
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=banners","title" => 'Редактировать кампанию');
		
		$banner=$db->get_single("SELECT * FROM fw_banners WHERE id='$id'");

		$smarty->assign("groups_list",$db->get_all("SELECT * FROM fw_banners_groups"));
		
		if ($banner['type']=='1' && $banner['image']!='') {
			
			$output=Image::image_details(BASE_PATH.'/uploaded_files/banners/'.$banner['id'].'.'.$banner['image']);
			
			$smarty->assign("width",$output['width']);
			$smarty->assign("height",$output['height']);
		}
		
		$smarty->assign("curdate",$banner['start_date']);
		$smarty->assign("curdate2",$banner['end_date']);
		$smarty->assign("banner",$banner);
		
		$cc=$db->get_all("SELECT url FROM fw_banners_cat WHERE banner_id='$id'");
		$cat_checked=array();
		foreach ($cc as $k=>$v) {
			$cat_checked[]=$v['url'];
		}
		
		$cl=Common::generate_main_menu();
		
		$smarty->assign("cat_checkboxes",$cl);
		$smarty->assign("cat_checked",$cat_checked);

		$smarty->assign("mode","edit");
		$template='banners.a_edit.html';
	
	BREAK;
	
	
	DEFAULT:
	
		if (isset($_GET['page'])) $page=$_GET['page'];
		else $page=1;
	
		$result=$db->query("SELECT COUNT(*) FROM fw_banners");
		$pager=Common::pager($result,BANNERS_PER_PAGE,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		
		$banners_list=$db->get_all("SELECT * FROM fw_banners LIMIT ".$pager['limit']);
		if (count($banners_list)>0) $smarty->assign("banners_list",$banners_list);


}

?>