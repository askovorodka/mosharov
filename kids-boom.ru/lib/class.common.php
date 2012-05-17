<?php

class Common {

	
	function generate_main_menu($level=0) {

		global $db;
		
		$content = array();

		$level_str="";
		if ($level>0) {
			
			$level_str="param_level BETWEEN 0 AND $level AND";
		}

		//$res=$db->get_all("SELECT * FROM fw_tree WHERE $level_str in_menu='1' AND status='1' ORDER BY param_left");
		$res=$db->get_all("SELECT * FROM fw_tree WHERE $level_str status='1' ORDER BY param_left");

		$content=Common::generate_menu($res, $res[0]['param_left'], $res[0]['param_right']);

		$modules = array('shop','cabinet','site_map');
		foreach ($content as $value)
		{ 
			if ($value['param_level']==1)
			{ 
				if (!in_array($value['module'], $modules))
				{ 
					$modules[$value['url']]=$value['module'];
				}
			}
		}

		if (in_array("shop", $modules)) {
			
			$shop_menu=$db->get_all("SELECT id,name,url,param_left,param_right,(param_level+1) as param_level,'shop' as module,'1' as status FROM fw_catalogue WHERE status='1' ORDER BY param_left");
			$shop_menu=Common::generate_menu($shop_menu, $shop_menu[0]['param_left'], $shop_menu[0]['param_right']);
			//print_r($shop_menu);
			$content=MyArray::insert_array_into_array($content,	$shop_menu, "shop");
		}

		if (in_array("forum", $modules)) {
			$forum_menu=$db->get_all("SELECT id,name,url,param_left,param_right,(param_level+1) as param_level,'forum' as module,status FROM fw_forums WHERE status='1' ORDER BY param_left");
			$forum_menu=Common::generate_menu($forum_menu, $forum_menu[0]['param_left'], $forum_menu[0]['param_right']);

			$content=MyArray::insert_array_into_array($content,	$forum_menu, "forum");
		}

		if (in_array("news", $modules)) {
			$news_menu=$db->get_all("SELECT id,title as name,CONCAT('archive','/',id) as url,'1' as param_left,'2' as param_right,'2' as param_level,'news' as module,'1' as status FROM fw_news ORDER BY publish_date DESC");

			$content=MyArray::insert_array_into_array($content,	$news_menu, "news");
		}

		/*if (in_array("cabinet", $modules)) {
			
			$cabinet_menu=array(
				array(
					"id" => "1",
					"name" => "Âõîä â ñèñòåìó",
					"url" => "login",
					"param_left" => "1",
					"param_right" => "2",
					"param_level" => "2",
					"module" => "cabinet",
					"status" => "1"
				),

					array(
					"id" => "3",
					"name" => "Âûïîëíåííûå çàêàçû",
					"url" => "orders",
					"param_left" => "5",
					"param_right" => "6",
					"param_level" => "2",
					"module" => "cabinet",
					"status" => "1"
				),

				array(
					"id" => "4",
					"name" => "Ðåãèñòðàöèÿ",
					"url" => "register",
					"param_left" => "7",
					"param_right" => "8",
					"param_level" => "2",
					"module" => "cabinet",
					"status" => "1"
				),
				array(
					"id" => "5",
					"name" => "Âûéòè èç ñèñòåìû",
					"url" => "logout",
					"param_left" => "9",
					"param_right" => "10",
					"param_level" => "2",
					"module" => "cabinet",
					"status" => "1"
				)
			);
			$content=MyArray::insert_array_into_array($content,	$cabinet_menu, "cabinet");
		}*/

		$full_url="/";
		$_tmp_full_url=$full_url;

		$content=Common::generate_main_menu_full_url($content, $full_url);

		return $content;
	}

	function generate_main_menu_full_url($array, $url) {
		foreach ($array as $key => $value) {
			$full_url=$url.$array[$key]['url']."/";
			$array[$key]['full_url']=$full_url;
			if (isset($array[$key]['sublist'])) $array[$key]['sublist']=Common::generate_main_menu_full_url($array[$key]['sublist'], $full_url);
		}
		return $array;
	}
	
	function generate_menu($array, $start, $finish, $full_url='') {

		$ar = array();
		foreach ($array as $val) {
			if ($val['param_left']==$start) {
				$level=$val['param_level'];
				break;
			}
		}

		foreach ($array as $value) {
			if ($value['param_left']>$start && $value['param_right']<$finish && $value['param_level']==($level+1)) {
				if (($value['param_right']-$value['param_left'])>1) {
					$value['sublist']=Common::generate_menu($array, $value['param_left'], $value['param_right'], &$full_url);
				}
				$ar[] = $value;
			}
		}

		return $ar;
	}

	function load_config($section='') {
	
		global $db;
	
		if ($section == 'front') $cond="WHERE section!='admin'";
		if ($section == 'admin') $cond="WHERE section!='front'";
		$result=$db->query("SELECT * FROM fw_conf $cond");
		while ($data=mysql_fetch_assoc($result)) {
			if (!defined($data["conf_key"])) define($data["conf_key"],$data["conf_value"]);
		}
	
	}
	
	
	function check_auth($where='admin') {
		
		global $db;
	
		if (!@$_COOKIE['fw_login_cookie']) {
			return '0';
		}
		else {
	
			if (!isset($_SESSION['fw_user']['login'])) {

				list($logged_user,$logged_password)=explode("|",$_COOKIE['fw_login_cookie']);
	
				$content=$db->get_single("SELECT * FROM fw_users WHERE login='$logged_user' AND status='1'");
				$password_to_check=@$content['password'];
				if (empty($password_to_check)) {
					return '0';
				}
				else {
	
					if ($logged_password!=$password_to_check) {
						return '0';
					}
					else {
						$_SESSION['fw_user']=$content;
						if ($where=='admin' && (!isset($content['priv']) && $content['priv']>=9)) return '0';
						else return $content['id'];
					}
				}
			}
			else {

				if ($where=='admin' && (!isset($_SESSION['fw_user']['priv']) || $_SESSION['fw_user']['priv']>=9)) return '0';
				else
				{ 

					$content = $db->get_single("SELECT * FROM fw_users WHERE login='{$_SESSION['fw_user']['login']}' and password='{$_SESSION['fw_user']['password']}' AND status='1'");
					if (!empty($content['id']))
					{
						return $content['id'];
						
					}
					else
					{
						$_SESSION['fw_user']="";
						return '0';
					}
					
				}
			}
		}
	
	}
	
	function check_priv ($priv) {
	
		if (isset($_SESSION['fw_user']) && $_SESSION['fw_user']['priv']<=$priv) return true;
		else {
			die('ó ò¥È §¾º¢Èò¥ò¢Ï§¢ ÿ½¥ò ºûÿ òûÿ¢û§¾§¼ÿ º¥§§¢ó¢ º¾ùÈòò¼ÿ');
		}
	}
	
	function get_nodes_list($array,$type=true,$itself="") {
		
		$temp_path='';
		$temp_url='';
		$temp_level=1;

		$list[]=array('full_title'=>'/','full_url'=>'/')+$array[0];

		for ($i=0;$i<count($array);$i++) {
			if (!isset($array[$i]['module'])) $array[$i]['module']='1';
			if (($array[$i]['id']!=$itself) && ($array[$i]['module']==$type) && ($array[$i]['param_level']!=0)) {
				if ($array[$i]['param_level']==1) {
					$temp_path='';
					$temp_url='';
					$temp_level=1;
					$list[]=array('full_title'=>$array[$i]['name']." / ",'full_url'=>$array[$i]['url']."/")+$array[$i];
					$temp_path .= $array[$i]['name']." / ";
					$temp_url .= $array[$i]['url']."/";
				}
				else {
					if ($array[$i]['param_level']>$temp_level) {
						$temp_level=$array[$i]['param_level'];
						$temp_path.=$array[$i]['name']." / ";
						$temp_url.=$array[$i]['url']."/";
						$list[]=array('full_title'=>$temp_path,'full_url'=>$temp_url)+$array[$i];
					}
					else {
						$dif=$temp_level-$array[$i]['param_level']+2;
						$temp_level=$array[$i]['param_level'];
						$p=explode(" / ",$temp_path);
						for ($d=0;$d<$dif;$d++) {
							unset($p[count($p)-1]);
						}
						$temp_path=implode(" / ",$p);
						$temp_path.=" / ".$array[$i]['name']." / ";

						$u=explode("/",$temp_url);
						for ($d=0;$d<$dif;$d++) {
							unset($u[count($u)-1]);
						}
						$temp_url=implode("/",$u);
						$temp_url.="/".$array[$i]['url']."/";

						$list[]=array('full_title'=>$temp_path,'full_url'=>$temp_url)+$array[$i];
					}
				}
			}
		}
		return $list;
	}
	
	function pager($result,$per_page,$current_page) {

		if (is_resource($result)) {
			$count = mysql_fetch_row($result);
			$count=$count[0];
		}
		else $count=$result;
		$total_pages=$count / $per_page;
		$total_pages=ceil($total_pages);
	
		$limit=($current_page-1)*$per_page.','.$per_page;
	
		$start=$current_page-3;
		if ($start<=0) {
			$start=1;
			$stop=$current_page+(8-$current_page);
		}
		else $stop=$current_page+4;
		if ($stop>$total_pages) {
			if ($start>1) $start=$total_pages-6;
			$stop=$total_pages+1;
		}
	
		if ($start<=0) $start=1;
	
		$pages=array();
	
		for($i=$start;$i<$stop;$i++) {
			$pages[]=$i;
		}
		$p['current_page']=$current_page;
		$p['total_pages']=$total_pages;
		$p['pages']=$pages;
		$p['limit']=$limit;
		return $p;

	}
	
	function get_cond ($temp_cond) {
		$cond='';
		for ($i=0;$i<count($temp_cond);$i++) {
			if ($i==0) $cond.="WHERE ";
			if ($i+1!=count($temp_cond)) $cond.=$temp_cond[$i]." AND ";
			else $cond.=$temp_cond[$i];
		}
		return $cond;
	}
	
	function get_url($url,$path) {
		$url=str_replace($path,"",$url);
		$url=str_replace("/"," ",$url);
		$url=trim($url);
		$url=mysql_real_escape_string($url);
		$url=explode(" ",$url);
		return $url;
	}
	
	function dumper($var,$die='0') {
		echo "<pre>";
		print_r($var);
		echo "</pre>";
		if ($die=='1') die();
	}
	
	function check_node_auth ($access) {

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
	
		return $text;
	
	}
	
	function strip_forum_tags($text) {
		
		$text=str_replace("\n","[br]",$text);
		$text=str_replace("\r","",$text);
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
		
		return $text;
	}
}
?>