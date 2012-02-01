<?php

require_once '../lib/class.tree.php';
require_once '../lib/class.image.php';

/* DB TREE VARIABLES */
$table='fw_regions';
$id_name='id';
$field_names = array(
   'left' => 'param_left',
   'right'=> 'param_right',
   'level'=> 'param_level',
);

$tree=new CDBTree($db, $table, $id_name, $field_names);
$reg_list=$db->get_all("SELECT *, (SELECT COUNT(*) FROM fw_citys WHERE reg_id=p.id) as citys FROM fw_regions p ORDER BY param_left");
$reg_list=String::unformat_array($reg_list);

$citys_list=$db->get_all("SELECT * FROM fw_citys p ORDER BY name");
$citys_list=String::unformat_array($citys_list);

$navigation[]=array("url" => BASE_URL."/admin/?mod=regions","title" => 'Регионы');
//UPDATE `fw_products` SET sort_order=id-2 WHERE 1
if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

/*------------------------- ВЫПОЛНЯЕМ РАЗЛИЧНЫЕ ДЕЙСТВИЯ ---------------------*/
if (isset($_POST['action']) && $_POST['action']=="resort_order") {
	if (isset($_POST['product']) && isset($_POST['product_prev']) && isset($_POST['parent_cat'])) {
		foreach ($_POST['product'] as $k => $v) {
			if ($_POST['product_prev'][$k]!=$_POST['product'][$k]) {
				if ($_POST['product_prev'][$k] > $_POST['product'][$k]) {
					$db->query("UPDATE fw_products SET sort_order='".$_POST['product'][$k]."' WHERE id='".$k."'",1);
					$db->query("UPDATE fw_products SET sort_order=sort_order+1 WHERE parent='".$_POST['parent_cat']."' AND sort_order>='".$_POST['product'][$k]."' AND id!='".$k."'",1);
					$db->query("UPDATE fw_products SET sort_order=sort_order-1 WHERE parent='".$_POST['parent_cat']."' AND sort_order>'".$_POST['product_prev'][$k]."'",1);
				}
				else {
					$db->query("UPDATE fw_products SET sort_order=sort_order-1 WHERE parent='".$_POST['parent_cat']."' AND id!='".$k."' AND sort_order BETWEEN ".$_POST['product_prev'][$k]." AND ".$_POST['product'][$k],1);
					$db->query("UPDATE fw_products SET sort_order='".($_POST['product'][$k])."' WHERE id='".$k."'",1);
				}
			}
		}

		$location=$_SERVER['HTTP_REFERER'];
		header ("Location: $location");
		die();
	}
}

if (isset($_POST['action']) && $_POST['action']=="move_to") {

	$db->query("UPDATE fw_regions SET parent='".intval($_POST['cat'])."' WHERE id IN (".implode(',',array_keys($_POST['edit_move'])).")");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
}

if ($action=="change_reg_status" && isset($_GET['id'])) {
	$id=intval($_GET['id']);
	$db->query("UPDATE fw_regions SET status=IF(status='0','1','0') WHERE id='".$id."'");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
}

if ($action=="change_firm_status" && isset($_GET['id'])) {
	$id=intval($_GET['id']);
	$db->query("UPDATE fw_firms SET status=IF(status='0','1','0') WHERE id='".$id."'");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
}

if ($action=="change_city_status" && isset($_GET['id'])) {
	$id=intval($_GET['id']);
	$db->query("UPDATE fw_citys SET status=IF(status='0','1','0') WHERE id='".$id."'");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
}

if ($action=="change_metro_status" && isset($_GET['id'])) {
	$id=intval($_GET['id']);
	$db->query("UPDATE fw_metros SET status=IF(status='0','1','0') WHERE id='".$id."'");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
}


if ($action=='delete_reg' && isset($_GET['id'])) {
	$id=intval($_GET['id']);

	$db->query("DELETE FROM fw_regions WHERE id='$id' LIMIT 1");

	header ("Location: ?mod=regions");
	die();
}


if ($action=='delete_city' && isset($_GET['id'])) {
	$id=intval($_GET['id']);

	$db->query("DELETE FROM fw_citys WHERE id='$id' LIMIT 1");

	header ("Location: ?mod=regions&action=citys_list");
	die();
}


if ($action=='delete_metro' && isset($_GET['id'])) {
	$id=intval($_GET['id']);

	$db->query("DELETE FROM fw_metros WHERE id='$id' LIMIT 1");

	header ("Location: ?mod=regions&action=metros_list");
	die();
}

if ($action=='delete_firm' && isset($_GET['id'])) {
	$id=intval($_GET['id']);

	$db->query("DELETE FROM fw_firms WHERE id='$id' LIMIT 1");

	header ("Location: ?mod=regions&action=firms_list");
	die();
}


if (isset($_POST['submit_add_reg'])) {

	Common::check_priv("$priv");

	$check=true;

	$parent=$_POST['edit_reg_parent'];
	//$url=String::secure_format($_POST['edit_cat_url']);
	$name=String::secure_format($_POST['edit_reg_name']);
	//$title=String::secure_format($_POST['edit_cat_title']);
	$status=$_POST['edit_reg_status'];
	//$keywords=String::secure_format($_POST['edit_cat_keywords']);

	if ($name=='') $name="Новая безымянный регион";

/*	$check_if_exists=$db->get_all("SELECT id FROM fw_regions WHERE name='$name AND param_left>(SELECT param_left FROM fw_regions WHERE id='$parent') AND param_right<(SELECT param_right FROM fw_regions WHERE id='$parent') AND param_level=(SELECT param_level FROM fw_regions WHERE id='$parent')");
	if (count($check_if_exists)>0) {
		$smarty->assign("error_message","Регион с таким названием уже существует!");
		$check=false;
	}*/

/*	if (!preg_match("/^([a-z0-9_-]+)$/",$url)) {
		$smarty->assign("error_message","В URL допустимы только символы латиницы, минус и знак подчёркивания!");
		$check=false;
	} */

	if ($check) {
		$tree->insert($parent,array("name"=>$name,"status"=>$status));

		header("Location: index.php?mod=regions");
	}
}

if (isset($_POST['submit_edit_reg'])) {

	Common::check_priv("$priv");

	$check=true;

	$id=$_POST['id'];
	//$old_url=$_POST['old_url'];
	$old_parent=$_POST['old_parent'];

	$parent=$_POST['edit_reg_parent'];
	//$url=String::secure_format($_POST['edit_cat_url']);
	$name=String::secure_format($_POST['edit_reg_name']);


	$status=$_POST['edit_reg_status'];
	$description=String::secure_format($_POST['edit_reg_description']);


	if ($name=='') $name="Новый безымянный регион";

/*	if ($url!=$old_url or $parent!=$old_parent) {
		$check_if_exists=$db->get_all("SELECT id FROM fw_catalogue WHERE url='$url' AND param_left>(SELECT param_left FROM fw_catalogue WHERE id='$parent') AND param_right<(SELECT param_right FROM fw_catalogue WHERE id='$parent') AND param_level=(SELECT param_level FROM fw_catalogue WHERE id='$parent')");
		if (count($check_if_exists)>0) {
			$smarty->assign("error_message","Узел с таким урлом уже существует!");
			$check=false;
		}
	}*/



	if ($check || $id=="1") {

		$db->query("UPDATE fw_regions SET name='$name',description='$description',status='$status' WHERE id='$id'");

		if ($parent!=$old_parent) {
			$a=array(array('from' => $id,'to' => $parent));
			$move=$tree->move($a,true);

			if($move===false) $move=-2;
		}
		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
		die();
	}

}

if (isset($_POST['submit_add_firm'])) {

	Common::check_priv("$priv");
    $check=true;
	$parent=$_POST['edit_parent'];
	$name=String::secure_format($_POST['edit_name']);
	$address=String::secure_format($_POST['edit_address']);
	$email=String::secure_format($_POST['edit_email']);
	$phone=String::secure_format($_POST['edit_phone']);
	$site=String::secure_format($_POST['edit_site']);
	//$description=String::secure_format($_POST['edit_description']);
	//$sort_order=$db->get_single("SELECT MAX(sort_order) FROM fw_products WHERE parent='$parent'");
	//$sort_order=$sort_order[0]+1;


	if ($_FILES['edit_firm_logo']['name']!='') {
		$file_name=$_FILES['edit_firm_logo']['name'];
		$tmp=$_FILES['edit_firm_logo']['tmp_name'];
		$trusted_formats=array('jpg','jpeg','gif','png');

		$check_file_name=explode(".",$file_name);
		$ext=$check_file_name[count($check_file_name)-1];
		if (!in_array($ext,$trusted_formats)) {
			$smarty->assign("error_message","Разрешены картинки форматов jpg, jpeg, gif и png");
			$check=false;
		}

		if (filesize($tmp)>2000000) {
			$smarty->assign("error_message","Размер логотипа не должен привышать 2Mb");
			$check=false;
		}
	}

	if ($name=='') $name='Новая компания';

	if ($check){

		$result=$db->query("INSERT INTO fw_firms(city_id,name,address,email,phone,site) VALUES('$parent','$name','$address','$email','$phone','$site')");
		$id=mysql_insert_id();
		if ($result) {
			$smarty->assign("success_message","Компания успешно добавлена!");
			if (@$file_name!='') {
				$id=mysql_insert_id();
				if (move_uploaded_file($tmp, BASE_PATH.'/uploaded_files/firms/'.$id.'.'.$ext)) {
					chmod(BASE_PATH.'/uploaded_files/firms/'.$id.'.'.$ext, 0644);
					Image::image_resize(BASE_PATH.'/uploaded_files/firms/'.$id.'.'.$ext,BASE_PATH.'/uploaded_files/firms/resized-'.$id.'.'.$ext,66,55);
					unlink(BASE_PATH.'/uploaded_files/firms/'.$id.'.'.$ext);
					$result=$db->query("UPDATE fw_firms SET logo='resized-".$id.".$ext' WHERE id='".mysql_insert_id()."'");
				}
			}
		}

		$db->query("DELETE FROM fw_firms_metros WHERE firm_id=$id");
		if (isset($_POST['METRO']) && is_array($_POST['METRO'])){
			foreach ($_POST['METRO'] as $key=>$val){
				$db->query("INSERT INTO fw_firms_metros (firm_id,metro_id) VALUES ($id,$key)");
			}
		}
		header("Location: ?mod=regions&action=firms_list");
	}
}



if (isset($_POST['submit_edit_firm'])) {

	Common::check_priv("$priv");
    $check=true;
    $id=$_POST['id'];
	$parent=$_POST['edit_parent'];
	$name=String::secure_format($_POST['edit_name']);
	$address=String::secure_format($_POST['edit_address']);
	$email=String::secure_format($_POST['edit_email']);
	$phone=String::secure_format($_POST['edit_phone']);
	$site=String::secure_format($_POST['edit_site']);
	$description=String::secure_format($_POST['edit_description']);
	$status=$_POST['edit_status'];
	//$sort_order=$db->get_single("SELECT MAX(sort_order) FROM fw_products WHERE parent='$parent'");
	//$sort_order=$sort_order[0]+1;

	if ($_FILES['edit_firm_logo']['name']!='') {
		$file_name=$_FILES['edit_firm_logo']['name'];
		$tmp=$_FILES['edit_firm_logo']['tmp_name'];
		$trusted_formats=array('jpg','jpeg','gif','png');

		$check_file_name=explode(".",$file_name);
		$ext=$check_file_name[count($check_file_name)-1];
		if (!in_array($ext,$trusted_formats)) {
			$smarty->assign("error_message","Разрешены картинки форматов jpg, jpeg, gif и png");
			$check=false;
		}

		if (filesize($tmp)>2000000) {
			$smarty->assign("error_message","Размер логотипа не должен привышать 2Mb");
			$check=false;
		}
	}


	if ($name=='') $name='Новая компания';

	if ($check) {
		$smarty->assign("success_message","Компания успешно отредактирована!");
		if (@$file_name!='') {
			if (move_uploaded_file($tmp, BASE_PATH.'/uploaded_files/firms/'.$id.'.'.$ext)) {
				chmod(BASE_PATH.'/uploaded_files/firms/'.$id.'.'.$ext,0644);
				Image::image_resize(BASE_PATH.'/uploaded_files/firms/'.$id.'.'.$ext,BASE_PATH.'/uploaded_files/firms/resized-'.$id.'.'.$ext,66,55);
				unlink(BASE_PATH.'/uploaded_files/firms/'.$id.'.'.$ext);
			}
			$image='resized-'.$id.'.'.$ext;
		}
		else $image=$_POST['old_logo'];

		if (isset($_POST['delete_logo'])) {
			$image='';
			unlink(BASE_PATH.'/uploaded_files/firms/'.$_POST['old_logo']);
		}
		$result=$db->query("UPDATE fw_firms SET city_id='$parent',name='$name',address='$address',logo='$image',email='$email',phone='$phone', site='$site',description='$description',status=$status WHERE id='$id'");
	}

		$db->query("DELETE FROM fw_firms_metros WHERE firm_id=$id");
		if (isset($_POST['METRO']) && is_array($_POST['METRO'])){
			foreach ($_POST['METRO'] as $key=>$val){
				$db->query("INSERT INTO fw_firms_metros (firm_id,metro_id) VALUES ($id,$key)");
			}
		}

		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
		die();

}




if (isset($_POST['submit_add_city'])) {

	Common::check_priv("$priv");

	$parent=$_POST['edit_parent'];
	$name=String::secure_format($_POST['edit_name']);
	$description=String::secure_format($_POST['edit_description']);
	//$sort_order=$db->get_single("SELECT MAX(sort_order) FROM fw_products WHERE parent='$parent'");
	//$sort_order=$sort_order[0]+1;

	if ($name=='') $name='Новая компания';

	$db->query("INSERT INTO fw_citys(reg_id,name,description) VALUES('$parent','$name','$description')");
	header("Location: ?mod=regions&action=edit_city&id=".mysql_insert_id());
}


if (isset($_POST['submit_edit_city'])) {

	Common::check_priv("$priv");

	$parent=$_POST['edit_parent'];
	$name=String::secure_format($_POST['edit_name']);
	$description=String::secure_format($_POST['edit_description']);
	$status=String::secure_format($_POST['edit_status']);

	$id=$_POST['id'];

	$db->query("UPDATE fw_citys SET reg_id='$parent',status='$status',name='$name',description='$description',status='$status' WHERE id='$id'");
}


if (isset($_POST['submit_add_metro'])) {

	Common::check_priv("$priv");

	$parent=$_POST['edit_parent'];
	$name=String::secure_format($_POST['edit_name']);
	$description=String::secure_format($_POST['edit_description']);
	//$sort_order=$db->get_single("SELECT MAX(sort_order) FROM fw_products WHERE parent='$parent'");
	//$sort_order=$sort_order[0]+1;

	if ($name=='') $name='Новое метро';

	$db->query("INSERT INTO fw_metros(city_id,name,description) VALUES('$parent','$name','$description')");
	header("Location: ?mod=regions&action=edit_metro&id=".mysql_insert_id());
}

if (isset($_POST['submit_edit_metro'])) {

	Common::check_priv("$priv");

	$parent=$_POST['edit_parent'];
	$name=String::secure_format($_POST['edit_name']);
	$description=String::secure_format($_POST['edit_description']);
	$status=String::secure_format($_POST['edit_status']);

	$id=$_POST['id'];

	$db->query("UPDATE fw_metros SET city_id='$parent',status='$status',name='$name',description='$description',status='$status' WHERE id='$id'");
}


if ($action=='reg_move_up' && isset($_GET['id'])){

	Common::check_priv("$priv");

	$id = $_GET['id'];

	$a=array(array('from' => $id,'sibling' => true,'left' => true));

	$tree->move($a,true);

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();

}

if ($action=='reg_move_down' && isset($_GET['id'])) {

	Common::check_priv("$priv");

	$id = $_GET['id'];

	$a=array(array('from' => $id,'sibling' => true,'right' => true));

	$tree->move($a,true);

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();

}


if (isset($_POST['edit_status'])) {

	Common::check_priv("$priv");

	$id=$_POST['id'];
	$status=$_POST['edit_status'];

	$db->query("UPDATE fw_orders SET status='$status' WHERE id='$id'");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if ($action=='delete_city') {

	Common::check_priv("$priv");

	$id = $_GET['id'];

	$db->query("DELETE FROM fw_citys WHERE id='$id'");

	header ("Location: ?mod=regions&action=citys_list");
	die();

}




/*--------------------------------- ОТОБРАЖЕНИЕ ------------------------------*/

SWITCH (TRUE) {

	CASE ($action=='add_reg'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=regions&action=add_reg","title" => 'Добавить регион');

		$smarty->assign("mode","add");
		$smarty->assign("parent",$_GET['parent']);
		$smarty->assign("reg_list",Common::get_nodes_list($reg_list));
		$template='regions.a_edit.html';

	BREAK;

	CASE ($action=='edit_reg' && isset($_GET['id'])):

		$id=$_GET['id'];

		$navigation[]=array("url" => BASE_URL."/admin/?mod=regions&action=edit_reg","title" => 'Редактировать регион');

		$parent=$tree->getParent($id);

		$reg=$db->get_single("SELECT * FROM fw_regions WHERE id='$id'");
		$reg=String::unformat_array($reg);

		$smarty->assign("parent",$parent['id']);
		$smarty->assign("reg",$reg);
		$smarty->assign("mode","edit");
		$smarty->assign("reg_list",Common::get_nodes_list($reg_list));
		$template='regions.a_edit.html';

	BREAK;

	CASE ($action=='citys_list'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=regions&action=citys_list","title" => 'Города');


		if (isset($_GET['page']) && $_GET['page']!='') $page=$_GET['page'];
		else $page=1;

		if (isset($_GET['reg']) && $_GET['reg']!='') {
			$sort_reg=$_GET['reg'];
		}

		if ((isset($sort_reg)) or (isset($_GET['search']) && $_GET['search']>'1')) {

			if (isset($sort_reg)) {
				$temp_cond[]="reg_id IN (SELECT id FROM fw_regions WHERE param_left BETWEEN (SELECT param_left FROM fw_regions WHERE id='".$sort_reg."') and (SELECT param_right FROM fw_regions WHERE id='".$sort_reg."'))";
				$smarty->assign("cat",$sort_reg);
			}
			$cond=Common::get_cond($temp_cond);
		}
		else $cond="";

		if (isset($_GET['sort']) && $_GET['sort']!='') {
			$sort='ORDER BY '.$_GET['sort'].' ';
			$smarty->assign("sort",$_GET['sort']);
		}
		else $sort='ORDER BY name ';
		if (isset($_GET['order']) && $_GET['order']!='') {
			$sort.=$_GET['order'];
			$smarty->assign("order",$_GET['order']);
		}
		else $sort.='DESC';

		$result=$db->query("SELECT COUNT(*) FROM fw_citys $cond");
		$pager=Common::pager($result,PRODUCTS_PER_PAGE,$page);

		$citys_list=$db->get_all("SELECT *,(SELECT COUNT(*) FROM fw_metros WHERE city_id=p.id) as metros FROM fw_citys p $cond $sort LIMIT ".$pager['limit']);
		$citys_list=String::unformat_array($citys_list);

		$cl=Common::get_nodes_list($reg_list);

		for ($i=0;$i<count($citys_list);$i++) {
			for($k=0;$k<count($cl);$k++) {
				if ($citys_list[$i]['reg_id']==$cl[$k]['id']) {
					$citys_list[$i]['reg_name']=$cl[$k]['name'];
					break;
				}
			}
		}

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("reg_list",$cl);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		$smarty->assign("citys_list",$citys_list);

		$template='regions.a_citys_list.html';

	BREAK;


	CASE ($action=='metros_list'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=regions&action=metros_list","title" => 'Метро');


		if (isset($_GET['page']) && $_GET['page']!='') $page=$_GET['page'];
		else $page=1;

		if (isset($_GET['city']) && $_GET['city']!='') {
			$sort_m=$_GET['city'];
		}

		if ((isset($sort_m)) or (isset($_GET['search']) && $_GET['search']>'1')) {

			if (isset($sort_m)) {
				$temp_cond[]="city_id IN (SELECT id FROM fw_citys WHERE id='".$sort_m."')";
				$smarty->assign("city",$sort_m);
			}
			$cond=Common::get_cond($temp_cond);
		}
		else $cond="";

		if (isset($_GET['sort']) && $_GET['sort']!='') {
			$sort='ORDER BY '.$_GET['sort'].' ';
			$smarty->assign("sort",$_GET['sort']);
		}
		else $sort='ORDER BY name ';
		if (isset($_GET['order']) && $_GET['order']!='') {
			$sort.=$_GET['order'];
			$smarty->assign("order",$_GET['order']);
		}
		else $sort.='ASC';

		$result=$db->query("SELECT COUNT(*) FROM fw_metros $cond");
		$pager=Common::pager($result,PRODUCTS_PER_PAGE,$page);

		$metros_list=$db->get_all("SELECT *,(SELECT name FROM fw_citys WHERE id=p.city_id) as city_name FROM fw_metros p $cond $sort LIMIT ".$pager['limit']);
		$metros_list=String::unformat_array($metros_list);

		//$cl=Common::get_nodes_list($citys_list);

		/*for ($i=0;$i<count($citys_list);$i++) {
			for($k=0;$k<count($cl);$k++) {
				if ($metros_list[$i]['city_id']==$cl[$k]['id']) {
					$metros_list[$i]['city_name']=$cl[$k]['name'];
					break;
				}
			}
		} */

		$smarty->assign("total_pages",$pager['total_pages']);
		//$smarty->assign("citys_list",$cl);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		$smarty->assign("metros_list",$metros_list);
		$smarty->assign("citys_list",$citys_list);

		$template='regions.a_metros_list.html';

	BREAK;


	CASE ($action=='firms_list'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=regions&action=firms_list","title" => 'Компании');


		if (isset($_GET['page']) && $_GET['page']!='') $page=$_GET['page'];
		else $page=1;

		if (isset($_GET['city']) && $_GET['city']!='') {
			$sort_m=$_GET['city'];
		}

		if ((isset($sort_m)) or (isset($_GET['search']) && $_GET['search']>'1')) {

			if (isset($sort_m)) {
				$temp_cond[]="city_id IN (SELECT id FROM fw_citys WHERE id='".$sort_m."')";
				$smarty->assign("city",$sort_m);
			}
			$cond=Common::get_cond($temp_cond);
		}
		else $cond="";

		if (isset($_GET['sort']) && $_GET['sort']!='') {
			$sort='ORDER BY '.$_GET['sort'].' ';
			$smarty->assign("sort",$_GET['sort']);
		}
		else $sort='ORDER BY name ';
		if (isset($_GET['order']) && $_GET['order']!='') {
			$sort.=$_GET['order'];
			$smarty->assign("order",$_GET['order']);
		}
		else $sort.='DESC';

		$result=$db->query("SELECT COUNT(*) FROM fw_firms $cond");
		$pager=Common::pager($result,PRODUCTS_PER_PAGE,$page);

		$firms_list=$db->get_all("SELECT *,(SELECT name FROM fw_citys WHERE id=p.city_id) as city_name FROM fw_firms p $cond $sort LIMIT ".$pager['limit']);
		$firms_list=String::unformat_array($firms_list);

		//$cl=Common::get_nodes_list($citys_list);

		/*for ($i=0;$i<count($citys_list);$i++) {
			for($k=0;$k<count($cl);$k++) {
				if ($metros_list[$i]['city_id']==$cl[$k]['id']) {
					$metros_list[$i]['city_name']=$cl[$k]['name'];
					break;
				}
			}
		} */

		$smarty->assign("total_pages",$pager['total_pages']);
		//$smarty->assign("citys_list",$cl);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		$smarty->assign("firms_list",$firms_list);
		$smarty->assign("citys_list",$citys_list);

		$template='regions.a_firms_list.html';

	BREAK;



	CASE ($action=='add_city'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=regions&action=add_city","title" => 'Добавить город');

		$reg_list=Common::get_nodes_list($reg_list);

		$smarty->assign("reg_list",$reg_list);
		$smarty->assign("mode","add");
		$smarty->assign("reg",@$_GET['reg']);
		$template='regions.a_edit_city.html';

	BREAK;


	CASE ($action=='add_metro'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=regions&action=add_metro","title" => 'Добавить метро');

		//$citys_list=Common::get_nodes_list($citys_list);

		$smarty->assign("citys_list",$citys_list);
		$smarty->assign("mode","add");
		$smarty->assign("city",@$_GET['city']);
		$template='regions.a_edit_metro.html';

	BREAK;

	CASE ($action=='add_firm'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=regions&action=add_firm","title" => 'Добавить компанию');

		//$citys_list=Common::get_nodes_list($citys_list);
        $metros_list=$db->get_all("SELECT * FROM fw_metros");
		$metros_list=String::unformat_array($metros_list);

        $reg_list=Common::get_nodes_list($reg_list);
        $smarty->assign("reg_list",$reg_list);
		$smarty->assign("citys_list",$citys_list);
		$smarty->assign("metros_list",$metros_list);
		$smarty->assign("mode","add");
		$smarty->assign("city",@$_GET['city']);
		$template='regions.a_edit_firm.html';

	BREAK;

	CASE ($action=='edit_city' && isset($_GET['id'])):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=regions&action=edit_city","title" => 'Редактировать город');

		$id=$_GET['id'];

		$reg_list=Common::get_nodes_list($reg_list);
//		unset($cat_list[0]);

// SORRY for so strange separator
/****************************************************************/
		$city=$db->get_single("SELECT *	FROM fw_citys AS p WHERE id='$id'");


		$city=String::unformat_array($city);

/****************************************************************/


		$smarty->assign("reg_list",$reg_list);
		$smarty->assign("city",$city);
		$smarty->assign("mode","edit");
		$template='regions.a_edit_city.html';

	BREAK;


	CASE ($action=='edit_metro' && isset($_GET['id'])):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=regions&action=edit_metro","title" => 'Редактировать метро');

		$id=$_GET['id'];

		//$reg_list=Common::get_nodes_list($reg_list);
//		unset($cat_list[0]);

// SORRY for so strange separator
/****************************************************************/
		$metro=$db->get_single("SELECT *	FROM fw_metros AS p WHERE id='$id'");


		$metro=String::unformat_array($metro);

/****************************************************************/


		$smarty->assign("citys_list",$citys_list);
		$smarty->assign("metro",$metro);
		$smarty->assign("mode","edit");
		$template='regions.a_edit_metro.html';

	BREAK;


	CASE ($action=='edit_firm' && isset($_GET['id'])):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=regions&action=edit_firm","title" => 'Редактировать компанию');

		$id=$_GET['id'];

/****************************************************************/
		$firm=$db->get_single("SELECT *,(SELECT reg_id FROM fw_citys s WHERE id=p.city_id) as reg_id	FROM fw_firms AS p WHERE id='$id'");


		$firm=String::unformat_array($firm);



/****************************************************************/

		$metros_list=$db->get_all("SELECT * FROM fw_metros WHERE city_id=(SELECT city_id FROM fw_firms WHERE id='".(int)$_GET['id']."')");
		$metros_list=String::unformat_array($metros_list);

		$rel_list=$db->get_all("SELECT * FROM fw_firms_metros WHERE firm_id=$id");
		$rel_list=String::unformat_array($rel_list);

		$smarty->assign("citys_list",$citys_list);
		$smarty->assign("rel_list",$rel_list);
		$smarty->assign("metros_list",$metros_list);
		$smarty->assign("reg_list",$reg_list);
		$smarty->assign("firm",$firm);
		$smarty->assign("mode","edit");
		$template='regions.a_edit_firm.html';

	BREAK;

	CASE ($action=='orders'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=shop&action=orders","title" => 'Список заказов');

		if (isset($_GET['page'])) $page=$_GET['page'];
		else $page=1;

		if (isset($_GET['user']) && $_GET['user']>'1') {

			if ($_GET['user']!='') {
				$temp_cond[]="user='".$_GET['user']."'";
				$smarty->assign("user",$_GET['user']);
			}
			$cond=Common::get_cond($temp_cond);
		}
		else $cond="";

		if (isset($_GET['sort']) && $_GET['sort']!='') {
			$sort='ORDER BY '.$_GET['sort'].' ';
			$smarty->assign("sort",$_GET['sort']);
		}
		else $sort='ORDER BY status,insert_date ';
		if (isset($_GET['order']) && $_GET['order']!='') {
			$sort.=$_GET['order'];
			$smarty->assign("order",$_GET['order']);
		}
		else $sort.='DESC';

		$result=$db->query("SELECT COUNT(*) FROM fw_orders $cond");
		$pager=Common::pager($result,PRODUCTS_PER_PAGE,$page);

		$orders_list=$db->get_all("SELECT id,user,status,insert_date,total_price,(SELECT name FROM fw_users WHERE id=o.user) AS user_name FROM fw_orders o $cond $sort LIMIT ".$pager['limit']);
		$orders_list=String::unformat_array($orders_list);

		for ($i=0;$i<count($orders_list);$i++) {
			$orders_list[$i]['status']=str_replace($status_value,$status_name,$orders_list[$i]['status']);
		}

		$smarty->assign("orders_list",$orders_list);
		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		$template='shop.a_orders.html';

	BREAK;

	CASE ($action=='order_details'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=shop&action=orders","title" => 'Список заказов');

		$id=$_GET['id'];

		$order=$db->get_single("SELECT * FROM fw_orders WHERE id='$id'");
		$order=String::unformat_array($order);

		$navigation[]=array("url" => BASE_URL."/admin/?mod=shop&action=order_details","title" => 'Заказ номер '.$order['id']);

		for ($i=0;$i<count($status_value);$i++) {
			$status_list[$i]['value']=$status_value[$i];
			$status_list[$i]['name']=$status_name[$i];
		}

		if ($order['products']!='') {

			$products=explode(",",$order['products']);

			$products_id='';

			for ($i=0;$i<count($products);$i++) {
				list($id,$number)=explode('|',$products[$i]);
				$products_id.=$id.',';
			}
			$products_id=substr($products_id,0,-1);

			$products_list=$db->get_all("SELECT * FROM fw_products WHERE id IN($products_id)");
			$products_list=String::unformat_array($products_list);

			for ($i=0;$i<count($products_list);$i++) {
				for ($l=0;$l<count($products);$l++) {
					list($id,$number)=explode('|',$products[$l]);
					if ($products_list[$i]['id']==$id) $products_list[$i]['number']=$number;
				}

			}
			$smarty->assign("products_list",$products_list);
		}

		$smarty->assign("order",$order);
		$smarty->assign("status_list",$status_list);
		$template='shop.a_order_details.html';

	BREAK;

	CASE ($action=='catalogue'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=shop","title" => 'Категории каталога');

		$smarty->assign("cat_list",$cat_list);

	BREAK;

	CASE ($action=='properties'):

		$properties_list=$db->get_all("SELECT * FROM fw_catalogue_properties ORDER BY name");
		$properties_list=String::unformat_array($properties_list);

		$navigation[]=array("url" => BASE_URL."/admin/?mod=shop","title" => 'Свойства товаров');

		$smarty->assign("properties_list",$properties_list);
		$template='shop.a_products_properties.html';

	BREAK;

	CASE ($action=='add_property'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=shop","title" => 'Свойства товаров');

		$smarty->assign("mode","add");
		$template='shop.a_products_properties.html';

	BREAK;

	CASE ($action=='edit_property' && isset($_GET['id'])):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=shop","title" => 'Редактирование свойства');

		$id=$_GET['id'];

		$property=$db->get_single("SELECT * FROM fw_catalogue_properties WHERE id='$id'");
		$property=String::unformat_array($property);

		$smarty->assign("mode","edit");
		$smarty->assign("property",$property);
		$template='shop.a_products_properties.html';

	BREAK;

	CASE ($action=='mini_catalogue' && isset($_GET['order_id'])):

		$order_id=$_GET['order_id'];
		$smarty->assign("order_id",$order_id);

		if (isset($_GET['add_product']) && isset($_GET['order_id'])) {

			Common::check_priv("$priv");

			$product_found=false;
			$product_id=$_GET['add_product'];
			$products=array();
			$id_list='';
			$total_price='';

			$order=$db->get_single("SELECT products FROM fw_orders WHERE id='$order_id'");

			if ($order['products']!='') {

				$products=explode(",",$order['products']);
				for ($i=0;$i<count($products);$i++) {

					list($id,$number)=explode("|",$products[$i]);
					$id_list.=$id.',';
					if ($id==$product_id) {
						$number++;
						$products[$i]=$id.'|'.$number;
						$product_found=true;
					}
				}
			}
			if (!$product_found) {
				$products[]=$product_id.'|1';
				$product=$db->get_single("SELECT price FROM fw_products WHERE id='$product_id'");
				$total_price=$product['price'];
			}
			else {

				$id_list=substr($id_list,0,-1);

				$products_for_total=$db->get_all("SELECT id,price FROM fw_products WHERE id IN ($id_list)");

				for ($i=0;$i<count($products_for_total);$i++) {
					for ($p=0;$p<count($products);$p++) {
						list($id,$number)=explode("|",$products[$p]);
						if ($products_for_total[$i]['id']==$id) {
							$total_price=$total_price+($number*$products_for_total[$i]['price']);
						}
					}
				}

			}
			$products=implode(",",$products);

			$db->query("UPDATE fw_orders SET products='$products', total_price='$total_price' WHERE id='$order_id'");
			$_SESSION['fw_product_added']='1';
			$location=$_SERVER['HTTP_REFERER'];
			header("Location: $location");

		}

		if (isset($_GET['cat'])) {

			if (isset($_SESSION['fw_product_added']) && $_SESSION['fw_product_added']=='1') {
				$_SESSION['fw_product_added']='0';
				$smarty->assign("product_added",'1');
			}

			if (isset($_GET['page'])) $page=$_GET['page'];
			else $page=1;

			$result=$db->query("SELECT COUNT(*) FROM fw_products");
			$pager=Common::pager($result,PRODUCTS_PER_PAGE,$page);

			$cat=$_GET['cat'];
			$products_list=$db->get_all("SELECT * FROM fw_products WHERE parent='$cat' AND status='1' LIMIT ".$pager['limit']);
			$smarty->assign("products_list",$products_list);
			$smarty->assign("cat",$cat);

			$smarty->assign("total_pages",$pager['total_pages']);
			$smarty->assign("current_page",$pager['current_page']);
			$smarty->assign("pages",$pager['pages']);

		}
		else {
			$smarty->assign("cat_list",$cat_list);
		}

		$template='mini_catalogue.html';
		$template_mode='single';

	BREAK;

	CASE ($action=='mini_catalogue' && isset($_GET['product_id'])):

		$product_id=$_GET['product_id'];
		$smarty->assign("product_id",$product_id);

		if (isset($_GET['add_product']) && isset($_GET['product_id'])) {

			Common::check_priv("$priv");

			$product_id=$_GET['product_id'];
			$add_product=$_GET['add_product'];

			$product=$db->get_single("SELECT additional_products FROM fw_products WHERE id='$product_id'");
			$product=String::unformat_array($product);

			if (!strstr($product['additional_products'],$add_product)) {
				if ($product['additional_products']!='') $additional_products=$product['additional_products'].','.$add_product;
				else $additional_products=$add_product;
			}

			$db->query("UPDATE fw_products SET additional_products='$additional_products' WHERE id='$product_id'");

			$_SESSION['fw_product_added']='1';
			$location=$_SERVER['HTTP_REFERER'];
			header("Location: $location");

		}

		if (isset($_GET['cat'])) {

			if (isset($_SESSION['fw_product_added']) && $_SESSION['fw_product_added']=='1') {
				$_SESSION['fw_product_added']='0';
				$smarty->assign("product_added",'1');
			}

			if (isset($_GET['page'])) $page=$_GET['page'];
			else $page=1;

			$result=$db->query("SELECT COUNT(*) FROM fw_products");
			$pager=Common::pager($result,PRODUCTS_PER_PAGE,$page);

			$cat=$_GET['cat'];
			$products_list=$db->get_all("SELECT * FROM fw_products WHERE parent='$cat' AND status='1' LIMIT ".$pager['limit']);
			$products_list=String::unformat_array($products_list);
			$smarty->assign("products_list",$products_list);
			$smarty->assign("cat",$cat);

			$smarty->assign("total_pages",$pager['total_pages']);
			$smarty->assign("current_page",$pager['current_page']);
			$smarty->assign("pages",$pager['pages']);

		}
		else {
			$smarty->assign("cat_list",$cat_list);
		}
		$template='mini_catalogue.html';
		$template_mode='single';

	BREAK;

	CASE ($action=='delete_additional_product' && isset($_GET['id']) & isset($_GET['from'])):

		$id=$_GET['id'];
		$from=$_GET['from'];

		$product=$db->get_single("SELECT additional_products FROM fw_products WHERE id='$from'");

		$additional_products=explode(",",$product['additional_products']);

		for ($i=0;$i<count($additional_products);$i++) {

			if ($additional_products[$i]==$id) unset($additional_products[$i]);

		}

		if (count($additional_products)>0) $additional_products=implode(",",$additional_products);
		else $additional_products='';

		$db->query("UPDATE fw_products SET additional_products='$additional_products' WHERE id='$from'");

		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");

	BREAK;

	DEFAULT:

		//$navigation[]=array("url" => BASE_URL."/admin/?mod=regions","title" => 'Регионы');

		$smarty->assign("reg_list",$reg_list);

}

?>