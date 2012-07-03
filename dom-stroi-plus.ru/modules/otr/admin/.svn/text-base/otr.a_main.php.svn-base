<?php

require_once '../lib/class.image.php';

$navigation[]=array("url" => BASE_URL."/admin/?mod=news","title" => 'Отраслевые решения');

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

/*------------------------- ВЫПОЛНЯЕМ РАЗЛИЧНЫЕ ДЕЙСТВИЯ ---------------------*/

if (isset($_POST['submit_add_otr'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$title=String::secure_format($_POST['edit_otr_title']);
	$small_text=String::secure_format($_POST['edit_otr_small_text']);
	$text=String::secure_format($_POST['edit_otr_text']);
	
	
	if ($check) {
	
		$result=$db->query("INSERT INTO fw_otr (title,small_text,text) VALUES('$title','$small_text','$text')");
		if ($result) { 
			$smarty->assign("success_message","Решение успешно добавлено!");
		}
	}
}

if ($action=='delete' && isset($_GET['id'])) {
	
	Common::check_priv("$priv");
	
	$id=$_GET['id'];
	$db->query("DELETE FROM fw_otr WHERE id='$id'");
	header ("Location: index.php?mod=otr");
	die();
}

if (isset($_POST['submit_edit_otr'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$id=$_POST['id'];
	$title=String::secure_format($_POST['edit_otr_title']);
	$small_text=String::secure_format($_POST['edit_otr_small_text']);
	$text=String::secure_format($_POST['edit_otr_text']);
	
	if ($check) {
		$smarty->assign("success_message","Решение успешно отредактировано!");
		
		$result=$db->query("UPDATE fw_otr SET title='$title',small_text='$small_text',text='$text' WHERE id='$id'");
	}
}

/*--------------------------------- ОТОБРАЖЕНИЕ ------------------------------*/

SWITCH (TRUE) {
	
	CASE ($action=='add'):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=otr&action=add","title" => 'Добавить решение');
		
		$smarty->assign("mode","add");
		$template='otr.a_edit.html';
	
	BREAK;
	
	CASE ($action=='edit' && isset($_GET['id'])):
	
		$id=$_GET['id'];
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=otr","title" => 'Редактировать решение');
		
		$otr=$db->get_single("SELECT * FROM fw_otr WHERE id='$id'");
		$otr=String::unformat_array($otr);
		$smarty->assign("otr",$otr);
		
		$smarty->assign("mode","edit");
		$template='otr.a_edit.html';
	
	BREAK;
	
	
	DEFAULT:
	
		if (isset($_GET['page'])) $page=$_GET['page'];
		else $page=1;
	
		$result=$db->query("SELECT COUNT(*) FROM fw_otr");
		$pager=Common::pager($result,OTR_PER_PAGE,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		
		$otr_list=$db->get_all("SELECT * FROM fw_otr ORDER BY title ASC LIMIT ".$pager['limit']);
		$otr_list=String::unformat_array($otr_list);
		if (count($otr_list)>0) $smarty->assign("otr_list",$otr_list);


}

?>
