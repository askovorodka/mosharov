<?php

/*$news_years_list=$db->get_all("SELECT YEAR(FROM_UNIXTIME(publish_date)) AS year FROM fw_news WHERE status='1' GROUP BY year ORDER BY publish_date DESC");
$smarty->assign("news_years_list", $news_years_list);*/

require_once 'lib/class.image.php';
require_once 'lib/class.photoalbum.php';
require_once 'lib/class.table.php';
require_once 'lib/class.form.php';

if (preg_match("/^\?year=([0-9]{0,4})$/",$url[$n])) {
	$year=intval($_GET['year']);
	unset($url[$n]);
	$n--;
}

if (!isset($year) || $_GET['year']=='') {
	$where=" and status='1'";
	$limit="LIMIT ".NEWS_PER_PAGE_FRONT_PAGE;
}
else {
	$where=" and YEAR(FROM_UNIXTIME(publish_date))='".$year."' AND status='1'";
	$limit="";
	$smarty->assign("year", $year);
}

$limit_all="LIMIT ".NEWS_PER_PAGE_FRONT_ARCHIVE;

if ($switch_default=='on' or $switch_support=='on' or $main_module=='on') {
	
	$news=$db->get_all("SELECT * FROM fw_news WHERE lang='RUS' ".$where." ORDER BY publish_date DESC " . $limit);
	$smarty->assign("news_list_rus",$news);
	
	$news_eng=$db->get_all("SELECT * FROM fw_news WHERE  lang='ENG' ".$where." ORDER BY publish_date DESC " . $limit);
	$smarty->assign("news_list_eng",$news_eng);
	
	/*$ne2=$db->get_all("SELECT * FROM fw_news WHERE ".$where." ORDER BY publish_date DESC ".$limit);
	$smarty->assign("news_list",$ne);
	$smarty->assign("news_list_support",$ne2);
	$smarty->assign("news_url",$support_url);*/
}

if  ($main_module=='on') {

$navigation[]=array("url" => $module_url,"title" => $node_content['name']);

SWITCH (TRUE) {
	
	CASE (count($url)==1):
	
		$page_found=true;
		
		$news_list=$db->get_all("SELECT * FROM fw_news WHERE status='1' and lang='RUS' ORDER BY publish_date DESC LIMIT ".NEWS_PER_PAGE_FRONT);
		
		$smarty->assign("news_list",$news_list);
		$template='news_list.html';
	BREAK;
	
	CASE (($url[$n]=='archive' && count($url)==2) || ($url[$n-1]=='archive' && preg_match("/^page_([0-9]+)$/",$url[$n]) && count($url)==3)):
		$page_found=true;
		$navigation[]=array("url" => "archive","title" => "Архив новостей");
		
		if (preg_match("/^page_([0-9]+)$/",$url[$n])) {
			list(,$page)=explode("_",$url[$n]);
			$url=array_values($url);
		}
		else $page=1;
		
		$result=$db->query("SELECT COUNT(*) FROM fw_news WHERE status='1'");
		$pager=Common::pager($result,NEWS_PER_PAGE_FRONT_ARCHIVE,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		$smarty->assign("mode","archive");
		
		$news_list=$db->get_all("SELECT * FROM fw_news WHERE $where ORDER BY publish_date DESC ".$limit_all);
		
		$page_title=$node_content['name'].' - '.'Архив';
		
		$smarty->assign("news_list",$news_list);
		$template='news_list.html';
	BREAK;
	
	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='archive' && count($url)==3):
		
		$navigation[]=array("url" => "archive","title" => "Архив");
		
		$id=$url[$n];
		$result=$db->get_single("SELECT * FROM fw_news WHERE id='$id' AND status='1'");
		
		if ($result['id']>0) {
			
			$page_found=true;
			//смотрим версию языка
			if ($result['lang'] == 'ENG')
			{
				$main_template = "text_eng.html";
				$node_content['name'] = 'News and Special Offers';
			}
			
			$navigation[]=array("url" => $result['title'],"title" => $result['title']);
			$page_title=$node_content['name'].' - '.$result['title'];
			$smarty->assign("single_news",$result);
			$template='show_single_news.html';
			
		}
		
	BREAK;
}

}
?>