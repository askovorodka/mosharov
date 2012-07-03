<?php

class Form{
	
	function pregReplace($content,$base_path){
			if (preg_match_all('/{form\sid="\d{1,2}"}/',$content,$matches))
				if (is_array($matches))
					foreach ($matches as $key=>$val)
						foreach ($matches[$key] as $key2=>$val2)
							if (preg_match("/\d{1,2}/", $matches[$key][$key2], $submathes)){
								$form_id = intval($submathes[0]);
								$out_form = $this->show_form(array("id"=>$form_id),$base_path);
								if (strlen(trim($out_form))>0)
									$content = str_replace($matches[$key][$key2],$out_form,$content);
							}
				
			return $content;
	}
	
	function show_form ($params,$base_path) {

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

		$output=$smarty->fetch($base_path.'/modules/forms/templates/'.$form_template);
		
		return $output;
		
	}

}

?>