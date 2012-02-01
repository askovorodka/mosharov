<?php

require_once (BASE_PATH.'/lib/class.mail.php');

if ($switch_default=='on' && $main_module!='on') {
	
}
if  ($main_module=='on') {

$navigation[]=array("url" => $module_url,"title" => $node_content['name']);

SWITCH (TRUE) {
	
	CASE (count($url)==1):
		$page_found=true;
		
		if (isset($_POST['submit_new_subscribe'])) {
			
			$mail=String::secure_user_input($_POST['new_subscriber_mail']);
			$action=$_POST['new_subscriber_action'];
			
			$check=true;
			
			$time=time();
			
			if ($action=='subscribe') {
			
				if (CONFIRM_SUBSCRIPTION=='yes') $status='0';
				else $status='1';
				
				$check_subscriber=$db->get_single("SELECT mail FROM fw_subscribe_list WHERE mail='$mail'");
				
				if ($check_subscriber['mail']!='') {
					$check=false;
					$smarty->assign("error_message","��������, ���� ����� ��� ���� � ����� ����.");
				}
				
				if ($check) {
					$db->query("INSERT INTO fw_subscribe_list(mail,reg_date,status) VALUES('$mail','$time','$status')");
				}
				
				if (CONFIRM_SUBSCRIPTION=='yes') {
					
					$smarty->assign("site_url",BASE_URL);
					$smarty->assign("activation_link",BASE_URL.'/'.$node_content['url'].'/subscribe_confirm/'.$time);
					
					$body=$smarty->fetch(BASE_PATH.'/modules/subscribe/submit_subscribe.txt');
					
					@Mail::send_mail($mail,ADMIN_MAIL,'������������� �������� �� �������� ��������',$body,'','html','standard','Windows-1251');
					
					$smarty->assign("success_message","�� ��������� ���� ����� ��� ������ ������������� ��� � ����������� ������������.");
				}
				else {
					$smarty->assign("success_message","����� ������� �������� � ���� ��������!");
				}
			}
			
			if ($action=='unsubscribe') {
				
				$check_subscriber=$db->get_single("SELECT mail,reg_date FROM fw_subscribe_list WHERE mail='$mail'");
				
				if ($check_subscriber['mail']=='') {
					$check=false;
					$smarty->assign("error_message","��������, ����� ������ �� ����������.");
				}
				
				if ($check) {
						
					$smarty->assign("site_url",BASE_URL);
					$smarty->assign("activation_link",BASE_URL.'/'.$node_content['url'].'/unsubscribe_confirm/'.$check_subscriber['reg_date']);
						
					$body=$smarty->fetch(BASE_PATH.'/modules/subscribe/submit_unsubscribe.txt');
						
					@Mail::send_mail($check_subscriber['mail'],ADMIN_MAIL,'������������� ������� �� ��������',$body,'','html','standard','Windows-1251');

					$smarty->assign("success_message","�� ��������� ����� ��� ������ ��� ������������� ������� �� �������� � ����������� ������������");
				}
			}
		}
		
		$template='subscribe_main.html';
		
	BREAK;
	
	CASE ($url[$n-1]=='subscribe_confirm' && preg_match("/^[0-9]*$/",$url[$n]) && count($url)==3):
	
		$page_found=true;
		
		$navigation[]=array("url" => 'subscribe_confirm',"title" => '������������� ��������');
	
		$code=$url[$n];
		
		$check_code=$db->get_single("SELECT id FROM fw_subscribe_list WHERE status='0' && reg_date='$code'");
		
		if ($check_code['id']=='') {
			$smarty->assign("message","��������, �� ��� ������������� ��� ���������������");
		}
		else {
			
			$db->query("UPDATE fw_subscribe_list SET status='1' WHERE reg_date='$code'");
			$smarty->assign("message","��� ����� ������� �����������");
		}
		
		$template='confirm.html';
	
	BREAK;
	
	CASE ($url[$n-1]=='unsubscribe_confirm' && preg_match("/^[0-9]*$/",$url[$n]) && count($url)==3):
	
		$page_found=true;
		
		$navigation[]=array("url" => 'subscribe_confirm',"title" => '������������� �������');
	
		$code=$url[$n];
		
		$check_code=$db->get_single("SELECT id FROM fw_subscribe_list WHERE status='1' && reg_date='$code'");
		
		if ($check_code['id']=='') {
			$smarty->assign("message","��������, �� ��� ������������� ��� ���������������");
		}
		else {
			
			$db->query("DELETE FROM fw_subscribe_list WHERE reg_date='$code'");
			$smarty->assign("message","��� ����� ������� ����� �� ����");
		}
		
		$template='confirm.html';
	
	BREAK;
}

}
?>