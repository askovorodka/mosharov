<?php

if ($switch_support=='on' or $switch_default=='on') {
	
	$poll=$db->get_single("SELECT * FROM fw_polls WHERE status>'0' ORDER BY publish_date DESC LIMIT 1");
		
	if ($poll['name']!='') {
			
		$check_poll=explode(",",@$_COOKIE['fw_polls']);
			
		if (in_array($poll['id'],$check_poll)) $smarty->assign("poll_done","true");
			
		$answers_list=$db->get_all("SELECT *,(SELECT SUM(answers) FROM fw_polls_answers WHERE parent='".$poll['id']."') AS total_answers FROM fw_polls_answers WHERE parent='".$poll['id']."' ORDER BY sort_order");
			$total_answers=$answers_list[0]['total_answers'];
			for ($a=0;$a<count($answers_list);$a++) {
				if ($answers_list[$a]['answers']>0) $answers_list[$a]['percent']=round($answers_list[$a]['answers']/$total_answers*100,1);
				else $answers_list[$a]['percent']='0';
			}
		$poll['answers']=$answers_list;
		$smarty->assign("poll",$poll);
		$smarty->assign("polls_url",$support_url);
			
	}
}
if  ($main_module=='on') {

$navigation[]=array("url" => $module_url,"title" => $node_content['name']);

SWITCH (TRUE) {
	
	CASE (count($url)==1):
	
		$page_found=true;
		$current_poll_found=false;
		$active_polls=array();
		$finished_polls=array();
		
		$polls_list=$db->get_all("SELECT * FROM fw_polls WHERE status>'0' ORDER BY publish_date DESC");
		
		for ($i=0;$i<count($polls_list);$i++) {
			if ($polls_list[$i]['status']=='1') {
				$current_poll=$polls_list[$i];
				$answers_list=$db->get_all("SELECT *,(SELECT SUM(answers) FROM fw_polls_answers WHERE parent='".$current_poll['id']."') AS total_answers FROM fw_polls_answers WHERE parent='".$current_poll['id']."' ORDER BY sort_order");
				$total_answers=$answers_list[0]['total_answers'];
				for ($a=0;$a<count($answers_list);$a++) {
					if ($answers_list[$a]['answers']>0) $answers_list[$a]['percent']=round($answers_list[$a]['answers']/$total_answers*100,1);
				}
				$current_poll['answers']=$answers_list;
				$polls_list=MyArray::unset_element($polls_list,$i);
				$current_poll_found=true;
				
				$check_poll=explode(",",@$_COOKIE['fw_polls']);
				if (in_array($current_poll['id'],$check_poll)) $smarty->assign("poll_done","true");
				break;
			}
		}
		for ($i=0;$i<count($polls_list);$i++) {
			if ($polls_list[$i]['status']=='1') $active_polls[]=$polls_list[$i];
			else $finished_polls[]=$polls_list[$i];
		}
		
		if (count($active_polls)>0) $smarty->assign("active_polls",$active_polls);
		if (count($finished_polls)>0) $smarty->assign("finished_polls",$finished_polls);
		if ($current_poll_found) $smarty->assign("current_poll",$current_poll);
		$template='polls_list.html';
		
	BREAK;
	
	
	CASE (count($url)==2 && preg_match("/^([0-9]+)/",$url[$n])):

	
		if (isset($_POST['submit_poll'])) {
			
			$poll_id=$_POST['poll_id'];
			$answer_id=$_POST['poll_answer'];
			
			$check_poll=explode(",",$_COOKIE['fw_polls']);
			if (!in_array($poll_id,$check_poll)) {
			
				$db->query("UPDATE fw_polls_answers SET answers=answers+1 WHERE id='$answer_id'");
				
				if (!@isset($_COOKIE['fw_polls']) or $_COOKIE['fw_polls']=='') $cookie_content=$poll_id;
				else $cookie_content=$_COOKIE['fw_polls'].','.$poll_id;
				
				setcookie('fw_polls',$cookie_content,time()+315360000,'/','');
			}
			
			$location=$_SERVER['HTTP_REFERER'];
			header("Location: $location");
			die();
		}
	
		$id=$url[$n];
		
		$poll=$db->get_single("SELECT * FROM fw_polls WHERE status>0 AND id='$id'");
		
		if ($poll['name']!='') {
			
			$check_poll=explode(",",@$_COOKIE['fw_polls']);
			
			if (in_array($poll['id'],$check_poll)) $smarty->assign("poll_done","true");
			
			$navigation[]=array("url" => $module_url.'/'.$poll['id'],"title" => $poll['name']);
			
			$page_found=true;
			
			$answers_list=$db->get_all("SELECT *,(SELECT SUM(answers) FROM fw_polls_answers WHERE parent='".$poll['id']."') AS total_answers FROM fw_polls_answers WHERE parent='".$poll['id']."' ORDER BY sort_order");
				$total_answers=$answers_list[0]['total_answers'];
				for ($a=0;$a<count($answers_list);$a++) {
					if ($answers_list[$a]['answers']>0) $answers_list[$a]['percent']=round($answers_list[$a]['answers']/$total_answers*100,1);
					else $answers_list[$a]['percent']='0';
				}
			$poll['answers']=$answers_list;
			
			$page_title=$node_content['name'].' - '.$poll['name'];
			
			$template='single_poll.html';
			$smarty->assign("poll",$poll);
			
		}
	
	BREAK;
}

}
?>