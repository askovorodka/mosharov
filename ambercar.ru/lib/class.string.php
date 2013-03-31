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
	
	public static function unformat ($string) {
		
		if ($string=='') return '';
		else {

			$string=str_replace('"','&quot;',$string);
			$string=str_replace("'",'&#39;',$string);
			
			return $string;
		}
	}
	
	public static function unformat_array ($array) {
		
		while (list($key,$value)=each($array)) {
			if (is_array($array[$key])) $array[$key]=String::unformat_array($array[$key]);
			else $array[$key]=String::unformat($array[$key]);
		}
			
		return $array;
	}
	
	function translit($cyr_str) {
		
		$tr = array(
			"¥"=>"G","¨"=>"YO","ª"=>"E","¯"=>"YI","²"=>"I",
			"³"=>"i","´"=>"g","¸"=>"yo","¹"=>"","º"=>"e",
			"¿"=>"yi","À"=>"A","Á"=>"B","Â"=>"V","Ã"=>"G",
			"Ä"=>"D","Å"=>"E","Æ"=>"ZH","Ç"=>"Z","È"=>"I",
			"É"=>"Y","Ê"=>"K","Ë"=>"L","Ì"=>"M","Í"=>"N",
			"Î"=>"O","Ï"=>"P","Ğ"=>"R","Ñ"=>"S","Ò"=>"T",
			"Ó"=>"U","Ô"=>"F","Õ"=>"H","Ö"=>"TS","×"=>"CH",
			"Ø"=>"SH","Ù"=>"SCH","Ú"=>"","Û"=>"YI","Ü"=>"",
			"İ"=>"E","Ş"=>"YU","ß"=>"YA","à"=>"a","á"=>"b",
			"â"=>"v","ã"=>"g","ä"=>"d","å"=>"e","æ"=>"zh",
			"ç"=>"z","è"=>"i","é"=>"y","ê"=>"k","ë"=>"l",
			"ì"=>"m","í"=>"n","î"=>"o","ï"=>"p","ğ"=>"r",
			"ñ"=>"s","ò"=>"t","ó"=>"u","ô"=>"f","õ"=>"h",
			"ö"=>"ts","÷"=>"ch","ø"=>"sh","ù"=>"sch","ú"=>"",
			"û"=>"yi","ü"=>"","ı"=>"e","ş"=>"yu","ÿ"=>"ya"," "=>"",
			"\\"=>"","/"=>"","_"=>"","`"=>"","'"=>"\"","?"=>"","!"=>"",
			")"=>"","("=>"","@"=>"","&"=>"","^"=>"","#"=>"","%"=>"","*"=>"","-"=>"",
			">" => "after","<" => "before", ">" => "after"
			);

			return strtr($cyr_str,$tr);

	}

	function Unicode2Charset($str, $charset = 'Windows-1251') { 
		return preg_replace('~&#(?:x([\da-f]+)|(\d+));~ie', 'iconv("UTF-16LE", $charset, pack("v", "$1" ? hexdec("$1") : "$2"))', $str);
	}
}
?>