<?php

$navigation[]=array("url" => BASE_URL."/admin/?mod=polls","title" => 'Îïðîñû');

if (isset($_GET['action']) && $_GET['action']!='') $action=$_GET['action'];
else $action='';

/*------------------------- ÂÛÏÎËÍßÅÌ ÐÀÇËÈ×ÍÛÅ ÄÅÉÑÒÂÈß ---------------------*/

if (isset($_POST['submit_add_poll'])) {
	
	Common::check_priv("$priv");
	
	$name=String::secure_format($_POST['edit_poll_name']);
	
	$db->query("INSERT INTO fw_polls(name,publish_date) VALUES('$name','".time()."')");
	
	$location='index.php?mod=polls&action=edit&id='.mysql_insert_id();
	header("Location: $location");
}

if (isset($_POST['submit_edit_poll'])) {
	
	Common::check_priv("$priv");
	
	$id=$_POST['id'];
	$name=String::secure_format($_POST['edit_poll_name']);
	$status=$_POST['edit_poll_status'];
	$answers=$_POST['edit_poll_answers'];
	
	$db->query("UPDATE fw_polls SET name='$name',status='$status' WHERE id='$id'");
	
	if (isset($_POST['edit_answer_title'])) {
		$titles=$_POST['edit_answer_title'];
		$orders=$_POST['edit_answer_order'];
		
		for ($i=0;$i<count($titles);$i++) {
			$answer_id=key($titles);
			$answer_name=String::secure_format($titles[key($titles)]);
			$answer_order=$orders[key($titles)];
			$db->query("UPDATE fw_polls_answers SET name='$answer_name',sort_order='$answer_order' WHERE id='$answer_id'");
			next($titles);
		}
	}
	
	if (isset($_POST['delete_answers'])) {
		
		$ids='';
		$delete_answers=$_POST['delete_answers'];
		foreach ($delete_answers as $k=>$v) {
			$ids.=$k.',';
		}
		$ids=substr($ids,0,-1);
		
		$db->query("DELETE FROM fw_polls_answers WHERE id IN ($ids)");
		
	}
	
	if ($answers!=='') {
		$answers=explode("\n",$answers);

		$result=$db->get_single("SELECT MAX(sort_order) AS max FROM fw_polls_answers WHERE parent='$id'");
		$max=$result['max'];

		$values='';
		foreach ($answers as $k=>$v) {
			$max++;
			if ($v!='') $values.="('".$id."','".String::secure_format($v)."','".$max."'),";
		}
		$values=substr($values,0,-1);
		
		$db->query("INSERT INTO fw_polls_answers(parent,name,sort_order) VALUES $values");
	}
	
	$location=$_SERVER['HTTP_REFERER'];
	header("Location: $location");
	
}

if ($action=='delete_poll') {
	
	Common::check_priv("$priv");
	
	$id=$_GET['id'];
	
	$db->query("DELETE FROM fw_polls WHERE id='$id'");
	$db->query("DELETE FROM fw_polls_answers WHERE parent='$id'");
	
	header("Location: ?mod=polls");
}


/*--------------------------------- ÎÒÎÁÐÀÆÅÍÈÅ ------------------------------*/

SWITCH (TRUE) {

	CASE ($action=='add'):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=polls&action=add","title" => 'Äîáàâèòü îïðîñ');

		$smarty->assign("mode","add");
		$template='polls.a_edit_poll.html';

	BREAK;

	CASE ($action=='edit' && isset($_GET['id'])):
	
		$navigation[]=array("url" => BASE_URL."/admin/?mod=polls&action=edit","title" => 'Ðåäàêòèðîâàòü îïðîñ');

		$id=$_GET['id'];

		$poll=$db->get_single("SELECT * FROM fw_polls WHERE id='$id'");
		$answers=$db->get_all("SELECT * FROM fw_polls_answers WHERE parent='$id' ORDER BY sort_order");

		$poll['answers']=$answers;
		$poll=String::unformat_array($poll);

		$smarty->assign("poll",$poll);
		$smarty->assign("mode","edit");
		$template='polls.a_edit_poll.html';

	BREAK;


	DEFAULT:

		if (isset($_GET['page'])) $page=$_GET['page'];
		else $page=1;

		$result=$db->query("SELECT COUNT(*) FROM fw_polls");
		$pager=Common::pager($result,POLLS_PER_PAGE,$page);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);

		$polls_list=$db->get_all("SELECT * FROM fw_polls ORDER BY publish_date DESC LIMIT ".$pager['limit']);
		$polls_list=String::unformat_array($polls_list);
		$smarty->assign("polls_list",$polls_list);

}

?>