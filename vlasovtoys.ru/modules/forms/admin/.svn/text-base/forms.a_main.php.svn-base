<?php

$navigation[]=array("url" => BASE_URL."/admin/?mod=forms","title" => 'Формы отправки');

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

/*------------------------- ВЫПОЛНЯЕМ РАЗЛИЧНЫЕ ДЕЙСТВИЯ ---------------------*/

if ($action=="delete" && isset($_GET['id'])) {
	
	$check=true;
	$id=$_GET['id'];
	
	$db->query("DELETE FROM fw_forms WHERE id='$id'");
	$db->query("DELETE FROM fw_forms_elements WHERE parent='$id'");

	header("Location: ?mod=forms");

}

if ($action=="delete_element" && isset($_GET['id'])) {
	
	$check=true;
	$id=$_GET['id'];
	
	$db->query("DELETE FROM fw_forms_elements WHERE id='$id'");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");

}

if (isset($_POST['submit_add_form'])) {
	
	$check=true;

	$name=String::secure_user_input($_POST['edit_forms_name']);
	$email=String::secure_user_input($_POST['edit_forms_email']);

	if ($check) {

		$db->query("INSERT INTO fw_forms(name,email,status) VALUES('$name','$email','1')");

		$location=$_SERVER['HTTP_REFERER'];
		header("Location: ?mod=forms&action=edit&id=".mysql_insert_id());
	}
}


if (isset($_POST['submit_edit_form'])) {
	
	$check=true;


	$id=intval($_GET['id']);

	if (isset($_POST['edit_form_newelement_name']) && $_POST['edit_form_newelement_name']!='') {
		$parent=$id;
		$name=String::secure_user_input($_POST['edit_form_newelement_name']);
		$type=intval($_POST['edit_form_newelement_type']);
		$value=String::secure_user_input($_POST['edit_form_newelement_value']);
	
		$res=$db->get_single("SELECT MAX(sort_order) as maxim FROM fw_forms_elements WHERE parent='$parent'");
		$sort_order=$res['maxim']+1;
		
		$db->query("INSERT INTO fw_forms_elements (parent,name,type,value,sort_order,status) VALUES ('$parent','$name','$type','$value','$sort_order','1')");
	}

	if (isset($_POST['edit_form_element_name'])) {
		foreach ($_POST['edit_form_element_name'] as $k => $v) {
			$upd = array();
			$upd[] = "name='".String::secure_user_input($_POST['edit_form_element_name'][$k])."'";
			$upd[] = "type='".intval($_POST['edit_form_element_type'][$k])."'";
			if ($_POST['edit_form_element_type'][$k]=="3") $upd[] = "value='".String::secure_user_input($_POST['edit_form_element_value'][$k])."'";
			$upd[] = "sort_order='".intval($_POST['edit_form_element_sort_order'][$k])."'";
			$upd[] = "status='".(isset($_POST['edit_form_element_status'][$k])?"1":"0")."'";
			
			$db->query("UPDATE fw_forms_elements SET ".implode(", ", $upd)." WHERE id='$k'");
		}
	}

	$name=String::secure_user_input($_POST['edit_forms_name']);
	$email=String::secure_user_input($_POST['edit_forms_email']);
	$status=intval($_POST['edit_forms_status']);

	if ($check) {
		
		$db->query("UPDATE fw_forms SET name='$name',email='$email',status='$status' WHERE id='$id'");

		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
	}
}


/*--------------------------------- ОТОБРАЖЕНИЕ ------------------------------*/

SWITCH (TRUE) {
	
	CASE ($action=='add'):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=forms&action=add","title" => 'Добавить форму');
		
		$smarty->assign("mode","add");
		$template='forms.a_edit.html';
	
	BREAK;
	
	CASE ($action=='edit' && isset($_GET['id'])):
	
		$id=$_GET['id'];
		
		$navigation[]=array("url" => BASE_URL."/admin/?mod=forms&action=edit","title" => 'Редактировать форму');
	
		$form=$db->get_single("SELECT * FROM fw_forms WHERE id='$id'");

		$form_elements=$db->get_all("SELECT * FROM fw_forms_elements WHERE parent='$id' ORDER BY sort_order");

		$smarty->assign("form",$form);
		if (count($form_elements)>0) $smarty->assign("form_elements",$form_elements);
		
		$smarty->assign("mode","edit");
		$template='forms.a_edit.html';
	
	BREAK;
	
	CASE ($action=='mini_browser' ):
	
		$forms_list=$db->get_all("SELECT *, (SELECT COUNT(id) FROM fw_forms_elements WHERE parent=f.id) as elements FROM fw_forms as f");
		if (count($forms_list)>0) $smarty->assign("forms_list", $forms_list);
	
		$template='mini_browser.html';
		$template_mode='single';
		
	BREAK;
	
	DEFAULT:
	
		if (isset($_GET['page'])) $page=$_GET['page'];
		else $page=1;
	
		$result=$db->query("SELECT COUNT(*) FROM fw_forms");
		$pager=Common::pager($result,30,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		
		$forms_list=$db->get_all("SELECT *, (SELECT COUNT(id) FROM fw_forms_elements WHERE parent=f.id) as elements FROM fw_forms as f LIMIT ".$pager['limit']);
		if (count($forms_list)>0) $smarty->assign("forms_list",$forms_list);


}

?>