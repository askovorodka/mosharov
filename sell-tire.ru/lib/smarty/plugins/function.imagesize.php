<?php

function smarty_function_imagesize($params) {

	$output=Image::image_details($params['file']);
	
	$result=$output['width'].'x'.$output['height'];
	return $result;
}


?>