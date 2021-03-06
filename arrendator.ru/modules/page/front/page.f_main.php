<?php
require_once 'lib/class.photoalbum.php';
require_once 'lib/class.table.php';
require_once 'lib/class.form.php';

$all_pages=$db->get_all("
	SELECT
		tree.*,
		dob.name as orderby_name,
		dob.orderby,
		dob.orderbysc,
		(SELECT param_left FROM fw_tree WHERE param_right>tree.param_left AND tree.param_level-param_level=1 ORDER BY param_left LIMIT 1) AS p_left,
		(SELECT param_right FROM fw_tree WHERE param_right>tree.param_left AND tree.param_level-param_level=1 ORDER BY param_left LIMIT 1) AS p_right,
		(SELECT GROUP_CONCAT(id SEPARATOR ',') FROM fw_users WHERE FIND_IN_SET(group_id, tree.access_groups)>0) as access_users_groups,
		(SELECT IF(ISNULL(access_users_groups), access_users, CONCAT(access_users,',',access_users_groups))) as access_users_list
	FROM
		fw_tree AS tree
		LEFT JOIN fw_documents_orderby dob
			ON
				dob.id=tree.show_documents_orderby
	WHERE
		tree.module='page'
		AND
		tree.status='1'
	ORDER BY tree.param_left
");

$all_pages=Common::get_nodes_list($all_pages);


if (preg_match("/^page_[0-9]+$/",$url[$n])) {
	list(,$page)=explode("_",$url[$n]);
	$url=array_values($url);
	unset($url[$n]);
	unset($current_url_pages[count($current_url_pages)-1]);
	$n=count($url)-1;
}
else $page=1;

if (preg_match("/^item_([0-9]+)$/",$url[$n],$a)) {
	$select_item=intval($a[1]);
	unset($url[$n]);
	$n--;
}

for ($f=0;$f<count($all_pages);$f++) {
	$url_to_check=implode("/",$url).'/';
	if ($all_pages[$f]['full_url']==$url_to_check) {
		$main_page_content=$all_pages[$f];

		if (Common::check_node_auth($main_page_content['access_users_list'])) {

			$nav_titles=explode("/",$all_pages[$f]['full_title']);
			$nav_urls=explode("/",$all_pages[$f]['full_url']);
			unset($nav_titles[count($nav_titles)-1]);
			unset($nav_urls[count($nav_urls)-1]);
			for ($l=0;$l<count($nav_titles);$l++) {
				$navigation[]=array("url" => $nav_urls[$l],"title" => trim($nav_titles[$l]));
			}

			$page_content=$main_page_content;

			$main_template=$page_content['template'];

			$smarty->assign("page_content",$page_content);
			$navigation[count($navigation)-1]=array("url" => $main_page_content['url'],"title" => $page_content['name']);

			if ($page_content['show_documents']=="1") {

				$limit="";
				if ($page_content['show_documents_number']>0) {

					$result=$db->query("SELECT COUNT(*) FROM fw_documents d WHERE d.parent='".$main_page_content['id']."' AND d.status='1'");
					$pager=Common::pager($result,$page_content['show_documents_number'],$page);
					$limit="LIMIT ".$pager['limit'];

					$smarty->assign("total_pages",$pager['total_pages']);
					$smarty->assign("current_page",$pager['current_page']);
					$smarty->assign("pages",$pager['pages']);
				}

				if ($main_page_content['orderby']!='') $orderby=$main_page_content['orderby']." ".$main_page_content['orderbysc'];
				else $orderby="d.sort_order";

				$documents_list=$db->get_all("
					SELECT
						d.*,
						(SELECT url FROM fw_tree WHERE id=d.parent) as url
					FROM fw_documents d
					WHERE
						d.parent='".$main_page_content['id']."'
						AND
						d.status='1'
					ORDER BY $orderby
					$limit
				");

				if (count($documents_list)) {
					$smarty->assign("documents_list",$documents_list);

					if (is_file($templates_path."/".$main_page_content['documents_template']))
						$documents_template=$main_page_content['documents_template'];
					else
						$documents_template="documents_list.html";

					$sl=$smarty->fetch($templates_path."/".$documents_template);
					$smarty->assign("documents",$sl);
				}
			}

			if ($page_content['show_nodes']=="1") {
				for ($c=0;$c<count($all_pages);$c++) if ($all_pages[$c]['param_left']>$main_page_content['param_left'] && $all_pages[$c]['param_right']<$main_page_content['param_right'] && $all_pages[$c]['param_level']==($main_page_content['param_level']+1) && $all_pages[$c]['in_menu']=='1') $subpages_list[]=$all_pages[$c];
				if (isset($subpages_list) && count($subpages_list)>0) {
					
					$smarty->assign("subpages_list",$subpages_list);
					$sl=$smarty->fetch($templates_path.'/subpages_list.html');
					$smarty->assign("subpages",$sl);

				}
			}

			if (!isset($select_item)) {

				$page_found=true;
				
				if ($page_content['param_level'] > 1)
				{
					$parent_page = $db->get_single("
						SELECT * FROM fw_tree 
						WHERE param_left < '{$page_content['param_left']}' and param_right > '{$page_content['param_right']}' 
						and param_level = '" . ($page_content['param_level']-1) . "'");
					if ($parent_page)
					{
						
						$other_page = $db->get_all("SELECT * FROM fw_tree WHERE param_left BETWEEN '{$parent_page['param_left']}' 
						and '{$parent_page['param_right']}' and status = '1' and in_left_menu = '1' and param_level = '" . $page_content['param_level'] . "' 
						order by param_left");

						$smarty->assign('other_page', $other_page);
						$smarty->assign('parent_page', $parent_page);
					}
				}
				
				if ($page_content['title']!='') $page_title=$page_content['title'];
				else $page_title=$page_content['name'];
				if ($page_content['meta_keywords']!='') $meta_keywords=$page_content['meta_keywords'];
				if ($page_content['meta_description']!='') $meta_description=$page_content['meta_description'];

                $smarty->assign("content",$main_page_content['elements']);
			}
			else {
				$document=$db->get_single("SELECT * FROM fw_documents WHERE id='".$select_item."' AND status='1'");
				if ($document['parent']==$page_content['id']) {

					$page_found=true;

					if ($document['title']!='') $page_title=$document['title'];
					else $page_title=$document['name'];
					if ($document['meta_keywords']!='') $meta_keywords=$document['meta_keywords'];
					if ($document['meta_description']!='') $meta_description=$document['meta_description'];

					$navigation[]=array("url" => "item_".$document['id'],"title" => trim($document['name']));

					$smarty->assign("document",$document);
					$smarty->assign("content",$smarty->fetch($templates_path."/document_elements.html"));
				}
			}

			break;
		}
		else {
			$page_found=true;
			$deny_access=true;
		}
	}
}

?>
