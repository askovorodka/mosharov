<?php

require_once '../lib/class.tree.php';
require_once '../lib/class.image.php';

/* DB TREE VARIABLES */
$table='fw_tree';
$id_name='id';
$field_names = array(
   'left' => 'param_left',
   'right'=> 'param_right',
   'level'=> 'param_level',
);

$tree=new CDBTree($db, $table, $id_name, $field_names);
$nodes_list=$db->get_all("SELECT * FROM fw_tree ORDER BY param_left");
$nodes_list=String::unformat_array($nodes_list);

$navigation[]=array("url" => BASE_URL."/admin/?mod=tree","title" => 'Дерево сайта');

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

/*------------------------- ВЫПОЛНЯЕМ РАЗЛИЧНЫЕ ДЕЙСТВИЯ ---------------------*/


if (isset($_POST['submit_add_file'])) {

	Common::check_priv("$priv");
	$check=true;
	$title=String::secure_format($_POST['add_file_title']);
	$file_name=$_FILES['add_new_file']['name'];
	$tmp=$_FILES['add_new_file']['tmp_name'];

	$trusted_formats=array('jpg','jpeg','gif','png','pdf','doc','xls');

	$check_file_name=explode(".",$file_name);
	$ext=strtolower($check_file_name[count($check_file_name)-1]);
	if (!in_array($ext,$trusted_formats)) {
		$smarty->assign("error","Разрешены картинки форматов jpg, jpeg, gif, xls, doc, pdf и png");
		$check=false;
	}

	if (filesize($tmp)>2000000) {
		$smarty->assign("error","Размер файла не должен привышать 2Mb");
		$check=false;
	}

	if ($check) {
		$order=$db->get_single("SELECT MAX(sort_order)+1 AS s_order FROM fw_tree_files WHERE parent='".$_POST['parent']."'");
		if ($order['s_order']=='') $order=1;
		else $order=$order['s_order'];
		$result=$db->query("INSERT INTO fw_tree_files(parent,title,ext,sort_order,insert_date) VALUES('".$_POST['parent']."','$title','$ext','".$order."','".time()."')");
		$id=mysql_insert_id();
		if (move_uploaded_file($tmp, BASE_PATH."/uploaded_files/tree_files/$id.$ext")) {
			chmod(BASE_PATH."/uploaded_files/tree_files/$id.$ext",0644);
			if ($ext == 'jpeg' || $ext=='jpg' || $ext=='gif' && $ext=='png')
				Image::image_resize(BASE_PATH."/uploaded_files/tree_files/$id.$ext",BASE_PATH."/uploaded_files/tree_files/resized-$id.$ext",PRODUCT_PREVIEW_WIDTH,PRODUCT_PREVIEW_HEIGHT);
		}
		else {
			$result=$db->query("DELETE FROM fw_tree_files WHERE id='".mysql_insert_id()."'");
			$smarty->assign("error","Файл не был загружен");
		}
	}

}


if (isset($_POST['submit_save_files'])) {

	Common::check_priv("$priv");
	$check=true;
	if (isset($_POST['delete_photos'])) {
		$delete_photos=$_POST['delete_photos'];
		for ($i=0;$i<count($delete_photos);$i++) {
			$values.=$delete_photos[$i];
			if ($i!=count($delete_photos)-1) $values.=',';
		}
		$db->query("DELETE FROM fw_tree_files WHERE id IN ($values)");
		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
	}

	if (@in_array('1',$_POST['order_changed'])) {
		$order_changed=array_keys($_POST['order_changed'],"1");
		$order=$_POST['edit_order'];
		for ($i=0;$i<count($order_changed);$i++) {
			$new_order=$order[$order_changed[$i]];
			$db->query("UPDATE fw_tree_files SET sort_order='$new_order' WHERE id='".$order_changed[$i]."'");
		}
	}

	if (@in_array('1',$_POST['title_changed'])) {

		$title_changed=array_keys($_POST['title_changed'],"1");
		$title=$_POST['edit_title'];

		for ($i=0;$i<count($title_changed);$i++) {
			$new_title=$title[$title_changed[$i]];
			$db->query("UPDATE fw_tree_files SET title='$new_title' WHERE id='".$title_changed[$i]."'");
		}
	}
}


//редактируем статус главного меню
if ($action=="change_in_menu" && isset($_GET['id'])) {
  $id=intval($_GET['id']);
  $db->query("UPDATE fw_tree SET in_menu=IF(in_menu='0','1','0') WHERE id='".$id."'");

  $location=$_SERVER['HTTP_REFERER'];
  header ("Location: $location");
  die();
}


//редактируем статус левого меню
if ($action=="change_in_left_menu" && isset($_GET['id'])) {
  $id=intval($_GET['id']);
  $db->query("UPDATE fw_tree SET in_left_menu=IF(in_left_menu='0','1','0') WHERE id='".$id."'");

  $location=$_SERVER['HTTP_REFERER'];
  header ("Location: $location");
  die();
}


if ($action=="change_status" && isset($_GET['id'])) {
  $id=intval($_GET['id']);
  $db->query("UPDATE fw_tree SET status=IF(status='0','1','0') WHERE id='".$id."'");

  $location=$_SERVER['HTTP_REFERER'];
  header ("Location: $location");
  die();
}


if ($action=="change_document_status" && isset($_GET['id'])) {
  $id=intval($_GET['id']);
  $db->query("UPDATE fw_documents SET status=IF(status='0','1','0') WHERE id='".$id."'");

  $location=$_SERVER['HTTP_REFERER'];
  header ("Location: $location");
  die();
}


if (isset($_POST['submit_add_document'])) {

  Common::check_priv("$priv");

  $check=true;

  $parent=intval($_POST['edit_document_parent']);
  $name=String::secure_format($_POST['edit_document_name']);
  $title=String::secure_format($_POST['edit_document_title']);
  $small_description=String::secure_format($_POST['edit_small_description']);
  $description=String::secure_format($_POST['edit_description']);
  $status=intval($_POST['edit_document_status']);
  $keywords=String::secure_format($_POST['edit_document_keywords']);
  $meta_description=String::secure_format($_POST['edit_document_description']);

  $sort_order=$db->get_single("SELECT MAX(sort_order)+1 as maximum FROM fw_documents WHERE parent='".$parent."'");
  $sort_order=$sort_order['maximum'];

  if ($check) {
    $db->query("
      INSERT INTO
        fw_documents (
          parent,
          name,
          small_description,
          description,
          title,
          meta_keywords,
          meta_description,
          status,
          insert_date,
          sort_order
        )
        VALUES (
          '".$parent."',
          '".$name."',
          '".$small_description."',
          '".$description."',
          '".$title."',
          '".$keywords."',
          '".$meta_description."',
          '".$status."',
          NOW(),
          '".$sort_order."'
        )
    ");

    header ("Location: ?mod=tree&action=edit_document&id=".mysql_insert_id());
    die();
  }
}

if (isset($_POST['submit_edit_document'])) {
  Common::check_priv("$priv");

  $check=true;

  $id=intval($_POST['id']);
  $parent=intval($_POST['edit_document_parent']);
  $name=String::secure_format($_POST['edit_document_name']);
  $title=String::secure_format($_POST['edit_document_title']);
  $small_description=String::secure_format($_POST['edit_small_description']);
  $description=String::secure_format($_POST['edit_description']);
  $status=intval($_POST['edit_document_status']);
  $keywords=String::secure_format($_POST['edit_document_keywords']);
  $meta_description=String::secure_format($_POST['edit_document_description']);

  $image=$_POST['edit_document_image_old'];

  if (isset($_POST['edit_document_image_delete'])) {
    @unlink(BASE_PATH.'/uploaded_files/documents_images/'.$_POST['edit_node_image_old']);
    $image='';
  }

  if (isset($_FILES['edit_document_image']) && $_FILES['edit_document_image']['name']!='') {

    $file_name=$_FILES['edit_document_image']['name'];
    $tmp=$_FILES['edit_document_image']['tmp_name'];

    $check_file_name=explode(".",$file_name);
    $ext=strtolower($check_file_name[count($check_file_name)-1]);

    if (filesize($tmp)>2000000) {
      $smarty->assign("error_message","Размер фотографии не должен привышать 2Mb");
      $check=false;
    }

  }

  if ($check) {

    if (@$file_name!='') {
      if (move_uploaded_file($tmp, BASE_PATH.'/uploaded_files/documents_images/'.$id.'.'.$ext)) {
        chmod(BASE_PATH.'/uploaded_files/documents_images/'.$id.'.'.$ext, 0644);
        Image::image_resize(BASE_PATH.'/uploaded_files/documents_images/'.$id.'.'.$ext, BASE_PATH.'/uploaded_files/documents_images/resized-'.$id.'.'.$ext,DOCUMENT_IMAGE_WIDTH,DOCUMENT_IMAGE_HEIGHT);

        $image=$id.'.'.$ext;
      }
    }

    $db->query("
      UPDATE fw_documents
      SET
        parent='".$parent."',
        name='".$name."',
        small_description='".$small_description."',
        description='".$description."',
        title='".$title."',
        meta_keywords='".$keywords."',
        meta_description='".$meta_description."',
        image='".$image."',
        status='".$status."'
      WHERE
        id='".$id."'
    ");

    $location=$_SERVER['HTTP_REFERER'];
    header ("Location: $location");
    die();
  }
}

if (isset($_POST['submit_add_node'])) {

  Common::check_priv("$priv");
  $check=true;
  $parent=$_POST['edit_node_parent'];
  $url=String::secure_format($_POST['edit_node_url']);
  $name=String::secure_format($_POST['edit_node_name']);
  $label=String::secure_format($_POST['edit_node_label']);
  if (!empty($_POST['edit_node_title'])) $title=String::secure_format($_POST['edit_node_title']);else $title="";
  $module=String::secure_format($_POST['edit_node_module']);
  $status=1;
  $menu=1;
  $left_menu=0;
  if (!empty($_POST['edit_node_keywords'])) $keywords=String::secure_format($_POST['edit_node_keywords']); else $keywords="";
  if (!empty($_POST['edit_node_description'])) $description=String::secure_format($_POST['edit_node_description']);else $description="";
  $node_template=$_POST['edit_node_template'];

  if (!empty($_POST['access_to'])) $access_to=$_POST['access_to']; else $access_to="";

  $access_users='all';

  if ($name=='') $name="Новый безымянный узел";

  if (isset($_POST['edit_node_supmodules'])) {
    $support_modules='';
    foreach ($_POST['edit_node_supmodules'] as $k=>$v) {
      $support_modules.=$v.',';
    }
    $support_modules=substr($support_modules,0,-1);
  }
  else $support_modules='';

  $check_if_exists=$db->get_all("SELECT id FROM fw_tree WHERE url='$url' AND param_left>(SELECT param_left FROM fw_tree WHERE id='$parent') AND param_right<(SELECT param_right FROM fw_tree WHERE id='$parent') AND param_level=(SELECT param_level FROM fw_tree WHERE id='$parent')");
  if (count($check_if_exists)>0) {
    $smarty->assign("error_message","Узел с таким урлом уже существует!");
    $check=false;
  }

  if (!preg_match("/^([a-z0-9_-]+)$/",$url)) {
    $smarty->assign("error_message","В URL допустимы только символы латиницы, минус и знак подчёркивания!");
    $check=false;
  }

  if ($check) {
    $elements=mysql_real_escape_string(file_get_contents(BASE_PATH.'/modules/'.$module.'/front/templates/elements.html'));
	$tree->insert($parent,array(
		"name"=>$name,
		"label"=>$label,
		"template"=>$node_template,
		"title"=>$title,
		"url"=>$url,
		"text"=>'',
		"module"=>$module,
		"support_modules"=>$support_modules,
		"elements"=>$elements,
		"status"=>$status,
		"meta_keywords"=>$keywords,
		"meta_description"=>$description,
		"access_users"=>$access_users,
		"in_menu"=>$menu,
		"in_left_menu"=>$left_menu,
		"show_documents_number"=>DOCUMENTS_ON_PAGE));
	
    if ($module=='page') header("Location: index.php?mod=tree&action=edit&id=".mysql_insert_id());
    else header("Location: index.php?mod=tree");
  }
}

if (isset($_POST['submit_edit_node'])) {

  Common::check_priv("$priv");

  $check=true;

  $id=$_POST['id'];
  $old_url=$_POST['old_url'];
  $old_parent=$_POST['old_parent'];

  $parent=$_POST['edit_node_parent'];
  $url=String::secure_format($_POST['edit_node_url']);
  $name=String::secure_format($_POST['edit_node_name']);
  $label=String::secure_format($_POST['edit_node_label']);
  $title=String::secure_format($_POST['edit_node_title']);
  $module=$_POST['edit_node_module'];
  $status=$_POST['edit_node_status'];
  $menu=$_POST['edit_node_menu'];
  $left_menu=$_POST['edit_node_left_menu'];
  $keywords=String::secure_format($_POST['edit_node_keywords']);
  $description=String::secure_format($_POST['edit_node_description']);
  $node_template=$_POST['edit_node_template'];
  $show_nodes=isset($_POST['edit_node_show_nodes'])?"1":"0";
  $show_documents=isset($_POST['edit_node_show_documents'])?"1":"0";
  $show_documents_number=intval($_POST['edit_node_show_documents_number']);
  $show_documents_orderby=intval($_POST['edit_node_show_documents_orderby']);
  $documents_template=String::secure_format($_POST['edit_node_documents_template']);

  $access_to=$_POST['access_to'];

  $access_users='';
  $access_groups='';
  $new_access=true;

  $image=$_POST['edit_node_image_old'];

  if (isset($_POST['edit_node_image_delete'])) {
    @unlink(BASE_PATH.'/uploaded_files/tree_images/'.$_POST['edit_node_image_old']);
    $image='';
  }

  if (isset($_FILES['edit_node_image']) && $_FILES['edit_node_image']['name']!='') {

    $file_name=$_FILES['edit_node_image']['name'];
    $tmp=$_FILES['edit_node_image']['tmp_name'];

    $check_file_name=explode(".",$file_name);
    $ext=strtolower($check_file_name[count($check_file_name)-1]);

    if (filesize($tmp)>2000000) {
      $smarty->assign("error_message","Размер фотографии не должен привышать 2Mb");
      $check=false;
    }

  }

  if ($new_access) {
    if ($access_to=='list') {

      if (isset($_POST['users_list'])){
        $access_users = $_POST['users_list'];
      }
      else
        $access_users="";

      if (isset($_POST['access_users_groups']) && count($_POST['access_users_groups'])>0) {
        $access_groups=array();
        foreach ($_POST['access_users_groups'] as $k=>$v) {
          $access_groups[]=$v;
        }
        $access_groups=implode(",", $access_groups);
      }
      else $access_groups="";

    }
    else {
      $access_users=$access_to;
      $access_groups=$access_to;
    }
  }

  if ($access_users=='') $access_users='all';
  if ($access_groups=='') $access_groups='all';

  if (isset($_POST['edit_page_text'])) $text=mysql_real_escape_string($_POST['edit_page_text']);
  else $text='';

  if ($name=='') $name="Новый безымянный узел";

  if (isset($_POST['edit_node_supmodules'])) {
    $support_modules='';
    foreach ($_POST['edit_node_supmodules'] as $k=>$v) {
      $support_modules.=$v.',';
    }
    $support_modules=substr($support_modules,0,-1);
  }
  else $support_modules='';

  if ($url!=$old_url or $parent!=$old_parent) {
    $check_if_exists=$db->get_all("SELECT id FROM fw_tree WHERE url='$url' AND param_left>(SELECT param_left FROM fw_tree WHERE id='$parent') AND param_right<(SELECT param_right FROM fw_tree WHERE id='$parent') AND param_level=(SELECT param_level FROM fw_tree WHERE id='$parent')");
    if (count($check_if_exists)>0) {
      $smarty->assign("error_message","Узел с таким урлом уже существует!");
      $check=false;
    }
  }

  if (!preg_match("/^([a-z0-9_-]+)$/",$url)) {
    $smarty->assign("error_message","В URL допустимы только символы латиницы, минус и знак подчёркивания!");
    $check=false;
  }

  if ($check) {
    if (@$file_name!='') {
      if (move_uploaded_file($tmp, BASE_PATH.'/uploaded_files/tree_images/'.$id.'.'.$ext)) {
        chmod(BASE_PATH.'/uploaded_files/tree_images/'.$id.'.'.$ext, 0644);
        $image=$id.'.'.$ext;

      }
    }


    $db->query("
      UPDATE
        fw_tree
      SET
        name='$name',
        label='$label',
        template='$node_template',
        title='$title',
        url='$url',
        text='$text',
        module='$module',
        support_modules='$support_modules',
        status='$status',
        documents_template='$documents_template',
        meta_keywords='$keywords',
        meta_description='$description',
        access_users='$access_users',
        access_groups='$access_groups',
        in_menu='$menu',
        in_left_menu='$left_menu',
        image='$image',
        show_nodes='$show_nodes',
        show_documents='$show_documents',
        show_documents_number='$show_documents_number',
        show_documents_orderby='$show_documents_orderby'
      WHERE
        id='$id'
    ");

    if ($access_users!='all') {
      $pf=$db->get_single("SELECT param_left,param_right,param_level FROM fw_tree WHERE id='$id'");
      $db->query("UPDATE fw_tree SET access_users='$access_users' WHERE param_left>".$pf['param_left']." AND param_right<".$pf['param_right']."");
    }

    if ($parent!=$old_parent) {
      $a=array(array('from' => $id,'to' => $parent));
      $move=$tree->move($a,true);

      if($move===false) $move=-2;
    }

    $location=$_SERVER['HTTP_REFERER'];
    header ("Location: $location");
    die();
  }
}

if ($action=='move_up_document' && isset($_GET['id'])){

  $id=intval($_GET['id']);

  $result=$db->get_single("
    SELECT
      d.id,
      d.parent,
      d.sort_order,
      (SELECT MAX(d2.sort_order) FROM fw_documents d2 WHERE d2.parent=d.parent) as max_sort_order,
      (SELECT MIN(d2.sort_order) FROM fw_documents d2 WHERE d2.parent=d.parent) as min_sort_order
    FROM fw_documents d
    WHERE
      d.id='".$id."'
  ");

  if (count($result)>0) {
    if ($result['sort_order']>$result['min_sort_order']) {
      $db->query("UPDATE fw_documents SET sort_order=sort_order-1 WHERE id='".$result['id']."'");
      $db->query("UPDATE fw_documents SET sort_order=sort_order+1 WHERE parent='".$result['parent']."' AND sort_order='".($result['sort_order']-1)."' AND id!='".$id."'");

    }

    $location=$_SERVER['HTTP_REFERER'];
    header ("Location: $location");
    die();
  }
}

if ($action=='move_down_document' && isset($_GET['id'])){

  $id=intval($_GET['id']);

  $result=$db->get_single("
    SELECT
      d.id,
      d.parent,
      d.sort_order,
      (SELECT MAX(d2.sort_order) FROM fw_documents d2 WHERE d2.parent=d.parent) as max_sort_order,
      (SELECT MIN(d2.sort_order) FROM fw_documents d2 WHERE d2.parent=d.parent) as min_sort_order
    FROM fw_documents d
    WHERE
      d.id='".$id."'
  ");

  if (count($result)>0) {
    if ($result['sort_order']<$result['max_sort_order']) {
      $db->query("UPDATE fw_documents SET sort_order=sort_order+1 WHERE id='".$result['id']."'");
      $db->query("UPDATE fw_documents SET sort_order=sort_order-1 WHERE parent='".$result['parent']."' AND sort_order='".($result['sort_order']+1)."' AND id!='".$id."'");

    }

    $location=$_SERVER['HTTP_REFERER'];
    header ("Location: $location");
    die();
  }
}

if ($action=='move_up' && isset($_GET['id'])){

  Common::check_priv("$priv");

  $id = $_GET['id'];

  $a=array(array('from' => $id,'sibling' => true,'left' => true));

  $tree->move($a,true);

  $location=$_SERVER['HTTP_REFERER'];
  header ("Location: $location");
  die();

}

if ($action=='move_down' && isset($_GET['id'])) {

  Common::check_priv("$priv");

  $id = $_GET['id'];

  $a=array(array('from' => $id,'sibling' => true,'right' => true));

  $tree->move($a,true);

  $location=$_SERVER['HTTP_REFERER'];
  header ("Location: $location");
  die();

}

if ($action=='delete' && isset($_GET['id'])) {

  Common::check_priv("$priv");

  $id = intval($_GET['id']);

  $tree->deleteAll($id);

  header ("Location: index.php?mod=tree");
  die();

}

if ($action=='delete_document' && isset($_GET['id'])) {

  Common::check_priv("$priv");

  $id = intval($_GET['id']);

  $result=$db->get_single("SELECT * FROM fw_documents WHERE id='".$id."'");

  if (count($result)>0) {
    $db->transaction_start();

    $check=(
      $db->query("DELETE FROM fw_documents WHERE id='".$id."'")
      &&
      $db->query("UPDATE fw_documents SET sort_order=sort_order-1 WHERE parent='".$result['parent']."' AND sort_order>".$result['sort_order'])
      );

    if ($check)
      $db->transaction_commit();
    else
      $db->transaction_rollback();

    $location=$_SERVER['HTTP_REFERER'];
    header ("Location: ?mod=tree&action=documents_list&parent=".$result['parent']);
    die();
  }
}

if (isset($_POST['submit_edit_elements'])) {

  Common::check_priv("$priv");

  $id=$_POST['id'];
  $edit_elements=String::secure_format($_POST['edit_elements']);

  if (isset($_POST['default_elements'])) {
    $edit_elements=$db->get_single("SELECT module FROM fw_tree WHERE id='$id'");
    $edit_elements=file_get_contents(BASE_PATH.'/modules/'.$edit_elements['module'].'/front/templates/elements.html');
  }
  $db->query("UPDATE fw_tree SET elements='$edit_elements' WHERE id='$id'");

  $location=$_SERVER['HTTP_REFERER'];
  header ("Location: $location");
  die();
}

/*--------------------------------- ОТОБРАЖЕНИЕ ------------------------------*/

SWITCH (TRUE) {

  CASE ($action=='viewAllUsers'):
    $template_mode='single';
    $users_list = $db->get_all("SELECT id,name,login,mail,(SELECT name FROM fw_users_groups WHERE id=fw_users.group_id) as group_name FROM fw_users");
    $users_list=String::unformat_array($users_list);
    if (isset($_GET['sec_id']) && intval($_GET['sec_id'])>0){
      $checked_users = $db->get_single("SELECT access_users FROM fw_tree WHERE id='".intval($_GET['sec_id'])."'");
      if (trim($checked_users['access_users'])!='all' && trim($checked_users['access_users'])!='registered' && strlen(trim($checked_users['access_users']))>0){
        $floor=array();
        $floor = explode(",",$checked_users['access_users']);

        $smarty->assign("checked_users",$floor);
      }
    }
    $smarty->assign("users_list",$users_list);
    $template = 'tree.a_users_list.html';
  BREAK;

  CASE ($action=='add'):

    $navigation[]=array("url" => BASE_URL."/admin/?mod=tree&action=add","title" => 'Добавить узел');

    if (isset($_GET['id'])) $id = $_GET['id'];

    if (isset($_GET['parent'])) $parent=intval($_GET['parent']);
    else $parent=1;

    $smarty->assign("parent",$parent);

    $modules=$db->get_all("SELECT name,title FROM fw_modules WHERE (section='front_additional' OR section='front_main' OR section='front_support') AND status='1'");
    $modules_support=$db->get_all("SELECT name,title FROM fw_modules WHERE section='front_support' AND status='1'");

    $template="tree.a_edit.html";

    $smarty->assign("modules",$modules);
    $smarty->assign("mode","add");
    $smarty->assign("modules_support",$modules_support);
    $smarty->assign("templates_list",$db->get_all("SELECT name,file FROM fw_templates"));
    $smarty->assign("nodes_list",Common::get_nodes_list($nodes_list,'page'));

  BREAK;

  CASE ($action=='mini_browser'):

    $content=Common::generate_main_menu();

    $smarty->assign("content",$content);

    $smarty->assign("returnname", $_GET['returnname']);

    $template='mini_browser.html';
    $template_mode='single';

  BREAK;

  CASE ($action=='edit'):

    $navigation[]=array("url" => BASE_URL."/admin/?mod=tree&action=edit","title" => 'Редактировать узел');

    if (isset($_GET['id'])) $id = $_GET['id'];

    $modules=$db->get_all("SELECT name,title FROM fw_modules WHERE (section='front_additional' OR section='front_main' OR section='front_support') AND status='1'");
    $modules_support=$db->get_all("SELECT name,title FROM fw_modules WHERE section='front_support' AND status='1'");

    $documents_orderby_list=$db->get_all("SELECT * FROM fw_documents_orderby WHERE status='1'");
	
	$files_list=$db->get_all("SELECT * FROM fw_tree_files WHERE parent='$id' ORDER BY sort_order");

    $template="tree.a_edit.html";

    $node=$db->get_single("SELECT * FROM fw_tree WHERE id='$id'");
    $node=String::unformat_array($node);

    if ($node['access_users']=='all' && $node['access_groups']=='all') $access_mode='all';
    else if ($node['access_users']=='registered' && $node['access_groups']=='registered') $access_mode='registered';
    else $access_mode='list';

    $smarty->assign("node",$node);

    $users_list=$db->get_all("SELECT id, name,login FROM fw_users");
    $users_groups_list=$db->get_all("SELECT id,name FROM fw_users_groups");

    foreach ($users_list as $k=>$v) {
      $users_checkboxes[$v['id']]=$v['name'].'('.$v['login'].')';
    }

    foreach ($users_groups_list as $k=>$v) {
      $users_groups_checkboxes[$v['id']]=$v['name'];
    }

    $documents_template=array();
    foreach (glob(BASE_PATH."/modules/page/front/templates/documents_list*.html") as $filename) {
      $documents_templates[]=basename($filename);
    }

    $users_checked=explode(",",$node['access_users']);
    $users_groups_checked=explode(",",$node['access_groups']);

    $smarty->assign("users_checkboxes",$users_checkboxes);
    //$smarty->assign("users_checked",$users_checked);
    $smarty->assign("users_checked",$node['access_users']);
    $smarty->assign("users_groups_checkboxes",$users_groups_checkboxes);
    $smarty->assign("users_groups_checked",$users_groups_checked);
    $smarty->assign("access_mode",$access_mode);
    $smarty->assign("documents_templates",$documents_templates);
	$smarty->assign('files_list',$files_list);

    $parent=$tree->getParent($id);

    $smarty->assign("parent",$parent['id']);
    $smarty->assign("modules",$modules);
    $smarty->assign("mode","edit");
    $smarty->assign("modules_support",$modules_support);
    $smarty->assign("templates_list",$db->get_all("SELECT name,file FROM fw_templates"));
    $smarty->assign("nodes_list",Common::get_nodes_list($nodes_list,'page',$id));
    $smarty->assign("documents_orderby_list",$documents_orderby_list);

  BREAK;

  CASE ($action=='edit_elements'):

    $navigation[]=array("url" => BASE_URL."/admin/?mod=tree&action=edit","title" => 'Редактировать шаблон узла');

    if (isset($_GET['id'])) $id = $_GET['id'];

    $template="tree.a_edit_elements.html";
    $node=$db->get_single("SELECT elements,id,name FROM fw_tree WHERE id='$id'");
    $node=String::unformat_array($node);
    $node['elements']=addslashes($node['elements']);

    $smarty->assign("node",$node);

  BREAK;

  CASE ($action=='documents_list' && isset($_GET['parent'])):

    $navigation[]=array("url" => BASE_URL."/admin/?mod=tree&action=documents_list&parent=".intval($_GET['parent']),"title" => 'Документы узла');

    $parent = intval($_GET['parent']);

    $template="tree.a_documents_list.html";
    $content=$db->get_all("SELECT * FROM fw_documents WHERE parent='$parent' ORDER BY sort_order");

    if (count($content)>0) {

      $content=String::unformat_array($content);

      $smarty->assign("content",$content);
    }

  BREAK;

  CASE ($action=='add_document'):

    $navigation[]=array("url" => BASE_URL."/admin/?mod=tree&action=add_document","title" => 'Добавить документ');

    if (isset($_GET['parent'])) {

      $parent=intval($_GET['parent']);
      $smarty->assign("parent",$parent);
      $template="tree.a_edit_document.html";
      $smarty->assign("mode","add");

      $nodes_list=Common::get_nodes_list($nodes_list,'page');
      unset($nodes_list[0]);

      $smarty->assign("nodes_list",$nodes_list);
    }

  BREAK;

  CASE ($action=='edit_document'):

    $navigation[]=array("url" => BASE_URL."/admin/?mod=tree&action=edit_document","title" => 'Редактировать документ');

    if (isset($_GET['id'])) {

      $id=intval($_GET['id']);

      $result=$db->get_single("SELECT * FROM fw_documents WHERE id='".$id."'");

      if (count($result)>0) {

        $template="tree.a_edit_document.html";
        $smarty->assign("parent",$result['parent']);
        $smarty->assign("mode","edit");
        $smarty->assign("document",$result);

        $nodes_list=Common::get_nodes_list($nodes_list,'page');
        unset($nodes_list[0]);

        $smarty->assign("nodes_list",$nodes_list);
      }
    }

  BREAK;

  DEFAULT:

    $content=$db->get_all("
      SELECT
        *,
        (SELECT COUNT(id) FROM fw_documents WHERE parent=t.id) as documents
      FROM fw_tree t
      ORDER BY t.param_left ASC
    ");

    $content=String::unformat_array($content);
    $smarty->assign("content",Common::get_nodes_list($content));

}
?>