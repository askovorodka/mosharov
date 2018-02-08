<?php
require_once "lib/class.db.php";
require_once "lib/JsHttpRequest/Php.php";
require_once 'conf/globals.php';

$db=new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

switch ($_REQUEST["action"])
{
  case "get_products":
    $val="";
    $status=1;
    $products = $db->get_all("SELECT id,name FROM fw_products WHERE product_type=".$_REQUEST['item']);
    if (count($products)>0){
    	$val = "<select onChange=void(sel(this,'http://".$_SERVER['HTTP_HOST']."')); name=product style='width : 222px;'><option selected>выберите товар";
    }
  	else{  		$val = "<select name=product style='width : 222px;' disabled><option selected>товары не найдены";  	}
    for($i=0; $i<count($products);$i++){    	$val .= "<option value='". $products[$i]['name'] ."'>". $products[$i]['name'] ."</option>";    }
    $val .= "</select>";
    $JsHttpRequest =& new Subsys_JsHttpRequest_Php("windows-1251");
    $_RESULT = array("status" =>$status, "val"=>$val);
    $switch_off_smarty=true;

  break;
}
//$db->close_connect();
?>