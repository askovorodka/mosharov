<?php

require_once '../lib/class.image.php';

$navigation[]=array("url" => BASE_URL."/admin/?mod=questions","title" => 'Вопросы');

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

/*------------------------- ВЫПОЛНЯЕМ РАЗЛИЧНЫЕ ДЕЙСТВИЯ ---------------------*/

if (isset($_POST['submit_add_questions'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$title=String::secure_format($_POST['edit_questions_title']);
	$description=String::secure_format($_POST['edit_questions_description']);
	
	if (trim($title)=="") $check=false;
      if ($check) {
	
		$result=$db->query("INSERT INTO fw_questions (question,description) VALUES('$title','$description')");
		if ($result) { 
			$smarty->assign("success_message","Вопрос успешно добавлен!");
		}
	}
}

if ($action=='delete' && isset($_GET['id'])) {
	
	Common::check_priv("$priv");
	
	$id=$_GET['id'];
	$db->query("DELETE FROM fw_questions WHERE id='$id'");
	header ("Location: index.php?mod=questions");
	die();
}

if (isset($_POST['submit_edit_questions'])) {
	
	Common::check_priv("$priv");
	
	$check=true;
	
	$id=$_POST['id'];
	$title=String::secure_format($_POST['edit_questions_title']);
	$description=String::secure_format($_POST['edit_questions_description']);
	
	
	if ($check) {
		$smarty->assign("success_message","Вопрос успешно отредактирован!");
		
		$result=$db->query("UPDATE fw_questions SET question='$title',description='$description' WHERE id='$id'");
	}
}

/*--------------------------------- ОТОБРАЖЕНИЕ ------------------------------*/

SWITCH (TRUE) {
	
	CASE ($action=='add'):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=questions&action=add","title" => 'Добавить вопрос');
		
		$smarty->assign("mode","add");
		$template='questions.a_edit.html';
	
	BREAK;
	
	CASE ($action=='edit' && isset($_GET['id'])):
	
		$id=$_GET['id'];
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=questions","title" => 'Редактировать вопрос');
		
		$questions=$db->get_single("SELECT * FROM fw_questions WHERE id='$id'");
		$questions=String::unformat_array($questions);
		$smarty->assign("questions",$questions);
		
		$smarty->assign("mode","edit");
		$template='questions.a_edit.html';
	
	BREAK;
	
	
	DEFAULT:
	
		if (isset($_GET['page'])) $page=$_GET['page'];
		else $page=1;
	
		$result=$db->query("SELECT COUNT(*) FROM fw_questions");
		$pager=Common::pager($result,10,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		
		$questions_list=$db->get_all("SELECT *, (SELECT count(id) FROM fw_answers WHERE question_id=fw_questions.id) as count_answers FROM fw_questions ORDER BY id DESC LIMIT ".$pager['limit']);
		$questions_list=String::unformat_array($questions_list);
		if (count($questions_list)>0) $smarty->assign("questions_list",$questions_list);


}

?>
