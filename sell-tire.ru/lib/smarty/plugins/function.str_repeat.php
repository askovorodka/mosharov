<?php

function smarty_function_str_repeat($params) {

	$result=str_repeat($params['str'],$params['num']*$params['mod']);
	return $result;
}


?>