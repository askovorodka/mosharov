<?php

if (($switch_default=='on' or $switch_support=='on') && $main_module!='on') {
	
	require_once 'lib/class.mail.php';

	$smarty->register_function("form", "show_form");

	function show_form ($params) {

		global $db;
		global $smarty;
		
		$form_id=$params['id'];
		
		if (!isset($params['template'])) $form_template='main.html';
		else $form_template=$params['template'];
		
		$form=$db->get_single("SELECT *, (SELECT COUNT(id) FROM fw_forms_elements WHERE parent=f.id) as elements FROM fw_forms as f WHERE id='$form_id' AND status='1'");
		$elements=$db->get_all("SELECT * FROM fw_forms_elements WHERE parent='$form_id' AND status='1' ORDER BY sort_order");
	
		foreach($elements as $k => $v) {
			if (substr($v['name'],0,1)=="*" && substr($v['name'],-1)=="*") {
				$n = substr($v['name'],1,-1);
				if ($v['type']!="0") $elements[$k]['name'] = array('name' => $n);
				else $elements[$k]['name'] = $n;
			}

			if ($v['type']=="3") {
				$elements[$k]['value']=explode("\r\n", $v['value']);
				foreach ($elements[$k]['value'] as $key => $value) {
					if (substr($value,0,1)=="*" && substr($value,-1)=="*") {
						$elements[$k]['value'][$key] = array('name' => substr($value,1,-1));
					}
				}
			}
		}

		$smarty->assign("form",$form);
		$smarty->assign("elements",$elements);

		$output=$smarty->fetch(BASE_PATH.'/modules/forms/templates/'.$form_template);
		
		return $output;
		
	}
	
	if (isset($_POST['element'])) {
		foreach ($_POST['submit_form_id'] as $key => $value) {
			$form=$db->get_single("SELECT * FROM fw_forms WHERE id='".$key."' AND status='1'");
			if ($form['email']!='') {
				$elements=$db->get_all("SELECT * FROM fw_forms_elements WHERE parent='".$key."' AND status='1' ORDER BY sort_order");
	
				$values_array = array();
	
				foreach ($_POST['element'][$key] as $k1 => $v1) {
					$values_array[$k1] = $v1;
				}
	
				foreach($elements as $k => $v) {
					if (substr($v['name'],0,1)=="*" && substr($v['name'],-1)=="*") $elements[$k]['name'] = substr($v['name'],1,-1);
					if ($v['type']==0) $elements[$k]['value']="";
					else $elements[$k]['value']=nl2br($values_array[$v['id']]);
				}
				
				$smarty->assign("form",$form);
				$smarty->assign("elements",$elements);
	
				$body=$smarty->fetch(BASE_PATH.'/modules/forms/templates/mail.txt');
	
				if (Mail::send_mail($form['email'],ADMIN_MAIL,"Заполнена форма на сайте",$body,'','html','standard','Windows-1251'))
					$smarty->assign("result_text","Форма успешно отправлена. Спасибо.");
				else 
					$smarty->assign("result_text","Произошла ошибка при отправлении формы. Повторите, пожалуйста, ввод.");
			}
		}
	}
	
}

?>