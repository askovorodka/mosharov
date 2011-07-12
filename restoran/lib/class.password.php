<?php

class Password {

	function generate(){

    	$d=Array("ba", "be", "bo", "di", "du", "do", 
    	"de", "ku", "ka", "ke", "si", "su", "re", 
    	"ru", "ro", "ra", "la", "le", "li", "lo", 
    	"ve", "zde", "ka", "av", "ko", "ab", "ce", "lj", "ly",
    	"ss", "ze");

    	$str="";

    	for ($i=0;$i<rand(3,4);$i++)
      		$str.=$d[rand(0,count($d))];

    	return $str;

  }
  

	function replaceMailContent($params, $template){
		if (is_array($params)){
			foreach ($params as $key=>$val){
				$template = str_replace($key,$val,$template);
			}
		}
		return $template;
	}

}
?>