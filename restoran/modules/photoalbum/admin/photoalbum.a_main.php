<?php

require_once '../lib/class.tree.php';
require_once '../lib/class.image.php';

/* DB TREE VARIABLES */
$table='fw_photoalbum_cat';
$id_name='id';
$field_names = array(
   'left' => 'param_left',
   'right'=> 'param_right',
   'level'=> 'param_level',
);

$tree=new CDBTree($db, $table, $id_name, $field_names);
$nodes_list=$db->get_all("SELECT * FROM fw_tree ORDER BY param_left");

$navigation[]=array("url" => BASE_URL."/admin/?mod=photoalbum","title" => 'Фотоальбом');

$cat_list=$db->get_all("SELECT *,(SELECT COUNT(*) FROM fw_photoalbums WHERE parent=p.id) AS albums FROM fw_photoalbum_cat p ORDER BY param_left");
$cat_list=String::unformat_array($cat_list);

$smarty->assign("photos_folder",PHOTOS_FOLDER);

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

/*--------------------------- ВНУТРЕННИЕ ФУНКЦИИ МОДУЛЯ ----------------------*/


if ($action=="change_cat_status" && isset($_GET['id'])) {
	$id=intval($_GET['id']);
	$db->query("UPDATE fw_photoalbum_cat SET status=IF(status='0','1','0') WHERE id='".$id."'");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
}

function delete_photoalbum($albums) {
	
	global $db;
	
	$albums_id='';
	
	foreach ($albums as $k=>$v) {
		$albums_id.=$v.',';
	}
	$albums_id=substr($albums_id,0,-1);
	
	$photos=$db->get_all("SELECT id,ext FROM fw_photoalbum_images WHERE parent IN ($albums_id)");
	
	foreach ($photos as $k=>$v) {
		$files_to_delete[]=$v['id'].'.'.$v['ext'];
		$files_to_delete[]='small-'.$v['id'].'.'.$v['ext'];
		$files_to_delete[]='medium-'.$v['id'].'.'.$v['ext'];
	}
	
	$db->query("DELETE FROM fw_photoalbum_images WHERE parent IN ($albums_id)");
	$db->query("DELETE FROM fw_photoalbums WHERE id IN ($albums_id)");
	
	foreach ($files_to_delete as $k=>$v) {
		unlink(BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$v);
	}
	
}


/*------------------------- ВЫПОЛНЯЕМ РАЗЛИЧНЫЕ ДЕЙСТВИЯ ---------------------*/


if (isset($_POST['submit_add_album'])) {
	
	Common::check_priv("$priv");
	
	$parent=$_POST['edit_parent'];
	$name=String::secure_format($_POST['edit_name']);
	$title=String::secure_format($_POST['edit_title']);
	$description=String::secure_format($_POST['edit_description']);
	$meta_keywords=String::secure_format($_POST['edit_meta_keywords']);
	$meta_description=String::secure_format($_POST['edit_meta_description']);
	$cat_id = $_POST['edit_category'];
	$album_type = $_POST['edit_album_type'];
	
	if ($name=='') $name='Новый альбом';
	
	$db->query("INSERT INTO fw_photoalbums(parent,name,title,description,meta_description,meta_keywords,switch_comments,insert_date, album_type) 
	VALUES('$parent','$name','$title','$description','$meta_description','$meta_keywords','$switch_comments','".time()."', '{$album_type}')");
	$id = mysql_insert_id();
	
	if (!empty($cat_id))
	{
		$db->query("insert into fw_photo_categories (photoalbum_id, cat_id) values('{$id}', '{$cat_id}')");
	}
	
	header("Location: ?mod=photoalbum&action=edit_album&id=".$id);
}

if (isset($_POST['submit_edit_album'])) {
	
	Common::check_priv("$priv");
	
	$parent=$_POST['edit_parent'];
	$name=String::secure_format($_POST['edit_name']);
	$title=String::secure_format($_POST['edit_title']);
	$description=String::secure_format($_POST['edit_description']);
	$meta_keywords=String::secure_format($_POST['edit_meta_keywords']);
	$meta_description=String::secure_format($_POST['edit_meta_description']);
	$status=$_POST['edit_status'];
	$cat_id = $_POST['edit_category'];
	$album_type = $_POST['edit_album_type'];
	
	
	if (isset($_POST['edit_comments'])) $switch_comments='1';
	else $switch_comments='0';
	
	$id=$_GET['id'];
	
	$db->query("delete from fw_photo_categories where photoalbum_id = " . $id);
	
	if (!empty($cat_id))
	{
		$db->query("insert into fw_photo_categories (photoalbum_id, cat_id) values('{$id}', '{$cat_id}')");
	}
	
	$db->query("UPDATE fw_photoalbums SET parent='$parent',name='$name',title='$title',description='$description',meta_description='$meta_description',meta_keywords='$meta_keywords',switch_comments='$switch_comments',status='$status', album_type='{$album_type}' WHERE id='$id'");
}

if (isset($_POST['submit_add_photo'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$parent=$_POST['parent'];
	$title=String::secure_format($_POST['add_photo_title']);
	$link=String::secure_format($_POST['add_photo_link']);
	$file_name=$_FILES['add_new_photo']['name'];
	$tmp=$_FILES['add_new_photo']['tmp_name'];
	
	$trusted_formats=explode(",",ALLOWED_FORMATS);
	
	$output=Image::image_details($_FILES['add_new_photo']['tmp_name']);
	
	$check_file_name=explode(".",$file_name);
	$ext=$check_file_name[count($check_file_name)-1];
	
	if (in_array($ext, array('flv','avi', 'mpg', 'mpeg4')))
	{
		$filetype = 'video';
	}
	else
	{
		$filetype='photo';
	}
	//echo ($_FILES['add_new_photo']['size'] / 1024);
	if (!in_array($ext,$trusted_formats)) {
		$smarty->assign("error","Разрешены файлы форматов ".ALLOWED_FORMATS);
		$check=false;
	}
	if ($check)
		echo 1;
	
	//$filesize = intval($_FILES['add_new_photo']['size'] / 1024);
	
	if (!in_array($ext, array('flv','avi', 'mpg', 'mpeg4')))
		list($max_width,$max_height)=explode("x",PHOTO_MAX_SIZE);
	
	$resize_main=false;
	if ($filetype == 'photo')
	{
		if ($output['width']>$max_width or $output['height']>$max_height) {
			$resize_main=true;
		}
	}
	 
	//echo filesize($tmp)<PHOTO_MAX_FILESIZE*1000;
	
	if (filesize($tmp)>PHOTO_MAX_FILESIZE*1000) {
		$smarty->assign("error","Размер файла не должен привышать ".PHOTO_MAX_FILESIZE."Кб");
		$check=false;
	}

	if ($check) {

		$order=$db->get_single("SELECT MAX(sort_order)+1 AS s_order FROM fw_photoalbum_images WHERE parent='$parent'");
		if ($order['s_order']=='') $order=1;
		else $order=$order['s_order'];

		$filesize=round(filesize($tmp)/1000,2);
		$result=$db->query("INSERT INTO fw_photoalbum_images(parent,title,link,ext,sort_order,insert_date) VALUES('$parent','$title','$link','$ext','$order','".time()."')");
		$id=mysql_insert_id();
		//echo move_uploaded_file($tmp, BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$id.'.'.$ext); exit;
		if (move_uploaded_file($tmp, BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$id.'.'.$ext)) {
			chmod(BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$id.'.'.$ext, 0644);
			if ($filetype == 'photo')
			{
				Image::image_resize(BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$id.'.'.$ext,BASE_PATH.'/'.PHOTOS_FOLDER.'/small-'.$id.'.'.$ext,PREVIEW1_WIDTH,PREVIEW1_HEIGTH);
				if ($output['width']>PREVIEW2_WIDTH or $output['height']>PREVIEW2_HEIGHT) Image::image_resize(BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$id.'.'.$ext,BASE_PATH.'/'.PHOTOS_FOLDER.'/medium-'.$id.'.'.$ext,PREVIEW2_WIDTH,PREVIEW2_HEIGTH);
				if ($resize_main) Image::image_resize(BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$id.'.'.$ext,BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$id.'.'.$ext,$max_width,$max_height);
			}
			$smarty->assign("message","Файл успешно загружен");
		}
		else {
			$result=$db->query("DELETE FROM fw_photoalbum_images WHERE id='".mysql_insert_id()."'");
			$smarty->assign("error","Файл не загружен!");
		}
		
		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
	}
	
}

if (isset($_POST['submit_save_photos'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	if (isset($_POST['delete_photos'])) {
		$delete_photos=$_POST['delete_photos'];
		for ($i=0;$i<count($delete_photos);$i++) {
			$values.=$delete_photos[$i];
			if ($i!=count($delete_photos)-1) $values.=',';
			
			foreach (glob(BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$delete_photos[$i].".*") as $filename) {
				unlink($filename);
			}
			foreach (glob(BASE_PATH.'/'.PHOTOS_FOLDER.'/'."*-".$delete_photos[$i].".*") as $filename) {
				unlink($filename);
			}
		}
		$db->query("DELETE FROM fw_photoalbum_images WHERE id IN ($values)");
		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
	}
	
	if (isset($_POST['edit_hit'])) {
	
		$album_id=intval($_GET["id"]);
		
		$db->query("UPDATE fw_photoalbum_images SET hit='0' WHERE parent='".$album_id."'",1);
		$db->query("UPDATE fw_photoalbum_images SET hit='1' WHERE id IN (".implode(",", $_POST['edit_hit']).")",1);
	}
	
	
	if (@in_array('1',$_POST['order_changed'])) {

		$order_changed=array_keys($_POST['order_changed'],"1");
		$order=$_POST['edit_order'];
		
		for ($i=0;$i<count($order_changed);$i++) {
			$new_order=$order[$order_changed[$i]];
			$db->query("UPDATE fw_photoalbum_images SET sort_order='$new_order' WHERE id='".$order_changed[$i]."'");
		}
	}
	
	if (@in_array('1',$_POST['title_changed'])) {

		$title_changed=array_keys($_POST['title_changed'],"1");
		$title=$_POST['edit_title'];
		
		for ($i=0;$i<count($title_changed);$i++) {
			$new_title=String::secure_format($title[$title_changed[$i]]);
			$db->query("UPDATE fw_photoalbum_images SET title='$new_title' WHERE id='".$title_changed[$i]."'");
		}
	}
	
	if (@in_array('1',$_POST['description_changed'])) {

		$description_changed=array_keys($_POST['description_changed'],"1");
		$description=$_POST['edit_description'];
		
		for ($i=0;$i<count($description_changed);$i++) {
			$new_description=String::secure_format($description[$description_changed[$i]]);
			$db->query("UPDATE fw_photoalbum_images SET description='$new_description' WHERE id='".$description_changed[$i]."'");
		}
	}
	
	if (@in_array('1',$_POST['link_changed'])) {

		$link_changed=array_keys($_POST['link_changed'],"1");
		$link=$_POST['edit_link'];
		
		for ($i=0;$i<count($link_changed);$i++) {
			$new_link=$link[$link_changed[$i]];
			$db->query("UPDATE fw_photoalbum_images SET link='$new_link' WHERE id='".$link_changed[$i]."'");
		}
	}
	
	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if (isset($_POST['submit_add_cat'])) {
			
	Common::check_priv("$priv");
	
	$check=true;
	
	$parent=$_POST['edit_cat_parent'];
	$url=String::secure_format($_POST['edit_cat_url']);
	$name=String::secure_format($_POST['edit_cat_name']);
	$title=String::secure_format($_POST['edit_cat_title']);
	$status=$_POST['edit_cat_status'];
	$keywords=String::secure_format($_POST['edit_cat_keywords']);
	$description=String::secure_format($_POST['edit_cat_description']);
	
	if ($name=='') $name="Новая категория";
	
	$check_if_exists=$db->get_all("SELECT id FROM fw_photoalbum_cat WHERE url='$url' AND param_left>(SELECT param_left FROM fw_photoalbum_cat WHERE id='$parent') AND param_right<(SELECT param_right FROM fw_photoalbum_cat WHERE id='$parent') AND param_level=(SELECT param_level FROM fw_photoalbum_cat WHERE id='$parent')");
	if (count($check_if_exists)>0) {
		$smarty->assign("error_message","Категория с таким урлом уже существует!");
		$check=false;
	}
	
	if (!preg_match("/^([a-z0-9_-]+)$/",$url)) {
		$smarty->assign("error_message","В URL допустимы только символы латиницы, минус и знак подчёркивания!");
		$check=false;
	}
	
	if ($check) {
		$tree->insert($parent,array("name"=>$name,"title"=>$title,"url"=>$url,"status"=>$status,"meta_keywords"=>$keywords,"meta_description"=>$description));
		header("Location: index.php?mod=photoalbum&action=cat");
		die();
	}
}

if (isset($_POST['submit_edit_cat'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$id=$_POST['id'];
	$old_url=$_POST['old_url'];
	$old_parent=$_POST['old_parent'];
	
	$parent=$_POST['edit_cat_parent'];
	$url=String::secure_format($_POST['edit_cat_url']);
	$name=String::secure_format($_POST['edit_cat_name']);
	$title=String::secure_format($_POST['edit_cat_title']);
	$status=$_POST['edit_cat_status'];
	$keywords=String::secure_format($_POST['edit_cat_keywords']);
	$description=String::secure_format($_POST['edit_cat_description']);
	
	if ($name=='') $name="Новая безымянная категория";
	
	if ($url!=$old_url or $parent!=$old_parent) {
		$check_if_exists=$db->get_all("SELECT id FROM fw_catalogue WHERE url='$url' AND param_left>(SELECT param_left FROM fw_catalogue WHERE id='$parent') AND param_right<(SELECT param_right FROM fw_catalogue WHERE id='$parent') AND param_level=(SELECT param_level FROM fw_catalogue WHERE id='$parent')");
		if (count($check_if_exists)>0) {
			$smarty->assign("error_message","Узел с таким урлом уже существует!");
			$check=false;
		}
	}
	
	if (!preg_match("/^([a-z0-9_-]+)$/",$url)) {
		$smarty->assign("error_message","В URL допустимы только символы латиницы, минус и знак подчёркивания!");
		$check=false;
	}
	
	if ($check) {
		$db->query("UPDATE fw_photoalbum_cat SET name='$name',title='$title',url='$url',status='$status',meta_keywords='$keywords',meta_description='$description' WHERE id='$id'");
		if ($parent!=$old_parent) {
			$a=array(array('from' => $id,'to' => $parent));
			$move=$tree->move($a,true);

			if($move===false) $move=-2;
		}
	}
	
}

if ($action=='cat_move_up' && isset($_GET['id'])){
	
	Common::check_priv("$priv");

	$id = $_GET['id'];
	
	$a=array(array('from' => $id,'sibling' => true,'left' => true));
			
	$tree->move($a,true);
	
	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();

}

if ($action=='cat_move_down' && isset($_GET['id'])) {
	
	Common::check_priv("$priv");

	$id = $_GET['id'];
			
	$a=array(array('from' => $id,'sibling' => true,'right' => true));
			
	$tree->move($a,true);

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();

}

if ($action=='delete_cat' && isset($_GET['id'])) {
	
	Common::check_priv("$priv");

	$id = $_GET['id'];
			
	$tree->deleteAll($id);

	header ("Location: ?mod=photoalbum&action=cat");
	die();

}

if ($action=="change_album_status" && isset($_GET['id'])) {
	$id=intval($_GET['id']);
	$db->query("UPDATE fw_photoalbums SET status=IF(status='0','1','0') WHERE id='".$id."'");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
}

if ($action=='delete_album' && isset($_GET['id'])) {
	
	Common::check_priv("$priv");

	$id = $_GET['id'];
			
	delete_photoalbum(array($id));

	header ("Location: ?mod=photoalbum&action=albums_list");
	die();

}

if ($action=='delete_previews') {
	
	set_time_limit(0);
	
	Common::check_priv("$priv");
	
	foreach (glob(BASE_PATH."/".PHOTOS_FOLDER."/medium-*.*") as $filename) {
	   unlink ($filename);
	}
	
	foreach (glob(BASE_PATH."/".PHOTOS_FOLDER."/small-*.*") as $filename) {
	   unlink ($filename);
	}
	
	foreach (glob(BASE_PATH."/".PHOTOS_FOLDER."/*.*") as $filename) {
		
		$file=$filename;
	   
		$filename=explode("/",$filename);
		$filename=$filename[count($filename)-1];
		
		if (preg_match("/^[0-9]*\.[a-z]{0,4}$/i",$filename)) {
			
			$output=Image::image_details($file);
			
			Image::image_resize(BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$filename,BASE_PATH.'/'.PHOTOS_FOLDER.'/small-'.$filename,PREVIEW1_WIDTH,PREVIEW1_HEIGTH);
			if ($output['width']>PREVIEW2_WIDTH or $output['height']>PREVIEW2_HEIGHT) Image::image_resize(BASE_PATH.'/'.PHOTOS_FOLDER.'/'.$filename,BASE_PATH.'/'.PHOTOS_FOLDER.'/medium-'.$filename,PREVIEW2_WIDTH,PREVIEW2_HEIGTH);
		}
	}

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if ($action=='delete_comment') {
	
	Common::check_priv("$priv");
	
	$id=$_GET['id'];
	
	$db->query("DELETE FROM fw_photoalbum_comments WHERE id='$id'");
	
	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if (isset($_POST['submit_edit_comment'])) {

	Common::check_priv("$priv");
	
	$id=$_POST['id'];
	
	$author=$_POST['comment_author'];
	$comment=Common::strip_forum_tags($_POST['comment_text']);
	
	$db->query("UPDATE fw_photoalbum_comments SET author='$author',comment='$comment' WHERE id='$id'");
	
	$smarty->assign("refresh_parent",true);
}

/*--------------------------------- ОТОБРАЖЕНИЕ ------------------------------*/

SWITCH (TRUE) {
	
	CASE ($action=='add_album'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=photoalbum&action=add_album","title" => 'Создать альбом');
		
		$cat_list=Common::get_nodes_list($cat_list);

		$smarty->assign("categories",$db->get_all("select * from fw_catalogue where status='1' and param_level='1' order by param_level"));
		$smarty->assign("cat_list",$cat_list);
		$smarty->assign("mode","add");
		$smarty->assign("cat",@$_GET['cat']);
		$template='photoalbum.a_edit_album.html';

	BREAK;
	
	CASE ($action=='edit_album' && isset($_GET['id'])):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=photoalbum&action=edit_album","title" => 'Редактировать альбом');
		
		$id=$_GET['id'];
		
		$cat_list=Common::get_nodes_list($cat_list);
		
		$album=$db->get_single("SELECT * FROM fw_photoalbums WHERE id='$id'");
		$album=String::unformat_array($album);
		
		$photos_list=$db->get_all("SELECT * FROM fw_photoalbum_images WHERE parent='$id' ORDER BY sort_order");
		$photos_list=String::unformat_array($photos_list);
		foreach ($photos_list as $key=>$val)
		{
			if (in_array(strtolower($photos_list[$key]['ext']), array('flv', 'avi', 'mpg', 'mpeg4')))
			{
				$photos_list[$key]['filetype'] = 'video';
			}
			else
			{
				$photos_list[$key]['filetype'] = 'photo';
			}
		}
		$photos_count=count($photos_list);
		
		$rel = $db->get_single("select * from fw_photo_categories where photoalbum_id='{$id}' ");
		
		$smarty->assign("photos_height",PREVIEW1_HEIGTH+10);
		$smarty->assign('photos_list',$photos_list);
		$smarty->assign('photos_count',$photos_count);
		$smarty->assign("cat_list",$cat_list);
		$smarty->assign("rel",$rel);
		$smarty->assign("categories",$db->get_all("select * from fw_catalogue where status='1' and param_level='1' order by param_level"));
		$smarty->assign("album",$album);
		$smarty->assign("mode","edit");
		$template='photoalbum.a_edit_album.html';
	
	BREAK;
	
	CASE ($action=='add_cat'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=photoalbum&action=add_cat","title" => 'Добавить раздел');

		if (isset($_GET['id'])) $id = $_GET['id'];

		if ($action=='add_cat' && isset($_GET['parent'])) $smarty->assign("parent",$_GET['parent']);

		$template="photoalbum.a_edit_cat.html";

		$smarty->assign("mode","add");
		$smarty->assign("cat_list",Common::get_nodes_list($cat_list));

	BREAK;
	
	CASE ($action=='edit_cat'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=photoalbum&action=edit_cat","title" => 'Редактировать раздел');

		if (isset($_GET['id'])) $id = $_GET['id'];

		$template="photoalbum.a_edit_cat.html";
		
		$parent=$tree->getParent($id);
		
		$cat=$db->get_single("SELECT * FROM fw_photoalbum_cat WHERE id='$id'");
		$cat=String::unformat_array($cat);
		
		$smarty->assign("parent",$parent['id']);
		$smarty->assign("cat",$cat);
		$smarty->assign("mode","edit");
		$smarty->assign("cat_list",Common::get_nodes_list($cat_list));

	BREAK;
	
	CASE ($action=='cat'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=photoalbum&action=cat","title" => 'Разделы фотоальбома');
		
		$cat_list=$db->get_all("SELECT *,(SELECT COUNT(*) FROM fw_photoalbums WHERE parent=t.id) AS albums FROM fw_photoalbum_cat t ORDER BY t.param_left ASC");
		$cat_list=String::unformat_array($cat_list);
		
		$smarty->assign("cat_list",$cat_list);
		
		$template="photoalbum.a_cat_list.html";
		
	BREAK;
	
	CASE ($action=='albums_list'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=photoalbum&action=albums_list","title" => 'Альбомы');
		
		if (isset($_GET['page']) && $_GET['page']!='') $page=$_GET['page'];
		else $page=1;
		
		if (isset($_GET['cat']) && $_GET['cat']>'1') {
	
			if (isset($_GET['cat'])) {
				$temp_cond[]="parent='".$_GET['cat']."'";
				$smarty->assign("cat",$_GET['cat']);
			}
			$cond=Common::get_cond($temp_cond);
		}
		else $cond="";
		
		if (isset($_GET['sort']) && $_GET['sort']!='') {
			$sort='ORDER BY '.$_GET['sort'].' ';
			$smarty->assign("sort",$_GET['sort']);
		}
		else $sort='ORDER BY insert_date ';
		if (isset($_GET['order']) && $_GET['order']!='') {
			$sort.=$_GET['order'];
			$smarty->assign("order",$_GET['order']);
		}
		else $sort.='DESC';
	
		$result=$db->query("SELECT COUNT(*) FROM fw_photoalbums $cond");
		$pager=Common::pager($result,ALBUMS_PER_PAGE,$page);
	
		$albums_list=$db->get_all("SELECT *,(SELECT COUNT(*) FROM fw_photoalbum_images WHERE parent=a.id) AS photos FROM fw_photoalbums a $cond $sort LIMIT ".$pager['limit']);
		$albums_list=String::unformat_array($albums_list);
		
		$cl=Common::get_nodes_list($cat_list);
		
		for ($i=0;$i<count($albums_list);$i++) {
			for($k=0;$k<count($cl);$k++) {
				if ($albums_list[$i]['parent']==$cl[$k]['id']) {
					$albums_list[$i]['cat_title']=$cl[$k]['full_title'];
					break;
				}
			}
		}
		
		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("cat_list",$cl);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		$smarty->assign("albums_list",$albums_list);
		
		$template="photoalbum.a_albums_list.html";
		
	BREAK;
	
	CASE ($action=='mini_browser' ):
	
		if (isset($_GET['album_id'])) {
			
			if (isset($_GET['page']) && $_GET['page']!='') $page=$_GET['page'];
			else $page=1;
			
			$album_id=$_GET['album_id'];
			
			$result=$db->query("SELECT COUNT(*) FROM fw_photoalbum_images WHERE parent='$album_id'");
			$pager=Common::pager($result,PHOTOS_PER_PAGE,$page);
			
			$photos_list=$db->get_all("SELECT * FROM fw_photoalbum_images WHERE parent='$album_id' LIMIT ".$pager['limit']);
			
			$smarty->assign("total_pages",$pager['total_pages']);
			$smarty->assign("current_page",$pager['current_page']);
			$smarty->assign("pages",$pager['pages']);
				
			$smarty->assign("total_photos",count($photos_list));

			$smarty->assign("photos_list",String::unformat_array($photos_list,'front'));
			$smarty->assign("album_id",$album_id);
			
			$mode='album';
		}
		else {
			
			if (isset($_GET['page']) && $_GET['page']!='') $page=$_GET['page'];
			else $page=1;
			$result=$db->query("SELECT COUNT(*) FROM fw_photoalbums");
			$pager=Common::pager($result,ALBUMS_PER_PAGE,$page);
		
			$albums_list=$db->get_all("SELECT *,(SELECT COUNT(*) FROM fw_photoalbum_images WHERE parent=a.id) AS photos FROM fw_photoalbums a LIMIT ".$pager['limit']);
			$albums_list=String::unformat_array($albums_list);
			
			$cl=Common::get_nodes_list($cat_list);
			
			for ($i=0;$i<count($albums_list);$i++) {
				for($k=0;$k<count($cl);$k++) {
					if ($albums_list[$i]['parent']==$cl[$k]['id']) {
						$albums_list[$i]['cat_title']=$cl[$k]['full_title'];
						break;
					}
				}
			}
			
			$smarty->assign("total_pages",$pager['total_pages']);
			$smarty->assign("cat_list",$cl);
			$smarty->assign("current_page",$pager['current_page']);
			$smarty->assign("pages",$pager['pages']);
			$smarty->assign("albums_list",$albums_list);
			
			$mode='albums_list';
		}
		
		$smarty->assign("mode",$mode);
		$template='mini_browser.html';
		$template_mode='single';
		
	BREAK;
	
	CASE ($action=='edit_comment'):
	
		Common::check_priv("$priv");

		$id = $_GET['id'];
		
		$comment=$db->get_single("SELECT * FROM fw_photoalbum_comments WHERE id='$id'");
		
		$comment=Common::add_forum_tags($comment);
		
		$smarty->assign("comment",$comment);
	
		$template='edit_comment.html';
		$template_mode='single';
	
	BREAK;
	
	DEFAULT:
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=photoalbum","title" => 'Статистика');
		
		$count=$db->get_single("SELECT COUNT(*) AS cat,(SELECT COUNT(*) FROM fw_photoalbums) AS albums,(SELECT COUNT(*) FROM fw_photoalbum_images) AS images FROM fw_photoalbum_cat");

		$filesize = 0;
		foreach (glob(BASE_PATH."/uploaded_files/photos/*.*") as $filename) {
		   $filesize += filesize($filename);
		}
		
		$count['size'] = number_format($filesize/1024/1024, 2, ',', ' ');
		$smarty->assign("count",$count);
		
		$template="statistics.html";
	
}
?>