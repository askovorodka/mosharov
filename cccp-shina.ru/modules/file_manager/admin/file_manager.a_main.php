<?php

Common::check_priv("$priv");

$navigation[]=array("url" => '?mod=file_manager',"title" => 'Файл менеджер');

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

if (isset($_GET['dir']) && $_GET['dir']!='') $dir=$_GET['dir'];
else $dir='';

if (isset($_POST['submit_edit_file'])) {
	
	Common::check_priv("$priv");

	$file=fopen($_POST['file_to_edit'],'w');

	if ($file) {
		$text_to_insert=str_replace("\r\n","\n",$_POST['edit_file_text']);

		fwrite($file,stripslashes($text_to_insert));
		$smarty->assign("message","Файл успешно отредактирован");
	}
	else {
		$smarty->assign("message","Файл не был отредактирован");
	}

	fclose($file);
}


SWITCH (TRUE) {

	CASE ($action=='edit' && isset($_GET['file'])):
	
	Common::check_priv("$priv");

		$navigation[]=array("url" => "?mod=file_manager&action=edit","title" => 'Редактировать файл', "type"=>"mod");

		$file_to_edit=file_get_contents(BASE_PATH.$_GET['file']);

		$file=explode("/",$_GET['file']);
		$file=$file[count($file)-1];
		$extention=explode(".",$file);
		$extention=$extention[count($extention)-1];

		if ($extention!='html' && $extention!='htm' && $extention!='txt' && $_SESSION['fw_user']['priv']>0) $smarty->assign("edit_error","Вы не можете редактировать файлы этого типа");

		$template="file_manager.a_edit.html";
		$smarty->assign("editing_file",BASE_PATH.$_GET['file']);
		$smarty->assign("file_to_edit",$file_to_edit);

	BREAK;

	DEFAULT:
	
	Common::check_priv("$priv");

		$root_dir = BASE_PATH;

		$current_dir=$root_dir;
		
		if (stristr($dir,'..')) die ("А вот этого не надо.");

		if ($dir!='') $current_dir=$root_dir.$dir;

		if ($dir!='') {
			$dir_part=explode("/",$dir);
			if ($dir_part<2) $prev_dir='';
			else {
				unset($dir_part[count($dir_part)-1]);
				$prev_dir=implode("/",$dir_part);
			}
		}

		$dir_handler = opendir($current_dir);
		while (false !== ($current_file = readdir($dir_handler))) {
			if ($current_file!='.') {
				$cd=getcwd();
				if ($current_file=='..' && $dir=='') {
				}
				else {
		
					$current_file_list[] = array(
								"file_name"=>$current_file,
								"file_size"=>filesize($current_dir."/".$current_file),
								"file_type"=>filetype($current_dir."/".$current_file)
							);
				}
			}
		}
		$smarty->assign("current_file_list",$current_file_list);
		$smarty->assign("current_dir",$dir);
		$smarty->assign("prev_dir",@$prev_dir);


}


?>