<?php

/*$cur_site=$db->get_single("SELECT kurs,znak FROM fw_currency WHERE id=".CURRENCY_SITE);
$cur_site=String::unformat_array($cur_site);
$smarty->assign("currency_site",$cur_site);
$cur_admin=$db->get_single("SELECT kurs,znak FROM fw_currency WHERE id=".CURRENCY_ADMIN);
$cur_admin=String::unformat_array($cur_admin);
*/
/*
$count_cat=$db->get_single("SELECT COUNT(*) AS count FROM fw_tree");
$count_documents=$db->get_single("SELECT COUNT(*) AS count FROM fw_tree WHERE module='page'");*/
$count_users=$db->get_single("SELECT COUNT(*) AS count FROM fw_users");

$last_orders = $db->get_all("SELECT a.id,a.user,
							 a.insert_date as order_date,
							 (SELECT login FROM fw_users as b WHERE b.id=a.user) as user_name,
							 (SELECT SUM((SELECT price FROM fw_products WHERE id=c.product_id) * c.product_count) 
							 FROM fw_orders_products as c WHERE c.order_id=a.id) as total_summ 
							 FROM fw_orders as a ORDER BY a.insert_date DESC LIMIT 0,5");

$last_orders=String::unformat_array($last_orders);

if (count($last_orders)>0){
	for($i=0; $i<count($last_orders); $i++)
		$last_orders[$i]['total_summ'] = number_format((($last_orders[$i]['total_summ'] * $cur_admin['kurs'])/$cur_site['kurs']),2);
}

//$last_faq = $db->get_all("SELECT a.id,a.author, a.insert_date as insert_date,a.message FROM fw_guestbook as a ORDER BY insert_date LIMIT 0,5");
//$last_faq=String::unformat_array($last_faq);
/*
$forum_enabled = $db->get_single("SELECT id FROM fw_modules WHERE name='forum'");
if (strlen(trim($forum_enabled['id']))>0){
	$last_forum = $db->get_all("SELECT a.id, a.parent, a.author, a.publish_date, a.publish_date as date, a.text, b.id as thread_id, b.parent, b.title,
							c.url, c.name
							FROM fw_forum_posts as a INNER JOIN (fw_forum_threads as b INNER JOIN fw_forums as c ON b.parent=c.id) ON a.parent=b.id WHERE a.status='1' ORDER BY a.publish_date LIMIT 0,5");
	$last_forum=String::unformat_array($last_forum);
	$smarty->assign("last_forum",$last_forum);
}
*/
$smarty->assign("last_orders",$last_orders);
//$smarty->assign("last_faq",$last_faq);
//$smarty->assign("count_cat",$count_cat['count']);
//$smarty->assign("count_documents",$count_documents['count']);
$smarty->assign("count_users",$count_users['count']);

?>