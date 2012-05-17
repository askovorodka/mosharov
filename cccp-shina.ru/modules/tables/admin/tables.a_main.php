<?php

$navigation[]=array("url" => BASE_URL."/admin/?mod=tables","title" => 'Таблицы');

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

/*------------------------- ВЫПОЛНЯЕМ РАЗЛИЧНЫЕ ДЕЙСТВИЯ ---------------------*/

if ($action=="delete" && isset($_GET['id'])) {
	
	$check=true;
	$id=$_GET['id'];
	
	$db->query("DELETE FROM fw_tables WHERE id='$id'",1);

	header("Location: ?mod=tables");
	
}

if (isset($_POST['submit_add_table'])) {
	
	$check=true;

	$name=$_POST['edit_table_name'];

	$file_name=$_FILES['edit_table_file']['name'];
	$tmp=$_FILES['edit_table_file']['tmp_name'];

	$trusted_formats=array('xls','csv');

	$check_file_name=explode(".",$file_name);
	$ext=$check_file_name[count($check_file_name)-1];
	if (!in_array($ext,$trusted_formats)) {
		$smarty->assign("error_message","Разрешены файлы формата xls и csv");
		$check=false;
	}

	if ($check) {

		$db->query("INSERT INTO fw_tables(name,format) VALUES('$name','$ext')");

		move_uploaded_file($tmp, $module_path.'/files/'.mysql_insert_id().'.'.$ext);
		chmod($module_path.'/images/'.$id.'.'.$ext, 0644);

		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
	}
}


if (isset($_POST['submit_edit_table'])) {
	
	$check=true;

	$name=$_POST['edit_table_name'];
	$id=$_POST['id'];

	if ($_FILES['edit_table_file']['name']!='') {
		$file_name=$_FILES['edit_table_file']['name'];
		$tmp=$_FILES['edit_table_file']['tmp_name'];
	
		$trusted_formats=array('xls','csv');
	
		$check_file_name=explode(".",$file_name);
		$ext=$check_file_name[count($check_file_name)-1];
		if (!in_array($ext,$trusted_formats)) {
			$smarty->assign("error_message","Разрешены файлы формата xls и csv");
			$check=false;
		}
	}
	else $ext=$_POST['old_format'];

	if ($check) {
		
		if ($_FILES['edit_table_file']['name']!='') {
			move_uploaded_file($tmp, $module_path.'/files/'.$id.'.'.$ext);
			chmod($module_path.'/images/'.$id.'.'.$ext, 0644);
		}

		$db->query("UPDATE fw_tables SET name='$name',format='$ext' WHERE id='$id'");

		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
	}
}


/*--------------------------------- ОТОБРАЖЕНИЕ ------------------------------*/

SWITCH (TRUE) {
	
	CASE ($action=='add'):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=tables&action=add","title" => 'Добавить таблицу');
		
		$smarty->assign("mode","add");
		$template='tables.a_edit.html';
	
	BREAK;
	
	CASE ($action=='edit' && isset($_GET['id'])):
	
		$id=$_GET['id'];
		
		$navigation[]=array("url" => BASE_URL."/admin/?mod=tables&action=edit","title" => 'Редактировать таблицу');
	
		$table=$db->get_single("SELECT * FROM fw_tables WHERE id='$id'");
		
		$smarty->assign("table",$table);
		
		$smarty->assign("mode","edit");
		$template='tables.a_edit.html';
	
	BREAK;
	
	CASE ($action=='mini_browser' ):
	
		if (isset($_GET['editor']) && $_GET['editor']!='') $editor=$_GET['editor'];
		else $editor=1;

		$smarty->assign("editor", $editor);

		if (isset($_GET['page']) && $_GET['page']!='') $page=$_GET['page'];
		else $page=1;

		$tables_list=$db->get_all("SELECT * FROM fw_tables");
		if (count($tables_list)>0) $smarty->assign("tables_list", $tables_list);
	
		$smarty->assign("tables_list", $tables_list);
		$template='mini_browser.html';
		$template_mode='single';
		
	BREAK;
	
	DEFAULT:
	
		if (isset($_GET['page'])) $page=$_GET['page'];
		else $page=1;
	
		$result=$db->query("SELECT COUNT(*) FROM fw_tables");
		$pager=Common::pager($result,30,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		
		$tables_list=$db->get_all("SELECT * FROM fw_tables LIMIT ".$pager['limit']);
		if (count($tables_list)>0) $smarty->assign("tables_list",$tables_list);


}

?>