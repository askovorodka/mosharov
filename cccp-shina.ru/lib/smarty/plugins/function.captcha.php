<?php
/*
	Published by Pavlos Stamboulides under GPL2
	pavlos@psychology.deletethis.gr
*/

require_once('captcha.class.php');


function smarty_function_captcha($params, &$smarty){
	$length = ((int)$params['length'])? (int)$params['length']: 4;
	$name = ($params['name'])? $params['name'] : 'captcha';
	$font = realpath ($smarty->template_dir) . "/arial.ttf" ;
	$tempfolder = "P:/home/link.su/www/uploaded_files";
	
	$c = new Captcha($length);
	$code = $c->GenStr();
	$c->font = $font ;
	$salted = md5($code . CAPTCHA_SALT . 'some salt' . $code .CAPTCHA_SALT . 'extra salt');
	
	$code = $c->Generate("$tempfolder/$salted.png");
	return "<img src=\"captcha.php?cap=$salted\"><INPUT TYPE=HIDDEN NAME=\"$name\" value=\"$salted\">";

}


?>