<?php

require_once '../lib/class.tree.php';

/* DB TREE VARIABLES */
$table='fw_forums';
$id_name='id';
$field_names = array(
   'left' => 'param_left',
   'right'=> 'param_right',
   'level'=> 'param_level',
);

$tree=new CDBTree($db, $table, $id_name, $field_names);
$forums_list=$db->get_all("SELECT * FROM fw_forums ORDER BY param_left");
$forums_list=String::unformat_array($forums_list);

$navigation[]=array("url" => BASE_URL."/admin/?mod=shop","title" => 'Форум');


if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';


function add_forum_tags($text) {

	$text=preg_replace("/<b>/i","[B]",$text);
	$text=preg_replace("/<\/b>/i","[/B]",$text);

	$text=preg_replace("/<i>/i","[I]",$text);
	$text=preg_replace("/<\/i>/i","[/I]",$text);

	$text=preg_replace("/<u>/i","[U]",$text);
	$text=preg_replace("/<\/u>/i","[/U]",$text);

	$text=preg_replace("/<div class=forum_quote>/i","[QUOTE]",$text);
	$text=preg_replace("/<\/div>/i","[/QUOTE]",$text);

	$text=preg_replace("/<br>/i","\n",$text);

	$text=preg_replace("/<a href=([^>]*)>([^<]*?)<\/a>/i","[URL=\\1]\\2[/URL]",$text);
	$text=preg_replace("/<img src=([^>]*)>/i","[IMG]\\1[/IMG]",$text);

	return $text;
}

function strip_forum_tags($text) {

	$text=str_replace("\r\n","[br]",$text);
	$text=String::secure_user_input($text);

	$text=preg_replace("/\[B\]/i","<b>",$text);
	$text=preg_replace("/\[\/B\]/i","</b>",$text);

	$text=preg_replace("/\[I\]/i","<i>",$text);
	$text=preg_replace("/\[\/I\]/i","</i>",$text);

	$text=preg_replace("/\[U\]/i","<u>",$text);
	$text=preg_replace("/\[\/U\]/i","</u>",$text);

	$text=preg_replace("/\[QUOTE\]/i","<div class=forum_quote>",$text);
	$text=preg_replace("/\[\/QUOTE\]/i","</div>",$text);

	$text=str_replace('[br]',"<br>",$text);

	$text=preg_replace("/\[URL=([^\]]*)\]([^\[]*)\[\/URL\]/i","<a href=\\1>\\2</a>",$text);
	$text=preg_replace("/\[IMG\]([^\[]*)\[\/IMG\]/i","<img src=\\1>",$text);

	return $text;
}


/*------------------------- ВЫПОЛНЯЕМ РАЗЛИЧНЫЕ ДЕЙСТВИЯ ---------------------*/

if (isset($_POST['submit_add_forum'])) {

	Common::check_priv("$priv");

	$check=true;

	$parent=$_POST['edit_forum_parent'];
	$url=String::secure_format($_POST['edit_forum_url']);
	$name=String::secure_format($_POST['edit_forum_name']);
	$name2=String::secure_format($_POST['edit_forum_name2']);
	$title=String::secure_format($_POST['edit_forum_title']);
	$description=String::secure_format($_POST['edit_forum_description']);
	$status=$_POST['edit_forum_status'];
	$read_to=$_POST['read_to'];
	$write_to=$_POST['write_to'];

	$access_read_users='';
	$new_access=true;

	if ($parent!='1') {
		$parent_data=$db->get_single("SELECT read_users FROM fw_forums WHERE id='$parent'");

		if ($parent_data['read_users']!='all') {
			$access_read_users=$parent_data['read_users'];
			$new_access=false;
		}
	}

	if ($new_access) {
		if ($read_to=='list') {
			foreach ($_POST['read_users'] as $k=>$v) {
				$access_read_users.=$v.',';
			}
			$access_read_users=substr($access_read_users,0,-1);
		}
		else $access_read_users=$read_to;
	}

	if ($access_read_users=='') $access_read_users='all';

	if ($write_to=='list') {
		foreach ($_POST['write_users'] as $k=>$v) {
			$access_write_users.=$v.',';
		}
		$access_write_users=substr($access_write_users,0,-1);
	}
	else $access_write_users=$write_to;

	if ($access_write_users=='') $access_write_users='all';

	if ($name=='') $name="Новый форум";

	$check_if_exists=$db->get_all("SELECT id FROM fw_forums WHERE url='$url' AND param_left>(SELECT param_left FROM fw_forums WHERE id='$parent') AND param_right<(SELECT param_right FROM fw_forums WHERE id='$parent') AND param_level=(SELECT param_level FROM fw_forums WHERE id='$parent')");
	if (count($check_if_exists)>0) {
		$smarty->assign("error_message","Форум с таким урлом уже существует!");
		$check=false;
	}

	if (!preg_match("/^([a-z0-9_-]+)$/",$url)) {
		$smarty->assign("error_message","В URL допустимы только символы латиницы, минус и знак подчёркивания!");
		$check=false;
	}

	if ($check) {
		$tree->insert($parent,array("name"=>$name,"name2"=>$name2,"title"=>$title,"description"=>$description,"url"=>$url,"status"=>$status,"read_users"=>$access_read_users,"write_users"=>$access_write_users));
		header("Location: index.php?mod=forum");
	}
}

if (isset($_POST['submit_edit_forum'])) {

	Common::check_priv("$priv");

	$check=true;
	$new_access=true;

	$id=$_POST['id'];
	$old_url=$_POST['old_url'];
	$old_parent=$_POST['old_parent'];

	$parent=$_POST['edit_forum_parent'];
	$url=String::secure_format($_POST['edit_forum_url']);
	$name=String::secure_format($_POST['edit_forum_name']);
	$name2=String::secure_format($_POST['edit_forum_name2']);
	$title=String::secure_format($_POST['edit_forum_title']);
	$description=String::secure_format($_POST['edit_forum_description']);
	$status=$_POST['edit_forum_status'];
	$read_to=$_POST['read_to'];
	$write_to=$_POST['write_to'];

	$access_read_users='';
	$access_write_users='';

	if ($parent!='1') {
		$parent_data=$db->get_single("SELECT read_users FROM fw_forums WHERE id='$parent'");

		if ($parent_data['read_users']!='all') {
			$access_read_users=$parent_data['read_users'];
			$new_access=false;
		}
	}

	if ($new_access) {
		if ($read_to=='list') {
			/*foreach ($_POST['read_users'] as $k=>$v) {
				$access_read_users.=$v.',';
			}
			$access_read_users=substr($access_read_users,0,-1);*/
		}
		else $access_read_users=$read_to;
	}

	if ($access_read_users=='') $access_read_users='all';

	if ($write_to=='list') {
		foreach ($_POST['write_users'] as $k=>$v) {
			$access_write_users.=$v.',';
		}
		$access_write_users=substr($access_write_users,0,-1);
	}
	else $access_write_users=$write_to;

	if ($access_write_users=='') $access_write_users='all';

	if ($name=='') $name="Новый форум";

	if ($url!=$old_url or $parent!=$old_parent) {
		$check_if_exists=$db->get_all("SELECT id FROM fw_forums WHERE url='$url' AND param_left>(SELECT param_left FROM fw_forums WHERE id='$parent') AND param_right<(SELECT param_right FROM fw_forums WHERE id='$parent') AND param_level=(SELECT param_level FROM fw_forums WHERE id='$parent')");
		if (count($check_if_exists)>0) {
			$smarty->assign("error_message","Форум с таким урлом уже существует!");
			$check=false;
		}
	}

	if (!preg_match("/^([a-z0-9_-]+)$/",$url)) {
		$smarty->assign("error_message","В URL допустимы только символы латиницы, минус и знак подчёркивания!");
		$check=false;
	}

	if ($check) {

		$db->query("UPDATE fw_forums SET name='$name',name2='$name2',title='$title',description='$description',url='$url',status='$status',read_users='$access_read_users',write_users='$access_write_users' WHERE id='$id'");

		if ($access_read_users!='all') {
			$pf=$db->get_single("SELECT param_left,param_right,param_level FROM fw_forums WHERE id='$id'");
			$db->query("UPDATE fw_forums SET read_users='$access_read_users' WHERE param_left>".$pf['param_left']." AND param_right<".$pf['param_right']."");
		}

		if ($access_write_users!='all') {
			$pf=$db->get_single("SELECT param_left,param_right,param_level FROM fw_forums WHERE id='$id'");
			$db->query("UPDATE fw_forums SET write_users='$access_write_users' WHERE param_left>".$pf['param_left']." AND param_right<".$pf['param_right']."");
		}

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

if ($action=='forum_move_up' && isset($_GET['id'])) {

	Common::check_priv("$priv");

	$id = $_GET['id'];

	$tree->moveByStep($id,"up");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");

}

if ($action=='forum_move_down' && isset($_GET['id'])) {

	Common::check_priv("$priv");

	$id = $_GET['id'];

	$tree->moveByStep($id,"down");

	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");

}

if ($action=='delete_forum' && isset($_GET['id'])) {

	Common::check_priv("$priv");

	$id = $_GET['id'];

	$tree->deleteAll($id);
	$location=$_SERVER['HTTP_REFERER'];
	header ("Location: $location");
	die();
}

if ($action=='delete_thread') {

	Common::check_priv("$priv");

	$id=$_GET['id'];

	$db->query("DELETE FROM fw_forum_threads WHERE id='$id' LIMIT 1");
	$db->query("DELETE FROM fw_forum_posts WHERE parent='$id'");
	$db->query("DELETE FROM fw_send_forum_answers WHERE thread_id='$id'");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
	die();
}

if ($action=='delete_post') {

	Common::check_priv("$priv");

	$id=$_GET['id'];

	$db->query("DELETE FROM fw_forum_posts WHERE id='$id' LIMIT 1");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
	die();
}

if ($action=='fix_thread') {

	Common::check_priv("$priv");

	$id=$_GET['id'];

	$new_top=$db->get_single("SELECT top FROM fw_forum_threads WHERE id='$id'");
	if ($new_top['top']=='1') {
		$new_top='0';
	}
	else $new_top='1';

	$db->query("UPDATE fw_forum_threads SET top='$new_top' WHERE id='$id'");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
	die();
}

if (isset($_POST['submit_edit_post'])) {

	$id=$_POST['post_id'];

	$post=$db->get_single("SELECT author FROM fw_forum_posts WHERE id='$id'");

	if ($post['author']!=$_SESSION['fw_user']['id']) Common::check_priv("$priv");

	$text=strip_forum_tags($_POST['post_text']);

	if (isset($_POST['thread_id'])) {

		$title=$_POST['post_title'];

		if ($_POST['parent']!=$_POST['old_parent']) {

			$parent=$_POST['parent'];

			$forums_list=Common::get_nodes_list($forums_list);

			foreach ($forums_list as $k=>$v) {
				if ($v['id']==$parent) $forum_url=$v['full_url'];
			}

			$m_url=$db->get_single("SELECT url FROM fw_tree WHERE module='forum' LIMIT 1");

			$smarty->assign("redirect_url",BASE_URL.'/'.$m_url['url'].'/'.$forum_url.'thread_'.$_POST['thread_id']);
		}
		else {
			$parent=$_POST['old_parent'];
		}

		$thread_id=$_POST['thread_id'];
		$db->query("UPDATE fw_forum_threads SET parent='$parent',title='$title' WHERE id='$thread_id'");
	}
	$db->query("UPDATE fw_forum_posts SET text='$text' WHERE id='$id'");

	if (@$_POST['parent']==@$_POST['old_parent']) $smarty->assign("refresh_parent","true");
}


if (isset($_POST['submit_create_thread'])) {

	Common::check_priv("$priv");

	$id=$_POST['post_id'];

	$parent=String::secure_user_input($_POST['parent']);
	$title=String::secure_user_input($_POST['title']);


	if (FORUM_PREMODERATION=='on') $set_status='1';
	else $set_status='1';

	$db->query("INSERT INTO fw_forum_threads(parent,title,status) VALUES('$parent','$title','$set_status')");
	$insert_id=mysql_insert_id();
	$db->query("UPDATE fw_forum_posts SET parent='".$insert_id."', publish_date='".time()."' WHERE id='$id'");

	$nodes_list=Common::get_nodes_list($forums_list);

	foreach ($nodes_list as $k=>$v) {
		if ($v['id']==$parent) $full_url=$v['full_url'];
	}


	$smarty->assign("redirect_url",BASE_URL.'/forum/'.$full_url.'thread_'.$insert_id);
}


/*--------------------------------- ОТОБРАЖЕНИЕ ------------------------------*/

SWITCH (TRUE) {



	CASE ($action=='viewAllUsers'):
		$template_mode='single';
		$users_list = $db->get_all("SELECT id,name,login,mail,(SELECT name FROM fw_users_groups WHERE id=fw_users.group_id) as group_name FROM fw_users");
		$users_list=String::unformat_array($users_list);
		if (isset($_GET['forum_id']) && intval($_GET['forum_id'])>0){
			$checked_users = $db->get_single("SELECT read_users FROM fw_forums WHERE id='".intval($_GET['forum_id'])."'");
			if (trim($checked_users['read_users'])!='all' && trim($checked_users['read_users'])!='registered' && strlen(trim($checked_users['read_users']))>0){
				$floor=array();
				$floor = explode(",",$checked_users['read_users']);
				$smarty->assign("checked_users",$floor);
			}
		}
		if (isset($_GET['forum_id']) && intval($_GET['forum_id'])>0){
			$checked_users = $db->get_single("SELECT write_users FROM fw_forums WHERE id='".intval($_GET['forum_id'])."'");
			if (trim($checked_users['write_users'])!='all' && trim($checked_users['write_users'])!='registered' && strlen(trim($checked_users['write_users']))>0){
				$floor=array();
				$floor = explode(",",$checked_users['write_users']);
				$smarty->assign("checked_users2",$floor);
			}
		}
		
		$smarty->assign("users_list",$users_list);
		$template = 'forum.a_users_list.html';
	BREAK;



	CASE ($action=='add_forum'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=forum&action=add_forum","title" => 'Добавить форум');

		$users_list=$db->get_all("SELECT id, name,login FROM fw_users");

		foreach ($users_list as $k=>$v) {
			$users_checkboxes[$v['id']]=$v['name'].'('.$v['login'].')';
		}
		$smarty->assign("users_checkboxes",$users_checkboxes);

		$smarty->assign("read_mode","all");
		$smarty->assign("write_mode","all");
		$smarty->assign("mode","add");
		$smarty->assign("parent",$_GET['parent']);
		$smarty->assign("forums_list",Common::get_nodes_list($forums_list));
		$template='forum.a_edit_cat.html';

	BREAK;

	CASE ($action=='edit_forum' && isset($_GET['id'])):

		$id=$_GET['id'];

		$navigation[]=array("url" => BASE_URL."/admin/?mod=shop&action=edit_cat","title" => 'Редактировать форум');

		$parent=$tree->getParent($id);

		$forum=$db->get_single("SELECT * FROM fw_forums WHERE id='$id'");
		$forum=String::unformat_array($forum);

		if ($forum['read_users']=='all') $read_mode='all';
		else if ($forum['read_users']=='registered') $read_mode='registered';
		else $read_mode='list';

		if ($forum['write_users']=='all') $write_mode='all';
		else if ($forum['write_users']=='registered') $write_mode='registered';
		else $write_mode='list';

		$users_list=$db->get_all("SELECT id, name,login FROM fw_users");

		foreach ($users_list as $k=>$v) {
			$users_checkboxes[$v['id']]=$v['name'].'('.$v['login'].')';
		}

		$users_read_checked=explode(",",$forum['read_users']);
		$users_write_checked=explode(",",$forum['write_users']);

		$smarty->assign("users_checkboxes",$users_checkboxes);
		$smarty->assign("users_read_checked",$users_read_checked);
		$smarty->assign("users_write_checked",$users_write_checked);

		$smarty->assign("read_mode",$read_mode);
		$smarty->assign("write_mode",$write_mode);
		$smarty->assign("parent",$parent['id']);
		$smarty->assign("forum",$forum);
		$smarty->assign("mode","edit");
		$smarty->assign("forums_list",Common::get_nodes_list($forums_list));
		$template='forum.a_edit_cat.html';

	BREAK;

	CASE ($action=='edit_post'):

		$id=$_GET['post_id'];

		$post=$db->get_single("SELECT text,id,author,parent,
													(SELECT title FROM fw_forum_threads WHERE id=p.parent) AS title,
													(SELECT id FROM fw_forum_threads WHERE id=p.parent) AS thread_id,
													(SELECT parent FROM fw_forum_threads WHERE id=p.parent) AS thread_parent
													FROM fw_forum_posts p WHERE p.id='$id'");

		if ($_SESSION['fw_user']['id']!=$post['author']) {
			Common::check_priv("$priv");
		}
		else $smarty->assign("no_move",true);

		if ($_GET['is_thread']=='yes') {
			$smarty->assign("is_thread",'yes');
			$forums_list=Common::get_nodes_list($forums_list);
			unset($forums_list[0]);
			$smarty->assign("forums_list",$forums_list);
		}

		$post['text']=add_forum_tags($post['text']);

		$post=String::unformat_array($post);

		$smarty->assign("post",$post);

		$template='forum.a_edit_post.html';
		$template_mode='single';

	BREAK;

	CASE ($action=='create_new_thread'):

		$id=$_GET['post_id'];

		$smarty->assign("forums_list",Common::get_nodes_list($forums_list));

		$smarty->assign("post_id",$id);

		$template='forum.a_create_thread.html';
		$template_mode='single';

	BREAK;

	CASE ($action=='move_post' && isset($_GET['forum_id'])):

		$id=$_GET['post_id'];
		$forum_id=$_GET['forum_id'];

		if (isset($_GET['page']) && $_GET['page']!='') {
			$page=$_GET['page'];
		}
		else $page=1;

		$result=$db->query("SELECT COUNT(*) FROM fw_forum_threads WHERE parent='$forum_id'");
		$pager=Common::pager($result,10,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);

		$threads_list=$db->get_all("SELECT *,
												(SELECT publish_date FROM fw_forum_posts WHERE parent=t.id ORDER BY publish_date DESC LIMIT 1) AS last_date
												FROM fw_forum_threads t WHERE t.parent='$forum_id' ORDER BY top DESC,last_date DESC LIMIT ".$pager['limit']);

		$smarty->assign("threads_list",$threads_list);
		$smarty->assign("forum_id",$forum_id);

		$smarty->assign("post_id",$id);

		$template='forum.a_posts_list.html';
		$template_mode='single';

	BREAK;

	CASE ($action=='move_post' && isset($_GET['move_to']) && isset($_GET['post_id'])):

		$post_id=$_GET['post_id'];
		$move_to=$_GET['move_to'];

		$db->query("UPDATE fw_forum_posts SET parent='$move_to', publish_date='".time()."' WHERE id='$post_id'");

		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");

	BREAK;

	CASE ($action=='move_post'):

		$id=$_GET['post_id'];

		$flist=Common::get_nodes_list($forums_list);
		unset($flist[0]);

		$smarty->assign("forums_list",$flist);

		$smarty->assign("post_id",$id);

		$template='forum.a_forums_list.html';
		$template_mode='single';

	BREAK;

	DEFAULT:

		$smarty->assign("forums_list",$forums_list);
}

?>