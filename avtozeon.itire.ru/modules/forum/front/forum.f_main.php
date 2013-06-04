<?php

require BASE_PATH.'/lib/class.mail.php';
require_once BASE_PATH.'/lib/class.image.php';

$smarty->assign("photos_folder",USER_PHOTOS_FOLDER);

$smarty->assign("base_path",BASE_PATH);
$css[]=BASE_URL.'/modules/forum/front/templates/forum.css';

$navigation[]=array("url" => $module_url,"title" => $node_content['name']);
$smarty->assign("module_url",BASE_URL.'/'.$module_url);

$limit_time=time()-604800;

if (isset($_SESSION['fw_user']) && !isset($_SESSION['fw_user']['forum_clean'])) {

	$db->query("DELETE FROM fw_forum_vp WHERE view_time<$limit_time");

	$_SESSION['fw_user']['forum_clean']=true;
}

if (isset($_SESSION['fw_user'])) {
	$all_forums=$db->get_all("SELECT *,
										(SELECT url FROM fw_tree WHERE module='cabinet' AND id<>62) AS cabinet,
										(SELECT publish_date FROM fw_forum_posts WHERE parent IN (SELECT id FROM fw_forum_threads WHERE parent=f.id) ORDER BY publish_date DESC LIMIT 1) AS last_date,
										(SELECT id FROM fw_forum_posts WHERE parent IN (SELECT id FROM fw_forum_threads WHERE parent IN (SELECT id FROM fw_forums WHERE param_left>f.param_left AND param_right<f.param_right) OR parent=f.id) AND publish_date>'".$_SESSION['fw_user']['reg_date']."' AND publish_date>'$limit_time' AND parent NOT IN (SELECT thread_id FROM fw_forum_vp WHERE forum_id=f.id) ORDER BY publish_date DESC LIMIT 1) AS last_reg,
										(SELECT thread_id FROM fw_forum_vp v WHERE v.view_time<(SELECT publish_date FROM fw_forum_posts WHERE parent=v.thread_id ORDER BY publish_date DESC LIMIT 1) AND (forum_id IN (SELECT id FROM fw_forums WHERE param_left>f.param_left AND param_right<f.param_right) OR forum_id=f.id) AND v.user_id='".$_SESSION['fw_user']['id']."' LIMIT 1) AS last_view,
										(SELECT COUNT(*) FROM fw_forum_threads WHERE parent=f.id AND status='1') AS threads
										FROM fw_forums f WHERE f.status='1' ORDER BY param_left");
}
else {
	$all_forums=$db->get_all("SELECT *,
										(SELECT url FROM fw_tree WHERE module='cabinet' LIMIT 1) AS cabinet,
										(SELECT publish_date FROM fw_forum_posts WHERE parent IN (SELECT id FROM fw_forum_threads WHERE parent=f.id) ORDER BY publish_date DESC LIMIT 1) AS last_date,
										(SELECT COUNT(*) FROM fw_forum_threads WHERE parent=f.id AND status='1') AS threads
										FROM fw_forums f WHERE f.status='1' ORDER BY param_left");
}

$all_forums=String::unformat_array($all_forums,'front');
$smarty->assign("cabinet_url",$all_forums[0]['cabinet']);

//Common::dumper($all_forums);

$check_auth=false;

if (count($_GET)>0) {
	unset($url[$n]);
	unset($current_url_pages[count($current_url_pages)-1]);
	$n=count($url)-1;

}

$this_module=$db->get_single("SELECT priv FROM fw_modules WHERE name='forum' LIMIT 1");

//-------------------------- ЛОГИН ПОЛЬЗОВАТЕЛЯ В ФОРУМЕ ---------------------------

if (isset($_SESSION['fw_user'])) {

	$smarty->assign("logged_user",$_SESSION['fw_user']);
	$is_admin=true;

	$status='0';

	if (isset($_SESSION['fw_user']) && $_SESSION['fw_user']['priv']<=$this_module['priv']) $smarty->assign("show_admin_menu","true");

	if (FORUM_PREMODERATION=='on') {

		$pre_threads=$db->get_all("SELECT * FROM fw_forum_threads WHERE status='0' OR id IN (SELECT parent FROM fw_forum_threads WHERE status='0')");

		$smarty->assign("pre_threads",count($pre_threads));
	}

}
else $status='1';

//------------------------------- ВНУТРЕННИЕ ФУНКЦИИ -------------------------------

function check_forum_auth ($access) {

	if ($access=='all') return true;
	else if ($access=='registered' && isset($_SESSION['fw_user'])) return true;
	else {
		$access=explode(",",$access);
		if (isset($_SESSION['fw_user']) && in_array($_SESSION['fw_user']['id'],$access)) return true;
		else return false;
	}
}

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

//------------------------------- РАЗЛИЧНЫЕ ДЕЙСТВИЯ -------------------------------
if (isset($_POST['submit_new_thread'])) {

	$check=true;

	for ($i=0;$i<sizeof($all_forums);$i++) {
		if ($all_forums[$i]['id']==$_POST['forum_id']) $forum_content=$all_forums[$i];
	}

	$check_auth=check_forum_auth($forum_content['write_users']);

	if (!$check_auth) die("Вы не можете писать в этот форум");

	if (isset($_POST['nt_name'])) {

		if (preg_match("/^[0-9]*$/",$_POST['nt_name'])) {

			$smarty->assign("error_message","Вы ввели недопустимое имя!");

			$smarty_tmp['name']=$_POST['nt_name'];
			$smarty_tmp['mail']=$_POST['nt_mail'];
			$smarty_tmp['title']=$_POST['nt_title'];
			$smarty_tmp['text']=$_POST['nt_text'];

			$smarty->assign("tmp",$smarty_tmp);

			$check=false;
		}
		else {
			$author=String::secure_user_input($_POST['nt_name']);
		}
	}
	else $author=$_SESSION['fw_user']['id'];

	if ($_POST['nt_text']=='' or $_POST['nt_title']=='') {

		$smarty->assign("error_message","Вы не заполнили обязательные поля!");

		$smarty_tmp['name']=$_POST['nt_name'];
		$smarty_tmp['mail']=$_POST['nt_mail'];
		$smarty_tmp['title']=$_POST['nt_title'];
		$smarty_tmp['text']=$_POST['nt_text'];

		$smarty->assign("tmp",$smarty_tmp);

		$check=false;
	}


	if (isset($_POST['nt_code'])) {
		if (!preg_match("/^[a-zA-Z0-9]+$/",$_POST['nt_code'])) {
			$smarty->assign("error_message","Вы ввели недопустимый код на изображении!");
			$smarty_tmp['name']=$_POST['nt_name'];
			$smarty_tmp['mail']=$_POST['nt_mail'];
			$smarty_tmp['title']=$_POST['nt_title'];
			$smarty_tmp['text']=$_POST['nt_text'];
			$smarty->assign("tmp",$smarty_tmp);
			$check=false;
		}
		elseif ($_POST['nt_code'] != $capt->get_code()){
			$smarty->assign("error_message","Вы ввели неправельный код на изображении!");
			$smarty_tmp['name']=$_POST['nt_name'];
			$smarty_tmp['mail']=$_POST['nt_mail'];
			$smarty_tmp['title']=$_POST['nt_title'];
			$smarty_tmp['text']=$_POST['nt_text'];
			$smarty->assign("tmp",$smarty_tmp);
			$check=false;
		}
	}
	else{
			$smarty->assign("error_message","Вы не ввели код на изображении!");
			$smarty_tmp['name']=$_POST['nt_name'];
			$smarty_tmp['mail']=$_POST['nt_mail'];
			$smarty_tmp['title']=$_POST['nt_title'];
			$smarty_tmp['text']=$_POST['nt_text'];
			$smarty->assign("tmp",$smarty_tmp);
			$check=false;
	
	}


	if (isset($_POST['send_answers'])) {
		$send_answers='1';
	}
	else $send_answers='0';

	if ($check) {

		$parent=String::secure_user_input($_POST['forum_id']);

		$title=String::secure_user_input($_POST['nt_title']);
		$text=strip_forum_tags($_POST['nt_text']);

		if (isset($_POST['nt_title2'])) $text=$_POST['nt_title2']."<br><br><br>".$text;


		if (FORUM_PREMODERATION=='on') $set_status='1';
		else $set_status='1';

		$db->query("INSERT INTO fw_forum_threads(parent,title,status,send_answers) VALUES('$parent','$title','$set_status','$send_answers')");
		$db->query("INSERT INTO fw_forum_posts(parent,author,text,publish_date,status) VALUES('".mysql_insert_id()."','$author','$text','".time()."','$set_status')");

		$location=$_SERVER['HTTP_REFERER'];
	//	if (BASE_URL.$_SERVER['REQUEST_URI']==$_SERVER['HTTP_REFERER']) header("Location: $location");
	}
}

if (isset($_POST['submit_new_post'])) {

	$check=true;

	$thread=$db->get_single("SELECT parent,
											(SELECT author FROM fw_forum_posts WHERE parent=t.id ORDER BY publish_date LIMIT 1) AS author,
											(SELECT text FROM fw_forum_posts WHERE parent=t.id ORDER BY publish_date LIMIT 1) AS message
											FROM fw_forum_threads t WHERE t.id='".$_POST['thread_id']."'");

	for ($i=0;$i<sizeof($all_forums);$i++) {
		if ($all_forums[$i]['id']==$thread['parent']) $forum_content=$all_forums[$i];
	}

	$check_auth=check_forum_auth($forum_content['write_users']);

	if (!$check_auth) die("Вы не можете писать в этот форум");

	if (isset($_POST['np_name'])) {

		if (preg_match("/^[0-9]*$/",$_POST['np_name'])) {

			$smarty->assign("error_message","Вы ввели недопустимое имя!");

			$smarty_tmp['name']=$_POST['np_name'];
			$smarty_tmp['text']=$_POST['np_text'];

			$smarty->assign("tmp",$smarty_tmp);

			$check=false;
		}
		else {
			$author=String::secure_user_input($_POST['np_name']);
		}
	}
	else $author=$_SESSION['fw_user']['id'];

	if ($_POST['np_text']=='') {

		$smarty->assign("error_message","Вы не заполнили все обязательные поля!");

		$smarty_tmp['name']=$_POST['np_name'];
		$smarty_tmp['text']=$_POST['np_text'];

		$smarty->assign("tmp",$smarty_tmp);

		$check=false;
	}


	if (isset($_POST['np_code'])) {
		if (!preg_match("/^[a-zA-Z0-9]+$/",$_POST['np_code'])) {
			$smarty->assign("error_message","Вы ввели недопустимый код на изображении!");
			$smarty_tmp['name']=$_POST['np_name'];
			$smarty_tmp['text']=$_POST['np_text'];
			$smarty->assign("tmp",$smarty_tmp);
			$check=false;
		}
		elseif ($_POST['np_code'] != $capt->get_code()){
			$smarty->assign("error_message","Вы ввели неправельный код на изображении!");
			$smarty_tmp['name']=$_POST['np_name'];
			$smarty_tmp['text']=$_POST['np_text'];
			$smarty->assign("tmp",$smarty_tmp);
			$check=false;
		}
	}
	else{
			$smarty->assign("error_message","Вы не ввели код на изображении!");
			$smarty_tmp['name']=$_POST['np_name'];
			$smarty_tmp['text']=$_POST['np_text'];
			$smarty->assign("tmp",$smarty_tmp);
			$check=false;
	
	}

	if ($check) {

		$parent=String::secure_user_input($_POST['thread_id']);

		$get_subscribers=$db->get_all("SELECT * FROM fw_send_forum_answers WHERE thread_id='$parent'");

		//Common::dumper($get_subscribers,1);

		if (count($get_subscribers)>0) {

			$smarty->assign("site_url",BASE_URL);
			$smarty->assign("message",$thread['message']);
			$smarty->assign("reply",$_POST['np_text']);
			$smarty->assign("thread_url",$_SERVER['HTTP_REFERER']);

			$message=$smarty->fetch(BASE_PATH.'/modules/forum/front/templates/send_answer.txt');

			foreach ($get_subscribers as $k=>$v) {

				Mail::send_mail($v['mail'],ADMIN_MAIL,'Новое сообщение в форуме',$message,'','text','standard','Windows-1251');
			}
		}

		$text=strip_forum_tags($_POST['np_text']);

		if (FORUM_PREMODERATION=='on') $set_status='1';
		else $set_status='1';

		$db->query("INSERT INTO fw_forum_posts(parent,author,text,publish_date,status) VALUES('$parent','$author','$text','".time()."','$set_status')");

		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
	}
}


//----------------------------- ОТОБРАЖЕНИЯ КОНТЕНТА -------------------------------

SWITCH (TRUE) {


	CASE (count($url)==1 && isset($_GET['send_answers'])):

		$page_found=true;

		$mail=$_SESSION['fw_user']['mail'];
		$thread_id=$_GET['thread_id'];

		if ($mail!='') {

			if ($_GET['send_answers']=='on') {

				$db->query("INSERT INTO fw_send_forum_answers(thread_id,mail) VALUES('$thread_id','$mail')");

			}
			elseif ($_GET['send_answers']=='off') {

				$db->query("DELETE FROM fw_send_forum_answers WHERE thread_id='$thread_id' AND mail='$mail'");
			}
		}

		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");

	BREAK;


	CASE (count($url)==2 && $url[$n]=='users'):

		$navigation[]=array("url" => 'users',"title" => 'Пользователи форума');

		if (isset($_GET['page']) && $_GET['page']!='') $page=$_GET['page'];
		else $page=1;

		$letters=$db->get_all("SELECT name FROM fw_users GROUP BY UCASE(SUBSTRING(name,1,1)) ORDER BY name");

		$letters_rus=array();
		$letters_eng=array();

		foreach ($letters as $value) {
			$value['name']=strtoupper($value['name']);
			if(preg_match("/[a-z]/i",substr($value['name'],0,1))) $letters_eng[]=$value;
			else $letters_rus[]=$value;
		}

		$smarty->assign("letters_eng", $letters_eng);
		$smarty->assign("letters_rus", $letters_rus);

		if (isset($_GET['letter']) && $_GET['letter']!='') {
			$result=$db->query("SELECT COUNT(*) FROM fw_users u WHERE UPPER(name) LIKE '".strtoupper(urldecode($_GET['letter']))."%'");
		}
		else {
			$result=$db->query("SELECT COUNT(*) FROM fw_users");
		}
		$pager=Common::pager($result,50,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);

		if (isset($_GET['letter']) && $_GET['letter']!='') {

			$smarty->assign("letter",strtolower(urldecode($_GET['letter'])));

			$users_list=$db->get_all("SELECT *,
											(SELECT COUNT(*) FROM fw_forum_posts WHERE author=u.id) AS messages,
											(SELECT COUNT(*) FROM fw_user_images WHERE parent IN (SELECT id FROM fw_user_albums WHERE parent=u.id)) AS photos
	 										FROM fw_users u WHERE UPPER(name) LIKE '".strtoupper(urldecode($_GET['letter']))."%' ORDER BY name LIMIT ".$pager['limit']);
		}
		else {
			$users_list=$db->get_all("SELECT *,
											(SELECT COUNT(*) FROM fw_forum_posts WHERE author=u.id) AS messages,
											(SELECT COUNT(*) FROM fw_user_images WHERE parent IN (SELECT id FROM fw_user_albums WHERE parent=u.id)) AS photos
	 										FROM fw_users u ORDER BY reg_date DESC LIMIT ".$pager['limit']);
		}
		$users_list=String::unformat_array($users_list);
		$smarty->assign("users_list",$users_list);

		$page_found=true;
		$template='users_list.html';

	BREAK;


	CASE (count($url)==2 && $url[$n]=='smiles'):

		$page_found=true;

		$smiles_list=$db->get_all("SELECT * FROM fw_smiles ORDER BY sort_order");

		$smarty->assign("smiles_list",$smiles_list);
		$smarty->assign("window_id",$_GET['id']);

		$template='smiles.html';
		$template_mode='single';

	BREAK;

	CASE (preg_match("/^thread_([0-9]+)/",$url[$n]) or (@preg_match("/^thread_([0-9]+)/",$url[$n-1]) && preg_match("/^page_([0-9]+)/",$url[$n]))):

		require_once BASE_PATH.'/admin/priv.php';

		$all_forums=Common::get_nodes_list($all_forums);
		unset($url[0]);

		if (preg_match("/^page_([0-9]+)$/",$url[$n])) {
			$page=str_replace("page_","",$url[$n]);
			$thread_id=str_replace("thread_","",$url[$n-1]);
			unset($url[$n]);
			unset($url[$n-1]);
			unset($current_url_pages[count($current_url_pages)-1]);
		}
		else {
			$page=1;
			$thread_id=str_replace("thread_","",$url[$n]);
			unset($url[$n]);
		}

		if (isset($_POST['quote'])) {

			$quote=$_POST['quote'];
			$quote=$db->get_single("SELECT text,author,(SELECT name FROM fw_users WHERE id=author LIMIT 1) AS author_name FROM fw_forum_posts WHERE id='$quote'");
			$quote['text']=add_forum_tags($quote['text']);
			if ($quote['author_name']!='') $author=$quote['author_name'];
			else $author=$quote['author'];
			$smarty_tmp['text']="[QUOTE][B]".$author.":[/B]\n".$quote['text']."[/QUOTE]";
			$smarty->assign("tmp",$smarty_tmp);
		}

		if (isset($_SESSION['fw_user'])){
			$check_mail=", (SELECT mail FROM fw_send_forum_answers WHERE thread_id=t.id AND mail='".$_SESSION['fw_user']['mail']."') AS check_mail";
		}
		else
			$check_mail="";

		$thread=$db->get_single("SELECT *,
											(SELECT id FROM fw_forum_posts WHERE parent=t.id ORDER BY publish_date LIMIT 1) AS thread_post
											$check_mail
										 FROM fw_forum_threads t WHERE t.id='$thread_id' AND status>='$status' LIMIT 1");
		$thread=String::unformat_array($thread,'front');


		for ($f=0;$f<count($all_forums);$f++) {
			$url_to_check=implode("/",$url).'/';
			if ($all_forums[$f]['full_url']==$url_to_check && $all_forums[$f]['id']==$thread['parent']) {
				$forum_content=$all_forums[$f];
				$page_found=true;

				$page_title=$thread['title'];

				$smiles_list=$db->get_all("SELECT * FROM fw_smiles ORDER BY sort_order LIMIT 20");

				$smarty->assign("smiles_list",$smiles_list);

				if (isset($_SESSION['fw_user'])) {

					$check_vp=$db->get_single("SELECT * FROM fw_forum_vp WHERE thread_id='".$thread['id']."' AND user_id='".$_SESSION['fw_user']['id']."'");
					if ($check_vp['user_id']!='') {
						$db->query("UPDATE fw_forum_vp SET view_time='".time()."' WHERE thread_id='".$thread['id']."' AND user_id='".$_SESSION['fw_user']['id']."'");
					}
					else {

						$db->query("INSERT INTO fw_forum_vp(view_time,user_id,thread_id,forum_id) VALUES('".time()."','".$_SESSION['fw_user']['id']."','".$thread['id']."','".$forum_content['id']."')");

					}
				}

				$check_auth=check_forum_auth($forum_content['read_users']);
				$check_write_auth=check_forum_auth($forum_content['write_users']);

				if ($check_write_auth) $smarty->assign("write_auth","true");

				$result=$db->query("SELECT COUNT(*) FROM fw_forum_posts WHERE parent='$thread_id'");
				$pager=Common::pager($result,POSTS_PER_PAGE,$page);

				$smarty->assign("total_pages",$pager['total_pages']);
				$smarty->assign("current_page",$pager['current_page']);
				$smarty->assign("pages",$pager['pages']);

				$posts_list=$db->get_all("SELECT *,
												(SELECT id FROM fw_users WHERE id=p.author LIMIT 1) AS author_id,
												(SELECT name FROM fw_users WHERE id=p.author LIMIT 1) AS author_name,
												(SELECT grade FROM fw_users WHERE id=p.author LIMIT 1) AS author_grade,
												(SELECT signature FROM fw_users WHERE id=p.author LIMIT 1) AS author_signature,
												(SELECT reg_date FROM fw_users WHERE id=p.author LIMIT 1) AS reg_date,
												(SELECT avatar FROM fw_users WHERE id=p.author LIMIT 1) AS avatar,
												(SELECT COUNT(*) FROM fw_forum_posts WHERE author=author_id LIMIT 1) AS posts_count,
												(SELECT priv FROM fw_users WHERE id=p.author LIMIT 1) AS priv
												FROM fw_forum_posts p WHERE p.parent='$thread_id' AND status>='$status' ORDER BY p.publish_date LIMIT ".$pager['limit']);

				$smiles_list=$db->get_all("SELECT * FROM fw_smiles ORDER BY sort_order");

				for ($i=0;$i<count($posts_list);$i++) {
					$posts_list[$i]['priv']=str_replace($priv_value,$priv_name,$posts_list[$i]['priv']);
					$posts_list[$i]['text']=String::unformat($posts_list[$i]['text'],'front');

					foreach ($smiles_list as $k=>$v) {
						$posts_list[$i]['text']=str_replace($v['symbol'],"<img src=".BASE_URL."/uploaded_files/smiles/".$v['id'].'.'.$v['image'].">",$posts_list[$i]['text']);
					}
				}

				if (isset($thread['check_mail']) && $thread['check_mail']!='') $smarty->assign("send_forum_answers",true);

				$smarty->assign("thread",$thread);
				$smarty->assign("posts_list",$posts_list);

				$db->query("UPDATE fw_forum_threads SET views=views+1 WHERE id='".$thread['id']."'");

				//if ($forum_content['title']!='') $page_title=$forum_content['title'];

				if ($forum_content['full_title']!='/') {
					$nav_titles=explode("/",$forum_content['full_title']);
					$nav_urls=explode("/",$forum_content['full_url']);
					unset($nav_titles[count($nav_titles)-1]);
					unset($nav_urls[count($nav_urls)-1]);
					for ($l=0;$l<count($nav_titles);$l++) {
						$navigation[]=array("url" => $nav_urls[$l],"title" => trim($nav_titles[$l]));
					}
				}
				$navigation[]=array("url" => $thread['id'],"title" => $thread['title']);
				if ($check_auth) $template='posts_list.html';
				else $template='deny_access.html';
			}
		}

	BREAK;
	
	CASE ($url[$n]=='view_captcha' && count($url)==2):
		$page_found=true;
		$capt->display();
	BREAK;

	CASE ($url[$n]=='premoderation' && count($url)==2):

		$page_found=true;

		$navigation[]=array("url" => 'premoderation',"title" => 'Премодерация');

		$pre_threads=$db->get_all("SELECT * FROM fw_forum_threads WHERE status='0' OR id IN (SELECT parent FROM fw_forum_threads WHERE status='0')");

		$all_forums=Common::get_nodes_list($all_forums);

		for ($i=0;$i<sizeof($pre_threads);$i++) {
			foreach ($all_forums as $k=>$v) {
				if ($v['id']==$pre_threads[$i]['parent']) $pre_threads[$i]['full_url']=$v['full_url'].'thread_'.$pre_threads[$i]['id'];
			}
		}

		$smarty->assign("pre_threads",$pre_threads);

		$template='premoderation.html';

	BREAK;

	CASE (count($url)==3 && $url[$n-1]=='info' && preg_match("/^[0-9]*$/",$url[$n])):

		$navigation[]=array("url" => 'info',"title" => 'Информация о пользователе');

		$id=$url[$n];

		$info=$db->get_single("SELECT * FROM fw_users WHERE id='$id'");
		$info=String::unformat_array($info);
		$smarty->assign("info",$info);

		$pp=$db->get_all("SELECT th.* FROM fw_forum_posts AS po LEFT JOIN fw_forum_threads AS th ON po.parent=th.id AND th.status='1' AND po.status='1' WHERE th.parent='10' AND po.author='".$info['id']."' AND po.publish_date=(SELECT publish_date FROM fw_forum_posts WHERE parent=po.parent AND status='1' ORDER BY publish_date LIMIT 1)");

		$all_forums=Common::get_nodes_list($all_forums);

		for ($i=0;$i<sizeof($pp);$i++) {
			foreach ($all_forums as $k=>$v) {
				if ($v['id']==$pp[$i]['parent']) $pp[$i]['full_url']=$v['full_url'].'thread_'.$pp[$i]['id'];
			}
		}

		$smarty->assign("pp", $pp);

		$page_found=true;
		$template='user_info.html';

	BREAK;


	CASE (count($url)==4 && $url[$n-2]=='info' && $url[$n]=='albums' && preg_match("/^[0-9]*$/",$url[$n-1])):

		$id=$url[$n-1];

		$navigation[]=array("url" => 'info/'.$id,"title" => 'Информация о пользователе');
		$navigation[]=array("url" => 'albums',"title" => 'Фотоальбомы');

		$photoalbums_list=$db->get_all("SELECT * FROM fw_user_albums WHERE parent='$id' ORDER BY sort_order");

		$smarty->assign("photoalbums_list",$photoalbums_list);

		$page_found=true;
		$template='user_albums_list.html';

	BREAK;

	CASE (count($url)==5 && $url[$n-3]=='info' && $url[$n-1]=='albums' && preg_match("/^[0-9]*$/",$url[$n-2]) && preg_match("/^[0-9]*$/",$url[$n])):

		$user_id=$url[$n-2];
		$album_id=$url[$n];

		$navigation[]=array("url" => 'info/'.$user_id,"title" => 'Информация о пользователе');
		$navigation[]=array("url" => 'albums',"title" => 'Фотоальбомы');

		if (isset($_GET['page'])) {
			$page=$_GET['page'];
		}
		else {
			$page=1;
		}


		$album=$db->get_single("SELECT *,(SELECT COUNT(*) FROM fw_user_images WHERE parent='$album_id') AS count FROM fw_user_albums WHERE id='$album_id'");

		if (isset($album['id'])) {

			$page_found=true;

			$navigation[]=array("url" => $album['id'],"title" => $album['name']);

			$pager=Common::pager($album['count'],PHOTOS_PER_PAGE,$page);

			$photos_list=$db->get_all("SELECT * FROM fw_user_images WHERE parent='$album_id' ORDER BY sort_order LIMIT ".$pager['limit']);

			for ($i=0;$i<sizeof($photos_list);$i++) {
				$output=Image::image_details(BASE_PATH.'/'.USER_PHOTOS_FOLDER.'/'.$photos_list[$i]['id'].'.'.$photos_list[$i]['ext']);
				$photos_list[$i]['width']=$output['width']+20;
				$photos_list[$i]['height']=$output['height']+20;
			}

			$smarty->assign("total_pages",$pager['total_pages']);
			$smarty->assign("current_page",$pager['current_page']);
			$smarty->assign("pages",$pager['pages']);

			$smarty->assign("total_photos",count($photos_list));

			$smarty->assign("album",$album);
			$smarty->assign("photos_list",$photos_list);

			$template='show_photoalbum.html';
		}

	BREAK;

	DEFAULT:

		$all_forums=Common::get_nodes_list($all_forums);
		unset($url[0]);

		if (@preg_match("/^page_([0-9]+)$/",$url[$n])) {
			list(,$page)=explode("_",$url[$n]);
			unset($url[$n]);
			unset($current_url_pages[count($current_url_pages)-1]);
		}
		else $page=1;

		for ($f=0;$f<count($all_forums);$f++) {
			$url_to_check=implode("/",$url).'/';
			if ($all_forums[$f]['full_url']==$url_to_check) {
				$forum_content=$all_forums[$f];
				$page_found=true;

				$smiles_list=$db->get_all("SELECT * FROM fw_smiles ORDER BY sort_order LIMIT 20");

				$smarty->assign("smiles_list",$smiles_list);

				$check_auth=check_forum_auth($forum_content['read_users']);
				$check_write_auth=check_forum_auth($forum_content['write_users']);

				if ($check_write_auth) $smarty->assign("write_auth","true");

				if ($check_auth) {

					for ($i=0;$i<sizeof($all_forums);$i++) {
						if ($all_forums[$i]['param_left']>$forum_content['param_left'] && $all_forums[$i]['param_right']<$forum_content['param_right'] && $all_forums[$i]['param_level']==$forum_content['param_level']+1) $forums_list[]=$all_forums[$i];
					}

					if ($forum_content['param_level']>0) {

						$result=$db->query("SELECT COUNT(*) FROM fw_forum_threads WHERE parent='".$forum_content['id']."'");
						$pager=Common::pager($result,THREADS_PER_PAGE,$page);

						$smarty->assign("total_pages",$pager['total_pages']);
						$smarty->assign("current_page",$pager['current_page']);
						$smarty->assign("pages",$pager['pages']);

						if (isset($_SESSION['fw_user'])) {
							$threads_list=$db->get_all("SELECT *,
																(SELECT author FROM fw_forum_posts WHERE parent=t.id ORDER BY publish_date LIMIT 1) AS author,
																(SELECT login FROM fw_users WHERE id=author LIMIT 1) AS author_login,
																(SELECT id FROM fw_users WHERE id=author LIMIT 1) AS author_id,
																(SELECT name FROM fw_users WHERE id=author LIMIT 1) AS author_name,
																(SELECT COUNT(*)-1 FROM fw_forum_posts WHERE parent=t.id) AS count,
																(SELECT COUNT(*) FROM fw_forum_posts WHERE parent=t.id) AS pcount,
																(SELECT id FROM fw_forum_posts WHERE parent=t.id AND publish_date>(SELECT view_time FROM fw_forum_vp WHERE thread_id=t.id AND user_id='".$_SESSION['fw_user']['id']."' LIMIT 1) LIMIT 1) AS last_view,
																(SELECT id FROM fw_forum_posts WHERE parent=t.id AND publish_date>'".$_SESSION['fw_user']['reg_date']."' AND publish_date>'$limit_time' AND author<>'".$_SESSION['fw_user']['id']."' AND parent NOT IN(SELECT thread_id FROM fw_forum_vp WHERE forum_id='".$forum_content['id']."') LIMIT 1) AS last_reg,
																(SELECT publish_date FROM fw_forum_posts WHERE parent=t.id ORDER BY publish_date DESC LIMIT 1) AS last_date,
																(SELECT author FROM fw_forum_posts WHERE parent=t.id ORDER BY publish_date DESC LIMIT 1) AS last_author_id,
																(SELECT name FROM fw_users WHERE id=last_author_id) AS last_author
																FROM fw_forum_threads t WHERE t.parent='".$forum_content['id']."' AND status>='$status' ORDER BY top DESC,last_date DESC LIMIT ".$pager['limit']);
						}
						else {
							$threads_list=$db->get_all("SELECT *,
																(SELECT author FROM fw_forum_posts WHERE parent=t.id ORDER BY publish_date LIMIT 1) AS author,
																(SELECT login FROM fw_users WHERE id=author LIMIT 1) AS author_login,
																(SELECT id FROM fw_users WHERE id=author LIMIT 1) AS author_id,
																(SELECT name FROM fw_users WHERE id=author LIMIT 1) AS author_name,
																(SELECT COUNT(*)-1 FROM fw_forum_posts WHERE parent=t.id) AS count,
																(SELECT COUNT(*) FROM fw_forum_posts WHERE parent=t.id) AS pcount,
																(SELECT publish_date FROM fw_forum_posts WHERE parent=t.id ORDER BY publish_date DESC LIMIT 1) AS last_date,
																(SELECT author FROM fw_forum_posts WHERE parent=t.id ORDER BY publish_date DESC LIMIT 1) AS last_author_id,
																(SELECT name FROM fw_users WHERE id=last_author_id) AS last_author
																FROM fw_forum_threads t WHERE t.parent='".$forum_content['id']."' AND status>='$status' ORDER BY top DESC,last_date DESC LIMIT ".$pager['limit']);

						}

						for ($i=0;$i<sizeof($threads_list);$i++) {

							$tpager=Common::pager($threads_list[$i]['pcount'],POSTS_PER_PAGE,1);

							$threads_list[$i]['pages']=$tpager['pages'];
							$threads_list[$i]['total_pages']=$tpager['total_pages'];
						}

						$smarty->assign("threads_list",$threads_list);
						$smarty->assign("forum_content",$forum_content);
					}
					else $smarty->assign("main_forum",true);

					if (isset($forums_list)) {

						if (isset($_SESSION['fw_user'])) {

							for ($l=0;$l<sizeof($forums_list);$l++) {
								$forums_list[$l]['id_list']=$forums_list[$l]['id'].',';
								for ($i=0;$i<sizeof($all_forums);$i++) {
									if ($all_forums[$i]['param_left']>$forums_list[$l]['param_left'] && $all_forums[$i]['param_right']<$forums_list[$l]['param_right']) $forums_list[$l]['id_list'].=$all_forums[$i]['id'].',';
								}
								$forums_list[$l]['id_list']=substr($forums_list[$l]['id_list'],0,-1);
							}

						}
						$smarty->assign("forums_list",$forums_list);
					}

					if ($forum_content['title']!='') $page_title=$forum_content['title'];

					if ($forum_content['full_title']!='/') {
						$nav_titles=explode("/",$forum_content['full_title']);
						$nav_urls=explode("/",$forum_content['full_url']);
						unset($nav_titles[count($nav_titles)-1]);
						unset($nav_urls[count($nav_urls)-1]);
						for ($l=0;$l<count($nav_titles);$l++) {
							$navigation[]=array("url" => $nav_urls[$l],"title" => trim($nav_titles[$l]));
						}
					}
				}

				if ($check_auth) $template='main_forums_list.html';
				else $template='deny_access.html';
				break;
			}
		}

	BREAK;
}

?>