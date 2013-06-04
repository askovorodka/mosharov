<?php

if ($switch_default=='on' or $switch_support=='on') {
	
	$smarty->assign("news_list_support",$db->get_all("SELECT * FROM fw_news ORDER BY publish_date DESC LIMIT ".NEWS_PER_PAGE_FRONT));
	$smarty->assign("news_url",$support_url);
}
if  ($main_module=='on') {

$navigation[]=array("url" => $module_url,"title" => $node_content['name']);

SWITCH (TRUE) {
	
	CASE (count($url)==1):
	
		$page_found=true;
		
		$news_list=$db->get_all("SELECT * FROM fw_news ORDER BY publish_date DESC LIMIT ".NEWS_PER_PAGE_FRONT);
		
		$smarty->assign("news_list",$news_list);
		$template='news_list.html';
	BREAK;
	
	CASE (($url[$n]=='archive' && count($url)==2) || ($url[$n-1]=='archive' && preg_match("/^page_([0-9]+)$/",$url[$n]) && count($url)==3)):
		$page_found=true;
		$navigation[]=array("url" => "archive","title" => "Архив");
		
		if (preg_match("/^page_([0-9]+)$/",$url[$n])) {
			list(,$page)=explode("_",$url[$n]);
			$url=array_values($url);
		}
		else $page=1;
		
		$result=$db->query("SELECT COUNT(*) FROM fw_news");
		$pager=Common::pager($result,NEWS_PER_PAGE_FRONT_ARCHIVE,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		$smarty->assign("mode","archive");
		
		$news_list=$db->get_all("SELECT * FROM fw_news ORDER BY publish_date DESC LIMIT ".$pager['limit']);
		
		$page_title=$node_content['name'].' - '.'Архив';
		
		$smarty->assign("news_list",$news_list);
		$template='news_list.html';
	BREAK;
	
	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='archive' && count($url)==3):
		
		$navigation[]=array("url" => "archive","title" => "Архив");
		
		$id=$url[$n];
		$result=$db->get_single("SELECT * FROM fw_news WHERE id='$id'");
		
		if ($result['id']>0) {
			$page_found=true;
			
			$navigation[]=array("url" => $result['title'],"title" => $result['title']);

			$page_title=$node_content['name'].' - '.$result['title'];
			
			$smarty->assign("single_news",$result);
			$template='show_single_news.html';
		}
		
	BREAK;
}

}
?>