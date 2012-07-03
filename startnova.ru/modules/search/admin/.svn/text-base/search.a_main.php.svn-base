<?php

set_time_limit(20);

if (isset($_GET['action'])) $action=$_GET['action'];
else $action='';

if (isset($_GET['do']) && $_GET['do']=='update_search_index') {

	$host=str_replace("http://","",BASE_URL);

	$_SESSION['fw_search_count']=0;

	if (!isset($_GET['next'])) {
		unset($_SESSION['fw_links_list']);
		unset($_SESSION['fw_index_list']);
		$_SESSION['fw_search_time']=0;
	}

	$root_url=BASE_URL;
	$local_check=str_replace("http://","",$root_url);
	$local_check=str_replace("www.","",$local_check);

	$noindex=file_get_contents(BASE_PATH.'/modules/search/noindex.txt');
	$noindex=explode("\n",$noindex);
	$noindex=str_replace("\r","",$noindex);
	$noindex=array_diff($noindex,array(''));

	function get_page ($url) {

		$_SESSION['fw_search_count']++;

		global $links_list;
		global $index_list;
		global $local_check;
		global $db;
		global $error404;
		global $noindex;
		global $start_time;

		$link_matches=array();
		$page='';
		$can_process=true;

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

		$page=curl_exec($curl);

		$result=curl_getinfo($curl);
		curl_close($curl);

		if ($page!='' && in_array($result['http_code'], array('200','302','301'))) {

			preg_match_all("/<a[^>]*?href\s*=\s*[\"\'\s]*([^\s\"\'>]+)/i",$page,$link_matches);
			preg_match("/<title>([^<]*)<\/title>/i",$page,$title);
			preg_replace("/<title>[^<]*<\/title>/i","",$page);
			if (isset($title[1])) $title=$title[1];
			else $title='';

			//----------------------------ИНДЕКСАЦИЯ-----------------------------------
			$page=str_replace("\r"," ",$page);
			$page=str_replace("\n"," ",$page);
			$page=preg_replace("/<!--[^>]+?-->/i"," ",$page);
			$page=preg_replace("/<script[^>]*>[^>]+?<\/script>/im"," ",$page);
			$page=preg_replace("/<skip>[^$]+?<\/skip>/im"," ",$page);
			$page=preg_replace("/<[^>]*>/i"," ",$page);
			$page=preg_replace("/<\/[^>]*>/i"," ",$page);
			$page=preg_replace("/\s+/"," ",$page);
			$page=str_replace('&nbsp;',"",$page);

			$page=mysql_real_escape_string($page);
			$title=mysql_real_escape_string($title);

			$sqlurl=$result['url'];
			$index_list[]=$url;

			$db->query("REPLACE INTO fw_search(url,title,content) VALUES('$sqlurl','$title','$page')");

			//-------------------------------------------------------------------------

			$tmp_list=$link_matches[1];
	 		for ($i=0;$i<sizeof($tmp_list);$i++) {
	 			$check=true;
	 			if (substr($tmp_list[$i],-1)=='/') $tmp_list[$i]=substr($tmp_list[$i],0,-1);
	 			if (substr($tmp_list[$i],0,1)=='/') $tmp_list[$i]=substr($tmp_list[$i],1);
				if (!stristr($tmp_list[$i],'http://')) $tmp_list[$i]=BASE_URL.'/'.$tmp_list[$i];

				$ext=substr($tmp_list[$i],-4);

				if (in_array($tmp_list[$i],$links_list) || in_array($tmp_list[$i],$index_list) || $tmp_list[$i]==BASE_URL || $tmp_list[$i]==BASE_URL.'/#' || !stristr($tmp_list[$i],$local_check) || preg_match("/^\.[a-z]{3}$/",$ext)) {
					$check=false;
				}

				foreach ($noindex as $k=>$v) {
					if (stristr($tmp_list[$i],$v)) $check=false;
				}

				if ($check)	$links_list[]=$tmp_list[$i];
			}
		}

		if ($_SESSION['fw_search_count']>=50 && isset($links_list[0]) && strlen($links_list[0])>=strlen(BASE_URL)) {

			$_SESSION['fw_links_list']=serialize($links_list);
			$_SESSION['fw_index_list']=serialize($index_list);

			$end_time=time();
			$result_time=$end_time-$start_time;

			$_SESSION['fw_search_time']+=$result_time;

			$location=BASE_URL.'/admin/index.php?mod=search&action=index&do=update_search_index&next=true';
			header("Location: $location");
			die();
		}

		if (isset($links_list[0]) && strlen($links_list[0])>=strlen(BASE_URL)) {
			$goto=$links_list[0];
			$links_list=MyArray::unset_element($links_list,0);
			get_page($goto);
		}
		return $index_list;
	}

	if (isset($_SESSION['fw_links_list']) && isset($_GET['next'])) {

		$links_list=unserialize($_SESSION['fw_links_list']);
		$index_list=unserialize($_SESSION['fw_index_list']);
		$root_url=$links_list[0];
		unset($_SESSION['fw_links_list']);
		unset($_SESSION['fw_index_list']);
	}
	else {
		$links_list=array();
		$index_list=array();
	}
	if (isset($_SESSION['fw_search_time'])) $start_time=time();
	else $start_time=time();

	get_page($root_url);

	$il='';

	foreach ($index_list as $k=>$v) {
		$il.="'".$v."',";
	}
	$il=substr($il,0,-1);
	$db->query("DELETE FROM fw_search WHERE url NOT IN($il)");

	if (isset($_SESSION['fw_search_time'])) {

		$end_time=time();
		$result_time=$end_time-$start_time;

		$result_time=$_SESSION['fw_search_time']+$result_time;
	}
	else {
		$end_time=time();
		$result_time=$end_time-$start_time;
	}

	$smarty->assign("time",$result_time);

}






if (isset($_POST['submit_noindex_list'])) {
	$noindex=$_POST['noindex_list'];

	$file=fopen(BASE_PATH.'/modules/search/noindex.txt','w');
	if ($file) {
		fwrite($file,$noindex);
		fclose($file);
		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
	}
	else {
		$smarty->assign("error_message","Невозможно записать в файл noindex.txt");
	}
}

if ($action=='delete_statistics') {

	$db->query("TRUNCATE TABLE fw_search_statistics");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

if ($action=='delete_only') {

	$max=$_GET['max'];

	$db->query("DELETE FROM fw_search_statistics WHERE number<='$max'");

	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
}

SWITCH (TRUE) {

	CASE ($action=='index'):

		$smarty->assign("noindex_list",file_get_contents(BASE_PATH.'/modules/search/noindex.txt'));

		$navigation[]=array("url" => BASE_URL."/admin/?mod=edit_conf&action=search","title" => 'Поисковый индекс');

		$template='search.a_index.html';

	BREAK;

	CASE ($action=='full_statistics'):

		$navigation[]=array("url" => BASE_URL."/admin/?mod=search","title" => 'Статистика запросов');
		$navigation[]=array("url" => BASE_URL."/admin/?mod=search&action=full_statistics","title" => 'Полная статистика');

		if (isset($_GET['page'])) {
			$page=$_GET['page'];
		}
		else $page=1;

		$result=$db->query("SELECT COUNT(*) FROM fw_search_statistics");
		$pager=Common::pager($result,50,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);

		$statistics=$db->get_all("SELECT * FROM fw_search_statistics ORDER BY number DESC LIMIT ".$pager['limit']);

		$smarty->assign("statistics",$statistics);

		$template='search.a_statistics_full.html';

	BREAK;

	DEFAULT:

		$navigation[]=array("url" => BASE_URL."/admin/?mod=search","title" => 'Статистика запросов');

		$statistics=$db->get_all("SELECT * FROM fw_search_statistics ORDER BY number DESC LIMIT 10");

		$smarty->assign("statistics",$statistics);

		$template='search.a_statistics.html';

}

?>