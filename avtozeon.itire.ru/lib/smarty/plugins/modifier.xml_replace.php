<?php

function smarty_modifier_xml_replace($string)
{
    
	$string = str_replace("&", "&amp;", $string);
	$string = str_replace(">", "&gt;", $string);
	$string = str_replace("<", "&lt;", $string);
	$string = str_replace("`", "&apos;", $string);
	return $string;
	
}

?>
