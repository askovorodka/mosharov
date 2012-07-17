<?php 
	
	error_reporting(E_ALL);
	ini_set('display_errors','On');
	echo "Iconv: " . iconv('utf-8','windows-1251',"test");
	
?>