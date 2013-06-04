<?php
require_once 'http://'.$_SERVER['HTTP_HOST']."/lib/class.db.php";
require_once 'http://'.$_SERVER['HTTP_HOST']."/lib/JsHttpRequest/Php.php";
require_once 'http://'.$_SERVER['HTTP_HOST'].'/conf/globals.php';

$db=new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

switch ($_REQUEST["action"])
{
  case "get_citys":
    $val="";
    $status=1;
    $firms = $db->get_all("SELECT * FROM fw_firms WHERE status=1 ORDER BY name");

    /*if (count($products)>0){
    	$val = "<select onChange=void(sel(this,'http://".$_SERVER['HTTP_HOST']."')); name=product style='width : 222px;'><option selected>выберите товар";
    }
  	else{  		$val = "<select name=product style='width : 222px;' disabled><option selected>товары не найдены";  	}
    for($i=0; $i<count($products);$i++){    	$val .= "<option value='". $products[$i]['name'] ."'>". $products[$i]['name'] ."</option>";    }
    $val .= "</select>";*/
    $firms=String::unformat_array($firms);
    $val = count($firms);
    $JsHttpRequest =& new Subsys_JsHttpRequest_Php("windows-1251");
    $_RESULT = array("status" =>$status, "val"=>$val);
    $switch_off_smarty=true;

  break;
}
//$db->close_connect();
?>