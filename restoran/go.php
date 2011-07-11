<?php
session_start();

require_once 'conf/globals.php';
require_once 'lib/class.db.php';
require_once 'lib/class.common.php';
require_once 'lib/class.string.php';


/* ------------ ондйкчвюеляъ й аюге дюммшу -------------- */
$db=new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

if (isset($_GET['target'])) {
	
	$id=String::secure_user_input($_GET['target']);
	
	$banner=$db->get_single("SELECT * FROM fw_banners WHERE id='$id'");
	
	if (isset($banner['id'])) {
		
		$db->query("UPDATE fw_banners SET clicks=clicks+1 WHERE id='$id'");
		
		$location=$banner['target_url'];
		header("Location: $location");
		
	}
	else {
		
		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
	}
	
}

?>