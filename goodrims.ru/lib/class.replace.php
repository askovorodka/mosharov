<?php

class Replace {

	function getReplace($search, $replace, $source){
    	foreach ($search as $key=>$val){    		$source = preg_replace($search[$key],$replace,$source);    	}
    	return $source;
	}

}

?>