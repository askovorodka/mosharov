<?php

$navigation[]=array("url" => BASE_URL."/admin/?mod=modules","title" => 'Модули сайта');

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

if (isset($_POST['submit_edit_module'])) {
	
	Common::check_priv("$priv");
	
	if (!isset($_POST['edit_module_status'])) $status='1';
	else $status=$_POST['edit_module_status'];
	$priv=$_POST['edit_module_priv'];
	if (isset($_POST['edit_module_default'])) $default=$_POST['edit_module_default'];
	else $default='0';
	
	$result=$db->query("UPDATE fw_modules SET status='$status',priv='$priv',default_load='$default',title='".mysql_real_escape_string($_POST['edit_module_title'])."' WHERE name='".$_POST['edit_module_name']."'");
	$db->query("UPDATE fw_tree SET status='$status' WHERE module='".$_POST['edit_module_name']."'");
	
	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
}

if ($action=='delete') {
	
	Common::check_priv("$priv");
	
	$id=$_GET['id'];
	
	$result=$db->get_single("SELECT name FROM fw_modules WHERE id='$id'");
	
	$db->query("DELETE FROM fw_modules WHERE id='$id'");
	$db->query("DELETE FROM fw_tree WHERE module='".$result['name']."'");
	$db->query("DELETE FROM fw_conf WHERE section='".$result['name']."'");

	header ("Location: ?mod=modules");
	die();
}

if ($action=="change_mod_status" && isset($_GET['id'])) {
  $id=intval($_GET['id']);
  $db->query("UPDATE fw_modules SET status=IF(status='0','1','0') WHERE id='".$id."'");

  $location=$_SERVER['HTTP_REFERER'];
  header ("Location: $location");
  die();
}

SWITCH (TRUE) {

	CASE ($action=='install'):
	
		Common::check_priv("$priv");

		if (isset($_GET['step'])) $step=$_GET['step'];
		else $step='0';

		$navigation[]=array("url" => BASE_URL."/admin/?mod=modules&action=install","title" => 'Установить модуль');

		if ($step=='2') {

			$module_name=$_GET['module_name'];
			$ready_to_install=true;
			
			$module_files=array();
			$sql_install='';
			
			$result=$db->get_single("SELECT id FROM fw_modules WHERE name='$module_name'");
			if (isset($result['id'])) {
				$ready_to_install=false;
				$smarty->assign("module_exists",'1');
			}

			if (file_exists(BASE_PATH."/modules/".$module_name)) $cat_checked='1';
			else {
				$cat_checked='0';
				$ready_to_install=false;
			}
			$checked_files[]=array(
							"file"=>$module_name."/",
							"checked"=>$cat_checked
						);

			if (file_exists(BASE_PATH."/modules/".$module_name."/".$module_name.".sql")) $sql_checked='1';
			else {
				$sql_checked='0';
				$ready_to_install=false;
			}
			$checked_files[]=array(
							"file"=>$module_name."/install.sql",
							"checked"=>$sql_checked
						);

			if (file_exists(BASE_PATH."/modules/".$module_name."/conf.php")) $conf_checked='1';
			else {
				$conf_checked='0';
				$ready_to_install=false;
			}
			$checked_files[]=array(
							"file"=>$module_name."/conf.php",
							"checked"=>$conf_checked
						);

			if ($conf_checked=='1') include BASE_PATH.'/modules/'.$module_name.'/conf.php';

			for ($i=0;$i<count($module_files);$i++) {
				if (file_exists(BASE_PATH."/".$module_files[$i])) $checked='1';
				else {
					$checked='0';
					$ready_to_install=false;
				}
				$checked_files[]=array(
								"file"=>$module_files[$i],
								"checked"=>$checked
								);
			}

			if (!$ready_to_install) {
				$smarty->assign("status","failed");
			}
			else {

				$sql_file=file(BASE_PATH."/modules/".$module_name."/".$module_name.".sql");
				for ($s=0;$s<count($sql_file);$s++){
					$result=$db->query($sql_file[$s]);
				}
				if ($result) {
					$smarty->assign("status","success");
					$sql_install="1";
				}
				else $smarty->assign("status","failed");
			}

			$smarty->assign("checked_files",$checked_files);
			$smarty->assign("sql_install",$sql_install);
			$smarty->assign("step","2");
		}

		$template="modules.a_install.html";

	BREAK;

	CASE ($action=='edit' && isset($_GET['name'])):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=mods&action=edit","title" => 'Редактировать модуль');
		
		$module_name=$_GET['name'];

		if (file_exists(BASE_PATH."/modules/".$module_name)) $cat_checked='1';
		else $cat_checked='0';
		$checked_files[]=array(
							"file"=>"modules/".$module_name."/",
							"checked"=>$cat_checked
						);

		if (file_exists(BASE_PATH."/modules/".$module_name."/conf.php")) $conf_checked='1';
		else $conf_checked='0';
		$checked_files[]=array(
							"file"=>"modules/".$module_name."/conf.php",
							"checked"=>$conf_checked
						);

		if ($conf_checked=='1') include '../modules/'.$module_name.'/conf.php';

		for ($i=0;$i<count($module_files);$i++) {
			if (file_exists(BASE_PATH."/".$module_files[$i])) $checked='1';
			else $checked='0';
			$checked_files[]=array(
							"file"=>$module_files[$i],
							"checked"=>$checked
							);
		}

		$template="modules.a_edit.html";
		
/*
		for ($i=0;$i<count($priv_value);$i++) {
			if ($priv_value[$i]>=$_SESSION['fw_user']['priv']) {
				$priv_list[$i]['value']=$priv_value[$i];
				$priv_list[$i]['name']=$priv_name[$i];
			}
		}
*/		
		$priv_list=$db->get_all("SELECT *, priv as value FROM fw_users_groups WHERE priv>='".$_SESSION['fw_user']['priv']."'");

		$smarty->assign("module",$db->get_single("SELECT * FROM fw_modules WHERE name='$module_name'"));
		$smarty->assign("checked_files",$checked_files);
		$smarty->assign("version",$module_version);
		$smarty->assign("priv_list",$priv_list);

	BREAK;

	DEFAULT:
		$smarty->assign("modules",$db->get_all("SELECT * FROM fw_modules ORDER BY section"));

}

?>