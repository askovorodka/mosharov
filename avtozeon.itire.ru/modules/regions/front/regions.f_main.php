<?php
//$_SESSION['fw_basket']=array();

if ($switch_default=='on' or $main_module=='on') {

	$js[]=BASE_URL.'/modules/shop/front/templates/shop.js';
	$js[]=BASE_URL.'/lib/JsHttpRequest/Js.js';

}
if  ($main_module=='on') {

$css[]=BASE_URL.'/modules/shop/front/templates/shop.css';

require_once 'lib/class.mail.php';
require_once 'lib/class.image.php';
$navigation[]=array("url" => $module_url,"title" => $node_content['name']);
$smarty->assign("module_url",BASE_URL.'/'.$module_url);


$cl=$db->get_all("SELECT * FROM fw_regions c WHERE (c.status='1' AND param_level > 0 AND name <> '/') ORDER BY param_left");


/*--------------------ОТОБРАЖЕНИЕ---------------------*/
//Common::dumper($_SESSION['fw_basket']);
SWITCH (TRUE) {

	CASE (@$url[$n-1]=='get_citys' && @preg_match("/^\?PHPSESSID=[a-z0-9]+\&item=([0-9]+)\&[0-9]+$/",$url[$n]) && isset($_GET['item']) && count($url)==3):

		$page_found=true;
		require_once BASE_PATH."/lib/JsHttpRequest/config.php";
		require_once BASE_PATH."/lib/JsHttpRequest/Php.php";
		$number_found=false;
		$JsHttpRequest =& new Subsys_JsHttpRequest_Php("windows-1251");

    	$val="";
    	$status=1;
    	$result = "SELECT * FROM fw_citys WHERE reg_id=";
    	$cond = " city_id IN (SELECT id FROM fw_citys WHERE reg_id=".$_REQUEST['item']." AND name <> 'Москва')";

    	if (trim($_REQUEST['item'])=='moskow'){
      		$result = "SELECT * FROM fw_metros WHERE city_id=(SELECT id FROM fw_citys WHERE name='".trim($_REQUEST['item'])."')";
      		$cond = " city_id =(SELECT id FROM fw_citys WHERE name='Москва')";
    	}

    	$firms = $db->get_all("SELECT *,(SELECT name FROM fw_citys WHERE id=fw_firms.city_id) as city_name FROM fw_firms WHERE status=1 AND $cond ORDER BY name");

    	$firms=String::unformat_array($firms);
    	if (count($firms)>0){

      		for ($i=0; $i<count($firms);$i++){
        		$val .="<table width=100% cellspacing=0 cellpadding=0 border=0 id=reg_tab>";
        		if ($i==0) $val .= "<tr><td colspan=3><h2 style=margin-bottom:12px;>СПИСОК ФИРМ</h2></td></tr>";
        		$val .= "<tr valign=top>";
        		if (trim($firms[$i]['logo'])!="") $val .= "<td width=1><img src=http://".$_SERVER['HTTP_HOST']."/uploaded_files/firms/".$firms[$i]['logo']." border=0></td>";
        		$val .= "<td width=10></td>";
        		if (trim($firms[$i]['name'])!="") $val .= "<td><strong class=region>".$firms[$i]['name']."</strong> <br>";
        		if (trim($firms[$i]['address'])!="") $val .= "Адрес:&nbsp;г.".$firms[$i]['city_name'].",&nbsp;".$firms[$i]['address']."<br>";
        		if (trim($firms[$i]['email'])!="") $val .= "E-mail:&nbsp;<a href='mailto:".$firms[$i]['email']."'>".$firms[$i]['email']."</a><br>";
        		if (trim($firms[$i]['phone'])!="") $val .= "Телефон/Факс:&nbsp;".$firms[$i]['phone']."<br>";
        		if (trim($firms[$i]['site'])!="") $val .= "Сайт:&nbsp;<a target=_blank href='".$firms[$i]['site']."'>".$firms[$i]['site']."</a><br>";
        		$val .= "</td></tr>";
            	$val .="</table>";
      		}
    	}
    	else
      		$val = "Фирмы для данного региона не загружены";

    	if (trim($_REQUEST['item']) != 'moskow'){
      		$citys = $db->get_all("SELECT * FROM fw_citys WHERE name<>'Москва' AND reg_id=".$_REQUEST['item']);
    	}
    	else
      		$citys = $db->get_all("SELECT * FROM fw_metros WHERE city_id=(SELECT id FROM fw_citys WHERE name='Москва')");

    	$citys=String::unformat_array($citys);
    	if (count($citys)>0){
      		if (trim($_REQUEST['item'])=='moskow')
        		$val2 = "<select style='width : 150px;' name=citys id=citys onChange=void(getMetros2('http://".$_SERVER['HTTP_HOST']."/".$url[$n-2]."'));><option selected>---выберите метро---";
      		else
        		$val2 = "<select style='width : 150px;' name=citys id=citys onChange=void(getMetros('http://".$_SERVER['HTTP_HOST']."/".$url[$n-2]."'));><option selected>---выберите город---";

      		for($i=0;$i<count($citys);$i++){
             	$val2 .= "<option value=".$citys[$i]['id'].">".$citys[$i]['name'];
      		}
      		$val2 .= "</select>";
    	}
    	else
      		$val2 = "<select disabled style='width:150px;' name=citys id=citys onChange=void(getMetros('http://".$_SERVER['HTTP_HOST']."'));><option selected>городов нет";

    	$_RESULT = array("status" =>$status, "val"=>$val, "val2"=>$val2);
		$switch_off_smarty=true;

		echo "<b>REQUEST_URI:</b> ".$_SERVER['REQUEST_URI']."<br>";
		echo "<b>Loader used:</b> ".$JsHttpRequest->LOADER;

	BREAK;


	CASE (@$url[$n-1]=='get_metros' && @preg_match("/^\?PHPSESSID=[a-z0-9]+\&item=([0-9]+)\&[0-9]+$/",$url[$n]) && isset($_GET['item']) && count($url)==3):

		$page_found=true;
		require_once BASE_PATH."/lib/JsHttpRequest/config.php";
		require_once BASE_PATH."/lib/JsHttpRequest/Php.php";
		$number_found=false;
		$JsHttpRequest =& new Subsys_JsHttpRequest_Php("windows-1251");

    $val="";
    $status=1;
    $cond = " id IN (SELECT metro_id FROM fw_firms_metros WHERE city_id=".$_REQUEST['item'].")";

    $firms = $db->get_all("SELECT *,(SELECT name FROM fw_citys WHERE id=fw_firms.city_id) as city_name FROM fw_firms WHERE status=1 AND city_id=".$_REQUEST['item']." ORDER BY name");

    $firms=String::unformat_array($firms);
    if (count($firms)>0){

      for ($i=0; $i<count($firms);$i++){
        $val .="<table width=100% cellspacing=0 cellpadding=0 border=0 id=reg_tab>";
        if ($i==0) $val .= "<tr><td colspan=3><h2 style=margin-bottom:12px;>СПИСОК ФИРМ</h2></td></tr>";
        $val .= "<tr valign=top>";
        if (trim($firms[$i]['logo'])!="") $val .= "<td width=1><img src=http://".$_SERVER['HTTP_HOST']."/uploaded_files/firms/".$firms[$i]['logo']." border=0></td>";
        $val .= "<td width=10></td>";
        if (trim($firms[$i]['name'])!="") $val .= "<td><strong class=region>".$firms[$i]['name']."</strong> <br>";
        if (trim($firms[$i]['address'])!="") $val .= "Адрес:&nbsp;г.".$firms[$i]['city_name'].",&nbsp;".$firms[$i]['address']."<br>";
        if (trim($firms[$i]['email'])!="") $val .= "E-mail:&nbsp;<a href='mailto:".$firms[$i]['email']."'>".$firms[$i]['email']."</a><br>";
        if (trim($firms[$i]['phone'])!="") $val .= "Телефон/Факс:&nbsp;".$firms[$i]['phone']."<br>";
        if (trim($firms[$i]['site'])!="") $val .= "Сайт:&nbsp;<a target=_blank href='".$firms[$i]['site']."'>".$firms[$i]['site']."</a><br>";
        $val .= "</td></tr>";
            $val .="</table>";
      }

    }
    else
      $val = "Фирмы для данного города не загружены";

    //$metros = $db->get_all("SELECT * FROM fw_metros WHERE status=1 AND $cond");
	$metros = $db->get_all("SELECT * FROM fw_metros WHERE status=1 AND city_id='".$_REQUEST['item']."'");
    $metros=String::unformat_array($metros);
    if (count($metros)>0){
      $val2 = "<select style='width:150px;' name=metros id=metros onChange=void(getFirms('http://".$_SERVER['HTTP_HOST']."/".$url[$n-2]."'));><option selected>---выберите метро---";
      for($i=0;$i<count($metros);$i++){
             $val2 .= "<option value=".$metros[$i]['id'].">".$metros[$i]['name'];
      }
      $val2 .= "</select>";
    }
    else
      $val2 = "<select disabled style='width:150px;' name=metros id=metros onChange=void(getFirms('http://".$_SERVER['HTTP_HOST']."/".$url[$n-2]."'));><option selected>метро нет";

    	$_RESULT = array("status" =>$status, "val"=>$val, "val2"=>$val2);
		$switch_off_smarty=true;

		echo "<b>REQUEST_URI:</b> ".$_SERVER['REQUEST_URI']."<br>";
		echo "<b>Loader used:</b> ".$JsHttpRequest->LOADER;

	BREAK;


	CASE (@$url[$n-1]=='get_metros2' && @preg_match("/^\?PHPSESSID=[a-z0-9]+\&item=([0-9]+)\&[0-9]+$/",$url[$n]) && isset($_GET['item']) && count($url)==3):

		$page_found=true;
		require_once BASE_PATH."/lib/JsHttpRequest/config.php";
		require_once BASE_PATH."/lib/JsHttpRequest/Php.php";
		$number_found=false;
		$JsHttpRequest =& new Subsys_JsHttpRequest_Php("windows-1251");

    $val="";
    $status=1;
    $cond = " id IN (SELECT metro_id FROM fw_firms_metros WHERE city_id=".$_REQUEST['item'].")";

    $firms = $db->get_all("SELECT *,(SELECT name FROM fw_citys WHERE id=fw_firms.city_id) as city_name FROM fw_firms WHERE status=1 AND id IN (SELECT firm_id FROM fw_firms_metros WHERE metro_id=".$_REQUEST['item'].") ORDER BY name");

    $firms=String::unformat_array($firms);
    if (count($firms)>0){

      for ($i=0; $i<count($firms);$i++){
        $val .="<table width=100% cellspacing=0 cellpadding=0 border=0 id=reg_tab>";
        if ($i==0) $val .= "<tr><td colspan=3><h2 style=margin-bottom:12px;>СПИСОК ФИРМ</h2></td></tr>";
        $val .= "<tr valign=top>";
        if (trim($firms[$i]['logo'])!="") $val .= "<td width=1><img src=http://".$_SERVER['HTTP_HOST']."/uploaded_files/firms/".$firms[$i]['logo']." border=0></td>";
        $val .= "<td width=10></td>";
        if (trim($firms[$i]['name'])!="") $val .= "<td><strong class=region>".$firms[$i]['name']."</strong> <br>";
        if (trim($firms[$i]['address'])!="") $val .= "Адрес:&nbsp;г.".$firms[$i]['city_name'].",&nbsp;".$firms[$i]['address']."<br>";
        if (trim($firms[$i]['email'])!="") $val .= "E-mail:&nbsp;<a href='mailto:".$firms[$i]['email']."'>".$firms[$i]['email']."</a><br>";
        if (trim($firms[$i]['phone'])!="") $val .= "Телефон/Факс:&nbsp;".$firms[$i]['phone']."<br>";
        if (trim($firms[$i]['site'])!="") $val .= "Сайт:&nbsp;<a target=_blank href='".$firms[$i]['site']."'>".$firms[$i]['site']."</a><br>";
        $val .= "</td></tr>";
            $val .="</table>";
      }

    }
    else
      $val = "Фирмы для данного города не загружены";

    $metros = $db->get_all("SELECT * FROM fw_metros WHERE status=1 AND $cond");
    $metros=String::unformat_array($metros);
    if (count($metros)>0){
      $val2 = "<select style='width:150px;'  name=metros id=metros onChange=void(getFirms('http://".$_SERVER['HTTP_HOST']."/".$url[$n-2]."'));><option selected>---выберите метро---";
      for($i=0;$i<count($metros);$i++){
             $val2 .= "<option value=".$metros[$i]['id'].">".$metros[$i]['name'];
      }
      $val2 .= "</select>";
    }
    else
      $val2 = "<select disabled style='width:150px;' name=metros id=metros onChange=void(getFirms('http://".$_SERVER['HTTP_HOST']."/".$url[$n-2]."'));><option selected>";

    	$_RESULT = array("status" =>$status, "val"=>$val, "val2"=>$val2);
		$switch_off_smarty=true;

		echo "<b>REQUEST_URI:</b> ".$_SERVER['REQUEST_URI']."<br>";
		echo "<b>Loader used:</b> ".$JsHttpRequest->LOADER;

	BREAK;


	CASE (@$url[$n-1]=='get_firms' && @preg_match("/^\?PHPSESSID=[a-z0-9]+\&item=([0-9]+)\&[0-9]+$/",$url[$n]) && isset($_GET['item']) && count($url)==3):

		$page_found=true;
		require_once BASE_PATH."/lib/JsHttpRequest/config.php";
		require_once BASE_PATH."/lib/JsHttpRequest/Php.php";
		$number_found=false;
		$JsHttpRequest =& new Subsys_JsHttpRequest_Php("windows-1251");

    $val="";
    $status=1;
    $cond = " id IN (SELECT firm_id FROM fw_firms_metros WHERE metro_id=".$_REQUEST['item'].")";

    $firms = $db->get_all("SELECT *,(SELECT name FROM fw_citys WHERE id=fw_firms.city_id) as city_name FROM fw_firms WHERE status=1 AND $cond ORDER BY name");

    $firms=String::unformat_array($firms);
    if (count($firms)>0){

      for ($i=0; $i<count($firms);$i++){
        $val .="<table width=100% cellspacing=0 cellpadding=0 border=0 id=reg_tab>";
        if ($i==0) $val .= "<tr><td colspan=3><h2 style=margin-bottom:12px;>СПИСОК ФИРМ</h2></td></tr>";
        $val .= "<tr valign=top>";
        if (trim($firms[$i]['logo'])!="") $val .= "<td width=1><img src=http://".$_SERVER['HTTP_HOST']."/uploaded_files/firms/".$firms[$i]['logo']." border=0></td>";
        $val .= "<td width=10></td>";
        if (trim($firms[$i]['name'])!="") $val .= "<td><strong class=region>".$firms[$i]['name']."</strong> <br>";
        if (trim($firms[$i]['address'])!="") $val .= "Адрес:&nbsp;г.".$firms[$i]['city_name'].",&nbsp;".$firms[$i]['address']."<br>";
        if (trim($firms[$i]['email'])!="") $val .= "E-mail:&nbsp;<a href='mailto:".$firms[$i]['email']."'>".$firms[$i]['email']."</a><br>";
        if (trim($firms[$i]['phone'])!="") $val .= "Телефон/Факс:&nbsp;".$firms[$i]['phone']."<br>";
        if (trim($firms[$i]['site'])!="") $val .= "Сайт:&nbsp;<a target=_blank href='".$firms[$i]['site']."'>".$firms[$i]['site']."</a><br>";
        $val .= "</td></tr>";
            $val .="</table>";
      }

    }
    else
      $val = "Фирмы для данного метро не загружены";

    	$_RESULT = array("status" =>$status, "val"=>$val, "val2"=>$val2);
		$switch_off_smarty=true;

		echo "<b>REQUEST_URI:</b> ".$_SERVER['REQUEST_URI']."<br>";
		echo "<b>Loader used:</b> ".$JsHttpRequest->LOADER;

	BREAK;



	DEFAULT:

		$reg_list=String::unformat_array($cl);
		$moskow = $db->get_single("SELECT * FROM fw_citys WHERE name='Москва'");
		if ($moskow['id']>0){
			$i = count($reg_list);
            $reg_list[$i]['id']='moskow';
            $reg_list[$i]['name']=$moskow['name'];
		}
		unset($url[0]);


		for($j=count($reg_list)-1; $j=0; $j--){
			$floor[] = $reg_list[$j];
		}
		$smarty->assign("reg_list",$reg_list);
		$smarty->assign("regions",1);
		$smarty->assign("base_url",BASE_URL);

		$template='regions.f_main.html';
        $page_found=true;
   BREAK;


}

}

?>