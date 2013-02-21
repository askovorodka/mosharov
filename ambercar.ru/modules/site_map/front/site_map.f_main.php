<?php

$navigation[]=array("url" => $module_url,"title" => "Карта сайта");

/*--------------------ОТОБРАЖЕНИЕ---------------------*/

if ($main_module=='on' || !$page_found) {
	SWITCH (TRUE){
		
		CASE ($url[$n] == 'xml'):
		
			$page_found = true;
		break;
		
		DEFAULT:
			
			$page_found=true;
	
			$content=Common::generate_main_menu();
			
			/*$catalog = $shop->getCategories(1);
			foreach ($catalog as $key=>$val)
			{
				$catalog[$key]['padding'] = $catalog[$key]['param_level'] * 10;
				$catalog[$key]['full_url'] = $shop->getFullUrlCategory($catalog[$key]['id']);
			}*/
			
//			unset($content[0]);
			$smarty->assign("tree",$content);
			//$smarty->assign("catalog",$catalog);
			$template='site_map_main.html';
	}
}

?>