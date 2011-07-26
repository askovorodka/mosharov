<?
session_start();
include("class/captchaZDR.php");

$capt = new captchaZDR;
$_SESSION['UserString'] = $capt->UserString;
$capt->display();
?>
