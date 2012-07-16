<?php

function smarty_function_filesize($params) {

	if ($params['unit']=='kb') $div=1000;
	if ($params['unit']=='mb') $div=1000000;
	
	$file=$params['file'];
	$result=round(filesize($file)/$div,2);
	return $result;
}


?>