<?php

require_once(BASE_PATH.'/modules/search/lib/class.stemmer.php');

$navigation[]=array("url" => $module_url,"title" => $node_content['name']);

SWITCH (TRUE) {



	CASE ((preg_match("/^\?query=.*$/",$url[$n]) && count($url)==2) || (preg_match("/^\?query=.*&page=[0-9]+$/",$url[$n]) && count($url)==2) || (count($url)==1)):

		$page_found=true;

		if (count($url)==2) {

			if (isset($_GET['page'])) {
				$page=$_GET['page'];
				unset($current_url_pages[count($current_url_pages)-1]);
			}
			else $page=1;

			$query=urldecode($_GET['query']);

			$smarty->assign("query",urldecode($_GET['query']));

			$smarty->assign("query",stripslashes($query));

			//--------------------------Составляем массив слов для запроса---------------------------
			/*$stemmer = new Lingua_Stem_Ru();

			$words_list=explode(" ",$query);

			foreach ($words_list as $k=>$v) {
				$word=$stemmer->stem_word($v);
				$words[]=$word;
				$tmp_cond[]="REGEXP '$word'";
			}

			$cond='(';

			for ($i=0;$i<sizeof($tmp_cond);$i++) {
				if ($i+1!=count($tmp_cond)) $cond.='content '.$tmp_cond[$i]." AND ";
				else $cond.='content '.$tmp_cond[$i];
			}
			$cond.=') OR (';
			for ($i=0;$i<sizeof($tmp_cond);$i++) {
				if ($i+1!=count($tmp_cond)) $cond.='title '.$tmp_cond[$i]." AND ";
				else $cond.='title '.$tmp_cond[$i];
			}

			$cond.=')';*/



			$words[] = $query;
			$cond = " (content REGEXP '".$query."') OR (title REGEXP '".$query."') ";

			//--------------------------Составляем массив слов для запроса---------------------------

			$stat_query=strtolower($query);

			$stat=$db->get_single("SELECT query FROM fw_search_statistics WHERE query='$stat_query'");

			if ($stat['query']!='') {
				$db->query("UPDATE fw_search_statistics SET number=number+1 WHERE query='$stat_query'");
			}
			else {
				$db->query("INSERT INTO fw_search_statistics(query,number) VALUES('$stat_query','1')");
			}

			$page_title=$node_content['name'].': '.stripslashes($query);

			$query=mysql_real_escape_string($query);

			$result=$db->get_single("SELECT COUNT(*) AS count FROM fw_search WHERE $cond");
			$pager=Common::pager($result['count'],RESULTS_PER_PAGE,$page);

			$smarty->assign("total_results",$result['count']);

			$smarty->assign("total_pages",$pager['total_pages']);
			$smarty->assign("current_page",$pager['current_page']);
			$smarty->assign("pages",$pager['pages']);
			$smarty->assign("per_page",RESULTS_PER_PAGE);

			$results_list=$db->get_all("SELECT * FROM fw_search WHERE $cond LIMIT ".$pager['limit']);


			for ($i=0;$i<sizeof($results_list);$i++) {
				//echo $words[0]."<br>";
				preg_match_all("/.{0,50}(".$words[0].").{0,50}/i",$results_list[$i]['content'],$matches);
				preg_match_all("/".$words[0]."/i",$results_list[$i]['content'],$matches_all);

				//preg_match_all("/.{0,50}(".$query.").{0,50}/i",$results_list[$i]['content'],$matches);
				//preg_match_all("/".$query."/i",$results_list[$i]['content'],$matches_all);


				$count=count($matches[0]);
				$count_all=count($matches_all[0]);

				if ($count>1) $content=$matches[0][1];
				else $content=$matches[0][0];

				$new_content=$content;

				foreach ($words as $k=>$v) {
					$new_content=preg_replace("/([\w]*?".$v."[^\s]*)/i","<b>\\1</b>",$new_content);
				}

				$new_content=explode(" ",$new_content);
				unset($new_content[0]);
				unset($new_content[count($new_content)-1]);
				$results_list[$i]['content']=implode(" ",$new_content);
				foreach ($words as $k=>$v) {
					$results_list[$i]['title']=preg_replace("/([^\s]*?".$v."[^\s]*)/i","<b>\\1</b>",$results_list[$i]['title']);
				}
				$results_list[$i]['count']=$count_all;
			}

			$smarty->assign("results_list",$results_list);
		}

		$smarty->assign("search_url",$node_content['url']);
		$template='search_results.html';
	BREAK;

}
?>