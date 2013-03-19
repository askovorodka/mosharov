<?php

class MyArray {
	
	function unset_element($array,$element) {
		
		$new_array=array();
		
		unset($array[$element]);
		
		foreach ($array as $k=>$v) {
			$new_array[]=$v;
		}
		
		return $new_array;
		
	}
	
	static function insert_array_into_array($array, $input_array, $modulename) {
		
		foreach ($array as $key => $value) {
			if ($value['module']==$modulename) {
				$array_position = $key;
				break;
			}
		}
		if (isset($array_position)) {
			$array[$array_position]['sublist'] = $input_array;
		}
		return $array;
	}
	
	function random_from_array($array) {
		return $array[rand(0, count($array)-1)];
	}
	
}


?>