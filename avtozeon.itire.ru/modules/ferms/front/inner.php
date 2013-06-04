<?php


require_once "lib/class.db.php";
require_once "lib/JsHttpRequest/Php.php";
require_once 'conf/globals.php';

$db=new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

switch ($_REQUEST["action"])
{
  case "get_products":

    $status=1;
  	$number_found=false;
  	/*$product=$db->get_single("SELECT id,parent,name,price,sale FROM fw_products WHERE id='".$_REQUEST['item']."' AND status='1'");

    for ($i=0;$i<count($_SESSION['fw_basket']);$i++) {
      if ($_SESSION['fw_basket'][$i]['id']==$product['id']) {
        $_SESSION['fw_basket'][$i]['number'] = $_SESSION['fw_basket'][$i]['number']+$_REQUEST['count'];
        $number_found=true;
      }
    }

    if (!$number_found) {

      if (intval($_REQUEST["count"])>0)
        $product['number'] = $_REQUEST["count"];
      else
        $product['number'] = 1;

      $_SESSION["fw_basket"][] = $product;
    }

    */

    $JsHttpRequest =& new Subsys_JsHttpRequest_Php("windows-1251");
    $_RESULT = array("status" =>$status);
    $switch_off_smarty=true;

  break;
}
//$db->close_connect();
?>