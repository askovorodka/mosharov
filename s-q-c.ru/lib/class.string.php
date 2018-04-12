<?php
class String {

	function strips($target) {
		if (is_array($target)) {
			foreach($target as $k=>$v) {
				$target[$k]=String::strips($v);
			}
		}
		else $target = stripslashes($target);
		
		return $target;
	}

	static function secure_format ($string) {
		
		if ($string=='') return '';
		else {
		
			$string=trim($string);
			$string=str_replace("&quot;",'"',$string);
			$string=str_replace("&#39;","'",$string);
			$string=mysql_real_escape_string($string);
			
			return $string;
		}
	}
	
	function secure_user_input ($string) {
		
		if ($string=='') return '';
		else {

			$string=trim($string);
			$string=htmlspecialchars($string);
			$string=mysql_real_escape_string($string);

			return $string;
		}
	}
	
	static function unformat ($string) {
		
		if ($string=='') return '';
		else {

			$string=str_replace('"','&quot;',$string);
			$string=str_replace("'",'&#39;',$string);
			
			return $string;
		}
	}
	
	static function unformat_array ($array) {
		
		while (list($key,$value)=each($array)) {
			if (is_array($array[$key])) $array[$key]=String::unformat_array($array[$key]);
			else $array[$key]=String::unformat($array[$key]);
		}
			
		return $array;
	}
	
	function translit($cyr_str) {
		
		$tr = array(
			"�"=>"G","�"=>"YO","�"=>"E","�"=>"YI","�"=>"I",
			"�"=>"i","�"=>"g","�"=>"yo","�"=>"","�"=>"e",
			"�"=>"yi","�"=>"A","�"=>"B","�"=>"V","�"=>"G",
			"�"=>"D","�"=>"E","�"=>"ZH","�"=>"Z","�"=>"I",
			"�"=>"Y","�"=>"K","�"=>"L","�"=>"M","�"=>"N",
			"�"=>"O","�"=>"P","�"=>"R","�"=>"S","�"=>"T",
			"�"=>"U","�"=>"F","�"=>"H","�"=>"TS","�"=>"CH",
			"�"=>"SH","�"=>"SCH","�"=>"","�"=>"YI","�"=>"",
			"�"=>"E","�"=>"YU","�"=>"YA","�"=>"a","�"=>"b",
			"�"=>"v","�"=>"g","�"=>"d","�"=>"e","�"=>"zh",
			"�"=>"z","�"=>"i","�"=>"y","�"=>"k","�"=>"l",
			"�"=>"m","�"=>"n","�"=>"o","�"=>"p","�"=>"r",
			"�"=>"s","�"=>"t","�"=>"u","�"=>"f","�"=>"h",
			"�"=>"ts","�"=>"ch","�"=>"sh","�"=>"sch","�"=>"",
			"�"=>"yi","�"=>"","�"=>"e","�"=>"yu","�"=>"ya"," "=>"",
			"\\"=>"","/"=>"","_"=>"","`"=>"","'"=>"\"","?"=>"","!"=>"",
			")"=>"","("=>"","@"=>"","&"=>"","^"=>"","#"=>"","%"=>"","*"=>"","-"=>""
			);

			return strtr($cyr_str,$tr);

	}

	function Unicode2Charset($str, $charset = 'Windows-1251') { 
		return preg_replace('~&#(?:x([\da-f]+)|(\d+));~ie', 'iconv("UTF-16LE", $charset, pack("v", "$1" ? hexdec("$1") : "$2"))', $str);
	}
}
?>