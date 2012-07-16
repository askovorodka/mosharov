<?php
ob_start("ob_gzhandler");
session_start();

error_reporting(E_ALL);

setlocale (LC_ALL, array ('ru_RU.CP1251', 'rus_RUS.1251'));


require_once '../../conf/globals.php';
require_once '../../lib/smarty/Smarty.class.php';
require_once '../../lib/class.db.php';
require_once '../../lib/class.common.php';
require_once '../../lib/class.string.php';
require_once '../../lib/class.array.php';

$_SESSION['db_connections'] = 0;

/* ------------ «¿√–”« ¿ ÿ¿¡ÀŒÕ»«¿“Œ–¿ --------------------*/
$smarty = new Smarty;

$smarty->template_dir = '/';
$smarty->compile_dir = '../../lib/smarty/admin_templates_c/';
$smarty->cache_dir = '../../lib/smarty/admin_cache/';

/* ------------ œŒƒ Àﬁ◊¿≈Ã—ﬂ   ¡¿«≈ ƒ¿ÕÕ€’ -------------- */
$db=new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

if (isset($_POST['calendar_go'])) {
	if ($_POST['calendar_go']=='prev') $calendar_time=$_POST['calendar_prev'];
	if ($_POST['calendar_go']=='next') $calendar_time=$_POST['calendar_next'];
}
else $calendar_time=time();

$time_month=date('m',$calendar_time);
$time_year=date('Y',$calendar_time);

$days_count=date('t',$calendar_time);

$month_events=array();
$day_found=false;


for ($i=0;$i<=6;$i++) {
	if ($i==date('w',mktime(0,0,0,$time_month,1,$time_year)-1)) break;
	else $current_month[]=array("day"=>'');
}

for ($i=1;$i<=$days_count;$i++) {
	$tmp_month=array("day"=>$i,"time"=>mktime(0,0,0,$time_month,$i,$time_year));
	$current_month[]=$tmp_month;
}

for ($i=0;$i<sizeof($month_events);$i++) {
	for ($c=0;$c<sizeof($current_month);$c++) {
		if ($current_month[$c]['day']==$month_events[$i]['day']) {
			$current_month[$c]['count']=$month_events[$i]['count'];
			break;
		}
	}
}

$check_month=date('m');
$check_year=date('Y');

$calendar_prev=mktime(0,0,0,$time_month-1,1,$time_year);

$calendar_next=mktime(0,0,0,$time_month+1,1,$time_year);

$smarty->assign("calendar_prev",$calendar_prev);
$smarty->assign("calendar_next",$calendar_next);
$smarty->assign("current_month",$current_month);

$dday=date('j');
$mmonth=date('m');
$yyear=date('Y');

$smarty->assign("calendar_day",mktime(0,0,0,$mmonth,$dday,$yyear));

$smarty->assign("calendar_time",$calendar_time);

$smarty->assign("id",$_GET['id']);

$smarty->display("calendar.html");

?>