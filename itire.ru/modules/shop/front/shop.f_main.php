<?php

//error_reporting(E_ALL);
//ini_set('display_errors','On');
//$_SESSION['fw_basket']=array();

if ($switch_default=='on' or $main_module=='on') {

	$basket_number=0;
	$basket_total=0;
	for ($i=0;$i<count(@$_SESSION['fw_basket']);$i++) {
		$basket_number+=@$_SESSION['fw_basket'][$i]['number'];
		$basket_total+=@$_SESSION['fw_basket'][$i]['price']*@$_SESSION['fw_basket'][$i]['number'];
	}
	$smarty->assign("basket_number",$basket_number);
	//$smarty->assign("basket_total",sprintf("%.2f",$basket_total));
	$smarty->assign("basket_total",$basket_total);
	$smarty->assign("currency",DEFAULT_CURRENCY);

}
if  ($main_module=='on')
{

require_once 'lib/class.mail.php';
require_once 'lib/class.image.php';
require_once 'lib/class.photoalbum.php';
require_once 'lib/class.table.php';
require_once 'lib/class.form.php';
//require_once 'modules/shop/front/class.shop.php';

$navigation[]=array("url" => $module_url,"title" => $node_content['name']);
$smarty->assign("module_url",BASE_URL.'/'.$module_url);

$cabinet_url=$db->get_single("SELECT url FROM fw_tree WHERE module='cabinet'");
$smarty->assign("cabinet_url",$cabinet_url['url']);

//$cl=$db->get_all("SELECT *,(SELECT COUNT(*) FROM fw_products WHERE parent=c.id AND status='1') AS products FROM fw_catalogue c WHERE c.status='1' ORDER BY param_left ");
$cl=$db->get_all("SELECT * FROM fw_catalogue c WHERE c.status='1' ORDER BY param_left ");


if (preg_match("/^page_[0-9]+$/",$url[$n])) {
	list(,$page)=explode("_",$url[$n]);
	$url=array_values($url);
	unset($url[$n]);
	unset($current_url_pages[count($current_url_pages)-1]);
	$n=count($url)-1;
}
else $page=1;


if (preg_match("/\?type=([0-9a-z]+)$/",$url[$n],$type)) {
  $type = $type[1];
  unset($url[$n]);
  unset($current_url_pages[count($current_url_pages)-1]);
  $n=count($url)-1;
  $smarty->assign("type", $type);
}
else {
    unset($type);

}

if (isset($type) && $type=='all')
	unset($type);

$cur_site=$db->get_single("SELECT kurs,znak FROM fw_currency WHERE id=".CURRENCY_SITE);
$cur_site=String::unformat_array($cur_site);
$cur_site2=$db->get_single("SELECT kurs,znak FROM fw_currency WHERE id=".CURRENCY_SITE2);
$cur_site2=String::unformat_array($cur_site2);

$cur_admin=$db->get_single("SELECT kurs,znak FROM fw_currency WHERE id=".CURRENCY_ADMIN);
$cur_admin=String::unformat_array($cur_admin);
$smarty->assign("currency_site",$cur_site);
$smarty->assign("currency_site2",$cur_site2);

$shop = new Shop($db);


if (isset($_POST['fast_order']) && $_POST['fast_order'] == 1)
{
	$product = $shop->getProductInfo(intval($_POST['product_id']));
	$product['full_url'] = $shop->getFullUrlProduct(intval($_POST['product_id']));
	$smarty->assign('username', $_POST['username']);
	$smarty->assign('phone', $_POST['phone']);
	$smarty->assign('product', $product);
	$body=$smarty->fetch($templates_path.'/fast_order.txt');
	//Mail::send_mail("ai@avtozeon.ru,avtozeon@gmail.com,rifshina@mail.ru,itire@ya.ru",$user['login'],"Новый заказ в интернет магазине #{$order_id}",$admin_body,'','html','standard','Windows-1251');
	Mail::send_mail("ai@avtozeon.ru,avtozeon@gmail.com,rifshina@mail.ru,itire@ya.ru","noreply@itire.ru","Быстрый заказ",$body,'','text','standard','Windows-1251');
	
	header("Location: " . $_SERVER['HTTP_REFERER']);
	die();
	
}


/*-----------------РАЗЛИЧНЫЕ ДЕЙСТВИЯ-----------------*/




if (isset($_POST['submit_comment'])) {

	$id=$_POST['brand_id'];

	$comment=String::secure_user_input($_POST['ntrcn']);
	$comment=Common::strip_forum_tags($comment);

	//$author=$_SESSION['fw_user']['id'];
	$username = strip_tags($_POST['bvz']);
	$email = strip_tags($_POST['tvfbk']);

	if (trim($_POST['username']) == '')
	{
		if (trim($_POST['email']) == '')
		{
			if (trim($_POST['text']) == '')
			{
				if ($comment!='')
				{
					$db->query("INSERT INTO fw_products_comments(product_id,username, email,text,insert_date) VALUES('$id','$username', '$email','$comment','".time()."')");
				}
			}
		}
	}

	$location=@$_SERVER['HTTP_REFERER'];
	header("Location: $location");
	die();
}


/*--------------------ОТОБРАЖЕНИЕ---------------------*/
//Common::dumper($_SESSION['fw_basket']);
if (!isset($_SESSION['fw_basket'])) $_SESSION['fw_basket']=array();

SWITCH (TRUE) {

	CASE ($url[$n-1] == 'checkemail' && preg_match("/\?useremail=(.+)$/",$url[$n])):
		switch($url[$n-1])
		{
			case 'checkemail':
				if (!empty($_GET['useremail']))
				{
					$email = urldecode($_GET['useremail']);
					$query = "SELECT id FROM fw_users WHERE mail = '{$email}' ";
					$result = $db->get_single($query);
					if (empty($result['id']))
					{
						$result = 'true';
					}
					else 
					{
						$result = 'false';
					}
					echo $result;
				}

				exit();
			break;
		}
	BREAK;


	CASE ($url[$n]=='compare'):

		if (isset($_POST['action']) && $_POST['action']=="compare") {
			$_SESSION['fw_compare'] = $_POST['compare'];

			header("Location: ".BASE_URL.'/'.$module_url."/compare");
			die();
		}

		if (count($_SESSION['fw_compare'])) {
				$products_list=$db->get_all("
				SELECT *,
						(SELECT c.name FROM fw_catalogue as c WHERE p.parent = c.id) as cat_name,
						(SELECT id FROM fw_products_images i WHERE i.parent=p.id ORDER BY sort_order ASC LIMIT 1) AS image,
						(SELECT ext FROM fw_products_images WHERE parent=p.id ORDER BY insert_date DESC LIMIT 1) AS ext,
						(SELECT
							GROUP_CONCAT(CONCAT_WS('||#||',
								cp.id,
								cp.name,
								cp.type,
								cp.elements,
								cp.status,
								(SELECT value FROM fw_products_properties AS pp WHERE pp.product_id = p.id AND pp.property_id = cr.property_id LIMIT 1)
							) SEPARATOR '##|##')
						FROM fw_catalogue_relations AS cr
						LEFT JOIN fw_catalogue_properties AS cp ON cp.id=cr.property_id
						WHERE cr.cat_id = p.parent) as properties
					FROM fw_products AS p
					WHERE
						p.id IN (".implode(',',$_SESSION['fw_compare']).")
						AND
						p.status='1'
						ORDER BY properties
						"
				);

				foreach ($products_list as $v => $key) {
//					if (substr_count($key['properties'],"##|##")>0) {
						$tmp=explode("##|##",$key['properties']);
						$products_list[$v]['properties']=array();
						foreach ($tmp as $val => $k) {
							if (substr_count($k,"||#||")>0) {
								$tmp2=explode("||#||",$k);
								$products_list[$v]['properties'][]=$tmp2;
								if (substr_count($products_list[$v]['properties'][$val][3],"\n")>0) $products_list[$v]['properties'][$val][3]=explode("\n",$products_list[$v]['properties'][$val][3]);
							}
						}
//					}
				}

				$smarty->assign("products_list",$products_list);
				$smarty->assign("cat_name",@$products_list[0]['cat_name']);
		}

		$page_found=true;
		$main_template = BASE_PATH."/modules/shop/front/templates/compare.html";

	BREAK;

	CASE (@$url[$n]=='step1' && $url[$n-1]=='basket'):

		$page_found=true;
		$navigation[]=array("url" => 'basket',"title" => 'Моя корзина');
		$navigation[]=array("url" => 'step1',"title" => 'Регистрация и авторизация');
		$template='basket_step1.html';

	BREAK;

	CASE (@$url[$n]=='step2' && $url[$n-1]=='basket'):
		$total_price=0;
		for ($i=0;$i<count($_SESSION['fw_basket']);$i++) {
			$total_price+=$_SESSION['fw_basket'][$i]['price']*$_SESSION['fw_basket'][$i]['number'];
		}
		$smarty->assign("basket",$_SESSION['fw_basket']);
		if (isset($_SESSION['fw_user'])) $smarty->assign("user",$_SESSION['fw_user']);
		$smarty->assign("total_price",sprintf("%.2f",$total_price));

		$page_found=true;
		$template='basket_step2.html';
	BREAK;


	//добавляем продукт в корзину
	CASE (@$url[$n-1] == 'basket' && @$url[$n] == 'add'):
		
		header("Content-type: text/html; charset=Windows-1251");
		if (!empty($_POST) && !empty($_POST['product_id']) && !empty($_POST['product_count']))
		{
			
		$number_found=false;

		$number = $_POST['product_count'];
		$product_id = $_POST['product_id'];
		$product=$db->get_single("SELECT id,parent,name,price,sale,article,disk_width,tire_width,disk_sklad,tire_sklad,
						(SELECT id FROM fw_products_images i WHERE i.parent=fw_products.id ORDER BY insert_date DESC LIMIT 1) AS image,
						(SELECT ext FROM fw_products_images WHERE parent=fw_products.id ORDER BY insert_date DESC LIMIT 1) AS ext
		 				FROM fw_products WHERE id='".$product_id."' AND status='1'");

		$error_count = false;
		
		for ($i=0;$i<count($_SESSION['fw_basket']);$i++) {
			if ($_SESSION['fw_basket'][$i]['id']==$product['id']) {
				$number += $_SESSION['fw_basket'][$i]['number'];
				$number_found=true;
			}
		}
		
		//если заказывают диск
		if (!empty($product['disk_width']))
		{
			//если кол-во заказа превышает на складе
			if ($number > $product['disk_sklad'])
			{
				$error_count = true;
				$count_true=$product['disk_sklad'];
			}
		}
		//если заказывают шину
		if (!empty($product['tire_width']))
		{
			//если кол-во заказа превышает на складе
			if ($number > $product['tire_sklad'])
			{
				$error_count = true;
				$count_true=$product['tire_sklad'];
			}
		}
		
		//если кол-во заказа превышает кол-во на складе
		if ($error_count)
		{
			echo "1001;$count_true";
			exit();
		}
		
        //$product['price']=($product['price'] * $cur_admin['kurs'])/$cur_site['kurs'];
        
		for ($i=0;$i<count($_SESSION['fw_basket']);$i++) {
			if ($_SESSION['fw_basket'][$i]['id']==$product['id']) {
				$_SESSION['fw_basket'][$i]['number']=$number;
			}
		}
		
		if (!$number_found) {
			$product['number']=$number;
			$_SESSION['fw_basket'][]=$product;
		}

		$basket_number=0;
		$basket_total=0;
		for ($i=0;$i<count(@$_SESSION['fw_basket']);$i++) {
			$basket_number+=@$_SESSION['fw_basket'][$i]['number'];
			$basket_total+=@$_SESSION['fw_basket'][$i]['price'] * @$_SESSION['fw_basket'][$i]['number'];
		}
			
			$switch_off_smarty=true;
			$basket_total = number_format($basket_total,2,",","");
			print "$basket_number;$basket_total";
			
		}
		exit();
		
	BREAK;


	CASE (@$url[$n-1]=='search_product' && preg_match("/\?keyword=(.+)$/",$url[$n]) && count($url)==3):

  		$patterns = array('/\s+/', '/"+/', '/%+/');
  		$replace = array('');
  		$keyword = $_REQUEST['keyword'];
  		$keyword = preg_replace($patterns,$replace,$keyword);

    	$query = $db->get_all("SELECT name FROM fw_products WHERE name LIKE '".$keyword."%'");
    	$output = '<?xml version="1.0" encoding="windows-1251" standalone="yes"?>';
    	$output .= "<response>";
    	for ($i=0; $i<count($query); $i++)
		
                $output .= '<name>' . $query[$i]['name'] . '</name>';
    	
    	$output .= "</response>";
		
  		if (ob_get_length()) ob_clean();
  		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  		header("Last-Modified: " . gmdate('D, d M Y H:i:s') . " GMT");
  		header("Cache-Control: no-cache, must-revalidate");
  		header("Pragma: no-cache");
  		header("Content-Type: text/xml");
  		echo $output;
		die();

	BREAK;




	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='delete' && $url[$n-2]=='basket' && count($url)==4):
		
		for ($i=0;$i<count($_SESSION['fw_basket']);$i++) {
			if ($_SESSION['fw_basket'][$i]['id']==$url[$n]) {
				unset($_SESSION['fw_basket'][$i]);
			}
		}
		$array=$_SESSION['fw_basket'];
		unset($_SESSION['fw_basket']);
		foreach ($array as $k=>$v) {
			$_SESSION['fw_basket'][]=$v;
		}
		$page_found=true;
		$location=$_SERVER['HTTP_REFERER'];
		header("Location: $location");
		die();

	BREAK;

	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='type'):
		$item=array();
		$item = $db->get_single("SELECT name,text FROM fw_products_types WHERE id=".(int)$url[$n]);
		if (strlen(trim($item['text']))>0){
			$smarty->assign("type_name",$item['name']);
			$smarty->assign("type_text",$item['text']);
		}
		else
			$smarty->assign("type_name","Описания нет");
		$page_found=true;
		//$switch_off_smarty=false;
        $main_template='_types.html';
		//$deny_access=true;

	BREAK;


	CASE (preg_match("/^([0-9]+)$/",$url[$n]) && $url[$n-1]=='photos'):
		$item=array();
		$item = $db->get_all("SELECT * FROM fw_products_images WHERE parent=".(int)$url[$n]);
		if (count($item)>0){
			for ($i=0; $i<count($item); $i++){
				if (trim($item[$i]['ext'])!=""){
					$size=getimagesize(BASE_PATH . "/uploaded_files/shop_images/".$item[$i]['id'].".".$item[$i]['ext']);
					if ($size[0]>$width)
						$width=$size[0];
					if ($size[1]>$height)
						$height=$size[1];
				}
			}
		}

		if (count($item)>0){
			$smarty->assign("photos",$item);
			$smarty->assign("max_w",$width);
			$smarty->assign("max_h",$height);
		}
		else
			$smarty->assign("msg","Изображений нет");
		$page_found=true;
		//$switch_off_smarty=false;
        $main_template='_photos.html';

	BREAK;


	CASE ($url[$n]=='basket' && count($url)==2):
		
		
		$page_found=true;
		$navigation[]=array("url" => 'basket',"title" => 'Моя корзина');
		
		if (isset($_POST['basket_remove']))
		{
			unset($_SESSION['fw_basket']);
			$location=$_SERVER['HTTP_REFERER'];
			header("Location: $location");
			die();
		}
		
		if (isset($_POST['basket_recount'])) {
			foreach ($_POST['edit_number'] as $k=>$v) {
				for ($i=0;$i<count($_SESSION['fw_basket']);$i++) {
					if ($_SESSION['fw_basket'][$i]['id']==$k && preg_match("/^([0-9]+)$/",$v))
					{
						$product = $shop->getProductInfo($_SESSION['fw_basket'][$i]['id']);
						if ($product)
						{
							$_SESSION['fw_basket'][$i]['number']=$v;
							if (!empty($product['tire_width']))
							{
								if ($product['tire_sklad'] < $_SESSION['fw_basket'][$i]['number'])
									$_SESSION['fw_basket'][$i]['number'] = $product['tire_sklad'];
							}
							elseif (!empty($product['disk_width']))
							{
								if ($product['disk_sklad'] < $_SESSION['fw_basket'][$i]['number'])
									$_SESSION['fw_basket'][$i]['number'] = $product['disk_sklad'];
							}
						} 
						//$_SESSION['fw_basket'][$i]['number']=$v;
					}
				}
			}
			
			$location=$_SERVER['HTTP_REFERER'];
			header("Location: $location");
			die();
		}
		
		if (count($_SESSION['fw_basket'])>0) {
			$total_price=0;
			for ($i=0;$i<count($_SESSION['fw_basket']);$i++) {
				$total_price+=$_SESSION['fw_basket'][$i]['price']*$_SESSION['fw_basket'][$i]['number'];
			}
		
        $sess = &$_SESSION;
        foreach($sess['fw_basket'] as $key=>$val){
        	foreach($sess['fw_basket'][$key] as $key2=>$val2)
        		$sess['fw_basket'][$key]['price_number'] = sprintf("%.2f",$sess['fw_basket'][$key]['price']*$sess['fw_basket'][$key]['number']);
        		$sess['fw_basket'][$key]['full_url'] = DOMAIN . 'shop' . $shop->getFullUrlProduct($sess['fw_basket'][$key]['id']);
        }
		
			$smarty->assign("basket",$_SESSION['fw_basket']);
			
			if ($total_price < SHOP_DOSTAVKA_LIMIT)
			{
				$total_price_dostavka = $total_price + SHOP_DOSTAVKA_PRICE;
			}
			else 
			{
				$total_price_dostavka = $total_price;
			}
			
			$smarty->assign("total_price",sprintf("%.2f",$total_price));
			$smarty->assign("total_price_dostavka",sprintf("%.2f",$total_price_dostavka));
			if (isset($_SESSION['fw_user'])) $smarty->assign("user",$_SESSION['fw_user']);
		}
		$template='basket.html';

	BREAK;

	CASE ($url[$n]=='confirm' && $url[$n-1]=='basket' && count($url)==3):
		
		if (!isset($_SESSION['fw_user'])) {
			$location=BASE_URL.'/'.$cabinet_url['url'].'/register';
			header("Location: $location");
			die();
		}
		
		$navigation[]=array("url" => 'basket',"title" => 'Моя корзина');
		$navigation[]=array("url" => 'confirm',"title" => 'Подтверждение заказа');
		
		$total_price=0;
		for ($i=0;$i<count($_SESSION['fw_basket']);$i++) {
			$total_price+=$_SESSION['fw_basket'][$i]['price']*$_SESSION['fw_basket'][$i]['number'];
		}
		$smarty->assign("basket",$_SESSION['fw_basket']);
		if (isset($_SESSION['fw_user'])) $smarty->assign("user",$_SESSION['fw_user']);
		$smarty->assign("total_price",sprintf("%.2f",$total_price));
		
		$page_found=true;
		$template='confirm_order.html';
		
	BREAK;
	
	
	CASE ($url[$n]=='final' && $url[$n-1]=='basket' && count($url)==3):
		$page_found=true;
		$template='basket_final.html';
	BREAK;
	
	
	CASE ($url[$n]=='submit' && $url[$n-1]=='basket' && count($url)==3):

		if (isset($_POST['submit_order'])) {

			if (count($_SESSION['fw_basket'])<1)
			{
				header("Location: ".BASE_URL);
			}
			else
			{
				
				$navigation[]=array("url" => 'basket',"title" => 'Моя корзина');
				$navigation[]=array("url" => 'confirm',"title" => 'Ваш заказ выполнен');
				
				$products_list='';
				$total_number=0;
				
				$user = $shop->getUser($_SESSION['fw_user']['id']);
				$name=$user['name'];
				$company=iconv('utf-8','windows-1251',$_POST['company']);
				$comments=iconv('utf-8','windows-1251',$_POST['comment']);
				$inn = $_POST['inn'];
				$kpp = $_POST['kpp'];
				$dostavka = $_POST['dostavka'];
				
				
				if (!empty($_POST['company_dost']))
					$company_dost = intval($_POST['company_dost']);
				else
					$company_dost = 0;
				
				if ($dostavka == 1 || $dostavka == 3)
				{
					$order_price = SHOP_DOSTAVKA_PRICE;
				}
				else 
				{
					$order_price = 0;
				}
				
				$payment = $_POST['payment'];
				
				$total_price=0;
				for ($i=0;$i<count($_SESSION['fw_basket']);$i++)
				{
					
					$p_info = $shop->getProductInfo($_SESSION['fw_basket'][$i]['id']);
					if (!empty($p_info['tire_width']))
						if ($_SESSION['fw_basket'][$i]['number'] > $p_info['tire_sklad'])
							$_SESSION['fw_basket'][$i]['number'] = $p_info['tire_sklad'];
					
					if (!empty($p_info['disk_width']))
						if ($_SESSION['fw_basket'][$i]['number'] > $p_info['disk_sklad'])
							$_SESSION['fw_basket'][$i]['number'] = $p_info['disk_sklad'];
					
					$total_price+=$_SESSION['fw_basket'][$i]['price']*$_SESSION['fw_basket'][$i]['number'];
					
				}
				
				$db->query("INSERT INTO fw_orders (
					user,
					comments,
					total_price,
					insert_date,
					inn,
					kpp,
					company,
					dostavka,
					payment,
					company_dost,
					order_price) 
					VALUES('".$user['id']."',
					'$comments',
					'$total_price',
					'".time()."',
					'{$inn}',
					'{$kpp}',
					'{$company}',
					'{$dostavka}',
					'{$payment}',
					'{$company_dost}',
					'{$order_price}')");
				
				$order_id = mysql_insert_id();
				$rel_prod = array();
				for ($i=0;$i<count($_SESSION['fw_basket']);$i++) {
					$products_list.=$_SESSION['fw_basket'][$i]['id'].'|'.$_SESSION['fw_basket'][$i]['number'].',';
					$total_number=$total_number+$_SESSION['fw_basket'][$i]['number'];
					$rel_prod[] = "('".$_SESSION['fw_basket'][$i]['id']."','".$order_id."','".$_SESSION['fw_basket'][$i]['number']."', '".$_SESSION['fw_basket'][$i]['price']."')";
				}
				
				$db->query("INSERT INTO fw_orders_products (product_id,order_id,product_count, product_price) VALUES ".implode(",",$rel_prod));
				
				$total_sum = $total_price;
				if ($dostavka != 2 && $total_price < SHOP_DOSTAVKA_LIMIT)
					$total_sum += $order_price;
				else
					$order_price = 0;
				
				
				//$shop = new Shop($db);
				//формируем список продуктов
				if ($_SESSION['fw_basket'])
				{
					$products = array();
					foreach ($_SESSION['fw_basket'] as $key=>$val)
					{
						$products[$key]['details'] = $shop->getProductInfo($_SESSION['fw_basket'][$key]['id']);
						$products[$key]['count'] = $_SESSION['fw_basket'][$key]['number'];
						$products[$key]['sum'] = $products[$key]['details']['price'] * $products[$key]['count']; 
					}
					$smarty->assign("products",$products);
				}

				$_SESSION['fw_basket']=array();

				$companies = unserialize(COMPANY_ORDERS);
				if ($company_dost > 0)
					$smarty->assign("company_dost",$companies[$company_dost]);

				$smarty->assign("name",$user['name']);
				$smarty->assign("site_url",BASE_URL);
				$smarty->assign("order_id",$order_id);
				$smarty->assign("date",time());
				$smarty->assign("order_total",$total_price);
				$smarty->assign("number",$total_number);
				$smarty->assign("currency",DEFAULT_CURRENCY);
				$smarty->assign("user",$user);
				$smarty->assign("dostavka",$dostavka);
				
				
				
				$smarty->assign("payment",$payment);
				$smarty->assign("company",$company);
				$smarty->assign("order_price",$order_price);
				$smarty->assign("total_sum",$total_sum);
				$smarty->assign("inn",$inn);
				$smarty->assign("kpp",$kpp);
				$smarty->assign("comment",$comments);

				$body=$smarty->fetch($templates_path.'/order_notice.txt');

				Mail::send_mail($user['login'],"ai@avtozeon.ru,avtozeon@gmail.com,rifshina@mail.ru,itire@ya.ru","Новый заказ в интернет магазине",$body,'','html','standard','Windows-1251');
				//Mail::send_mail("andrey.schmitz@gmail.com","ai@avtozeon.ru,avtozeon@gmail.com,rifshina@mail.ru","Новый заказ в интернет магазине",$body,'','html','standard','Windows-1251');

				$admin_body=$smarty->fetch($templates_path.'/admin_order_notice.txt');

				Mail::send_mail("ai@avtozeon.ru,avtozeon@gmail.com,rifshina@mail.ru,itire@ya.ru",$user['login'],"Новый заказ в интернет магазине #{$order_id}",$admin_body,'','html','standard','Windows-1251');
				//Mail::send_mail("aschmitz@ya.ru",$user['login'],"Новый заказ в интернет магазине #{$order_id}",$admin_body,'','html','standard','Windows-1251');
				

				echo 1;
				$page_found = true;
				$template = 'order_done.html';
			}

		}
		else
		{
			header("Location: ".BASE_URL);
		}

	BREAK;
	
	
	/**
	 * поиск в фильтрах
	 */
	CASE ($url[1] == 'search'):
		
		//$navigation[]=array("url" => 'search',"title" => 'Поиск');
		
		if (isset($_GET['page']) && $_GET['page']!='') $page=$_GET['page'];
		else $page=1;
		
		$where = array();
		if (!empty($_GET['disk_manufacturer']))
		{
			$category = $shop->getCategory($_GET['disk_manufacturer']);
			$where[] = " b.param_left BETWEEN {$category['param_left']} AND {$category['param_right']} AND b.param_level = 3 ";
		}
		if (!empty($_GET['disk_width']))
		{
			$where[] = " a.disk_width = '{$_GET['disk_width']}' ";
		}
		if (!empty($_GET['disk_diameter']))
		{
			$where[] = " a.disk_diameter = '{$_GET['disk_diameter']}' ";
		}
		if (!empty($_GET['disk_krep']))
		{
			$where[] = " a.disk_krep = '{$_GET['disk_krep']}' ";
		}
		if (!empty($_GET['disk_pcd']))
		{
			$where[] = " (a.disk_pcd = '{$_GET['disk_pcd']}' or a.disk_pcd2 = '{$_GET['disk_pcd']}') ";
		}
		if (!empty($_GET['disk_et']))
		{
			$where[] = " (a.disk_et >= '". ($_GET['disk_et']-10) . "' and a.disk_et <= '". ($_GET['disk_et']+5) . "') ";
		}
		if (!empty($_GET['disk_color']))
		{
			$where[] = " a.disk_color = '{$_GET['disk_color']}' ";
		}
		if (!empty($_GET['disk_sklad']))
		{
			$where[] = " a.disk_sklad > 0 ";
		}

		if (!empty($_GET['tire_manufacturer']))
		{
			$category = $shop->getCategory($_GET['tire_manufacturer']);
			$where[] = " b.param_left BETWEEN {$category['param_left']} AND {$category['param_right']} AND b.param_level = 3 ";
		}
		if (!empty($_GET['tire_width']))
		{
			$where[] = " a.tire_width = '{$_GET['tire_width']}' ";
		}
		if (!empty($_GET['tire_height']))
		{
			$where[] = " a.tire_height = '{$_GET['tire_height']}' ";
		}
		if (!empty($_GET['tire_diameter']))
		{
			$where[] = " a.tire_diameter = '{$_GET['tire_diameter']}' ";
		}
		if (!empty($_GET['tire_season']))
		{
			$where[] = " a.tire_season = '{$_GET['tire_season']}' ";
		}
		if (!empty($_GET['tire_spike']))
		{
			$where[] = " a.tire_spike = '{$_GET['tire_spike']}' ";
		}
		if (!empty($_GET['tire_sklad']))
		{
			$where[] = " a.tire_sklad > 0 ";
		}
		
		
		//$count = $shop->searchCount($where);
		//$pager=Common::pager($count,SEARCH_RESULTS_PER_PAGE,$page);
		$pager = "";
		
		if (isset($_GET['sort']))
		{
			$sort = $_GET['sort'];
		}
		else 
		{
			$sort = "date";
		}
		
		if (isset($_GET['order']))
		{
			$order = $_GET['order'];
		}
		else 
		{
			$order = "desc";
		}
		
		//echo $current_url;
		//$current_url = preg_replace("/&sort=([a-z]+)/i","",$current_url);
		//$current_url = preg_replace("/&order=([a-z]+)/i","",$current_url);
		
		$products = $shop->search($where, $pager, $sort, $order);
		
		if ($products)
		{
			foreach ($products as $key=>$val)
			{
				$products[$key]['full_url'] = $shop->getFullUrlProduct($val['id']);
			}
		}
		
		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);
		$smarty->assign("sort",$sort);
		$smarty->assign("order",$order);
		
		$smarty->assign("products",$products);
		$page_found=true;
		$template='search_products.html';
		
		
	BREAK;
	
	
	CASE ((count($url)==2 && preg_match("/\?search_product=(.+)$/",$url[$n])) or (count($url)==2 && preg_match("/\?search_product=(.+)&page=([1-9]+)$/",$url[$n]))):

		$navigation[]=array("url" => 'search',"title" => 'Поиск');

		$search=mysql_real_escape_string($_GET['search_product']);
		$search=urldecode($search);

		$current_url_pages[$n]=eregi_replace("&page=([1-9]+)","",$current_url_pages[$n]);

		if (isset($_GET['page']) && $_GET['page']!='') $page=$_GET['page'];
		else $page=1;
		
		//$result=$db->query("SELECT COUNT(*) FROM fw_products WHERE name LIKE '%$search%' AND status='1' and (tire_sklad = 1 or disk_sklad = 1)");
		//$pager=Common::pager($result,SEARCH_RESULTS_PER_PAGE,$page);

		$search_results=$db->get_all("SELECT fw_products.*, fw_catalogue.image FROM fw_products left join fw_catalogue on fw_products.parent = fw_catalogue.id WHERE fw_products.name LIKE '%$search%' AND fw_products.status='1' ");
		//echo "SELECT * FROM fw_products WHERE name LIKE '%$search%' AND status='1' and (tire_sklad > 0 or disk_sklad > 0) ";

		if ($search_results)
		{
			foreach ($search_results as $key=>$val)
			{
				$search_results[$key]['full_url'] = $shop->getFullUrlProduct($val['id']);
				$model = $shop->getCategory($val['parent']);
				if ($model)
				{
					$search_results[$key]['model'] = $model;
					$manufacturer = $shop->getParent($model, $model['param_level']-1);
					if ($manufacturer)
					{
						$search_results[$key]['manufacturer'] = $manufacturer;
					}
				}
			}
		}
		
		/*
		$cat_list=Common::get_nodes_list($cl);
		for ($a=0;$a<count($search_results);$a++) {
			for ($a1=0;$a1<count($cat_list);$a1++) {
				if ($search_results[$a]['parent']==$cat_list[$a1]['id']) {
					$search_results[$a]['full_url']=$cat_list[$a1]['full_url'];
					$search_results[$a]['price']=number_format(($search_results[$a]['price'] * $cur_admin['kurs'])/$cur_site['kurs'],2);
				}
			}
		}
		*/

		$smarty->assign("search_string",$search);

		$smarty->assign("search_results",$search_results);

		$smarty->assign("total_pages",$pager['total_pages']);
		$smarty->assign("current_page",$pager['current_page']);
		$smarty->assign("pages",$pager['pages']);

		$page_found=true;
		$template='search_products.html';

	BREAK;

	DEFAULT:

		$cat_list=Common::get_nodes_list($cl);
		unset($url[0]);

				if (isset($type) && $type!='all'){
					$where =  " AND product_type=".$type." ";
					$smarty->assign("prod_type",$type);
				}
				else{
					$where = "";
				}

		$order='ORDER BY sort_order ASC';
		if (!isset($page)) $page=1;
		$dirs=array("price"=>"desc","insert_date"=>"desc","name"=>"desc");

		if (isset($_GET['page']) or isset($_GET['order'])) {

			if (isset($_GET['page'])) $page=$_GET['page'];

			/*if (isset($_GET['order'])) {
				list($order,$dir)=explode("-",$_GET['order']);
				$dir=str_replace("/","",$dir);
				$smarty->assign("current_dir",$dir);
				foreach ($dirs as $k=>$v) {
					if ($k==$order && $dir=='asc') $dirs[$k]='desc';
					else if ($k==$order && $dir=='desc') $dirs[$k]='asc';
				}

				$order='ORDER BY '.$order.' '.$dir;
				$smarty->assign("order",$_GET['order']);
			}
			else $order='ORDER BY sort_order ASC';*/
			
			if (isset($_GET['sort']))
			{
				//$order='ORDER BY '.$_GET['sort'].' '.$_GET['order'];
				switch ($_GET['sort'])
				{
					case 'name':
						$order = "order by name ";
					break;
					case 'article':
						$order = "order by article ";
					break;
					case 'price':
						$order = "order by price ";
					break;
					case 'tire_is':
						$order = "order by tire_is ";
					break;
					case 'tire_width':
						$order = "order by tire_width ";
					break;
					case 'tire_in':
						$order = "order by tire_in ";
					break;
					case 'disk_width':
						$order = "order by disk_width ";
					break;
					case 'disk_diameter':
						$order = "order by disk_diameter ";
					break;
					case 'disk_krep':
						$order = "order by disk_krep ";
					break;
					case 'disk_pcd':
						$order = "order by disk_pcd ";
					break;
					
					default:
						$order = "order by id ";
					break;
				}
				
				$smarty->assign('sort', $_GET['sort']);
				$smarty->assign('order', $_GET['order']);
				if ($_GET['order'] == 'asc')
				{
					$order .= " asc";
				}
				if ($_GET['order'] == 'desc')
				{
					$order .= " desc";
				}
				
			}
			
			unset($url[$n]);
			unset($current_url_pages[count($current_url_pages)-1]);
		}
		$smarty->assign("dir",$dirs);

		for ($f=0;$f<count($cat_list);$f++) {
			$url_to_check=implode("/",$url).'/';
			
			if ($cat_list[$f]['full_url']==$url_to_check) {
				
				$cat_content=$cat_list[$f];
				$page_found=true;
				
				//находим родителя уровня 1
				if (!in_array($cat_content['id'], array(TIRES_ID, DISK_ID)))
				{

					//$parent = $db->get_single("SELECT id FROM fw_catalogue WHERE param_left < '{$cat_content['param_left']}' and param_right > '{$cat_content['param_right']}' and param_level = '1'");
					$parent = $shop->getParent($cat_content);
					
				}
				else 
				{
					$parent = $cat_content;
				}
				
				if ($cat_content['param_level'] > 2)
				{
					$parent2 = $db->get_single("SELECT id FROM fw_catalogue WHERE param_left < '{$cat_content['param_left']}' and param_right > '{$cat_content['param_right']}' and param_level = '2'");
				}
				elseif ($cat_content['param_level'] == 2)
				{
					$parent2 = $cat_content;
				}
				
				$smarty->assign('parent', $parent);
				if (isset($parent2))
				{
					$smarty->assign('parent2', $parent2);
				}
				
				
	            //мегу тайтлы
	            $parent_0 = $shop->getParent($cat_content);
	            if ($parent_0)
	            {
	            	if ($parent_0['id'] == DISK_ID)
	            	{
	            		// тайлты для дисков
	            		$title_template = DISK_TITLE_TEMPLATE;
	            	}
	            	elseif ($parent_0['id'] == TIRES_ID)
	            	{
	            		//тайтлы для шин
	            		$title_template = TIRES_TITLE_TEMPLATE;
	            	}
	            	
	            	$title_template = str_replace("{name}", $cat_content['title'], $title_template);
	            	
	            	//if ( preg_match_all( '/\[([^\]]*)\]/', $title_template, $matches ) )
	            	if ( preg_match_all( '/\[([^\]]*)\]/', $title_template, $matches ) )
	            	{
						if (is_array($matches))
						{
							foreach ($matches as $key=>$val)
							{
								foreach ($matches[$key] as $key2=>$val2)
								{
									//почему-то повторяется два раза данные паттерн поэтому делаю еще одно условия
									if (preg_match("/\[(.*)\]/", $matches[$key][$key2], $str) )
									{
										if (isset($str[1]))
										{
											$array = explode("|", $str[1]);
											$random = rand(0, count($array)-1);
											$word = $array[$random];
											$title_template = str_replace($matches[$key][$key2], $word, $title_template);
										}
									}
								}
							}
						}
	            	}

	            	//echo $title_template;

	            }
				
				
				if (isset($title_template)) $page_title=$title_template;
				else if ($cat_content['name']!='/') $page_title=$cat_content['name'];
				if ($cat_content['meta_keywords']!='') $meta_keywords=$cat_content['meta_keywords'];
				if ($cat_content['meta_description']!='') $meta_description=$cat_content['meta_description'];
				
				
				$text=$cat_content['text'];
				$smarty->assign("text",$text);
				$smarty->assign('cat_content', $cat_content);
		
		
		$cat_children_ids = array();
		for ($c=0;$c<count($cat_list);$c++) {
			//определяем дочернии категории каталога
			if ($cat_list[$c]['param_left']>$cat_content['param_left'] && $cat_list[$c]['param_right']<$cat_content['param_right'] && $cat_list[$c]['param_level']==($cat_content['param_level'])+1) {
				$cat_children_ids[] = $cat_list[$c]['id'];
				if (isset($type)){
    				$item=array();
    				$item=$db->get_single("SELECT count(id) as count FROM fw_cats_types_relations WHERE cat_id='".(int)$cat_list[$c]['id']."' AND type_id='".$type."'");
    				if (intval($item['count'])>0)
    				{
    					$cat_list[$c]['parent_id'] = $cat_content['id'];
    					$folders_list[]=$cat_list[$c];
    				}
				}
				else
				{
					$cat_list[$c]['parent_id'] = $cat_content['id'];
					$folders_list[]=$cat_list[$c];
				}
			}
			//определяем родительскую категорию каталога
			
			if ($cat_list[$c]['param_left'] < $cat_content['param_left'] && $cat_list[$c]['param_right'] > $cat_content['param_right'] && $cat_list[$c]['param_level'] == $cat_content['param_level']-1) {
				$cat_parent_info = $cat_list[$c];
				$smarty->assign('cat_parent_info', $cat_parent_info);
			}
		}

		if (isset($folders_list)) {
          $done=0;
          for ($c=0;$c<count($folders_list);$c++) {

          	//находим св-ва продукции категории
			if ($cat_parent_info['id'] == DISK_ID)
			{
				$folders_list[$c]['properties'] = $shop->getProductsPropertiesDisk($folders_list[$c]['id']);
			}
			elseif ($cat_parent_info['id'] == TIRES_ID)
			{
				$folders_list[$c]['properties'] = $shop->getProductsPropertiesTires($folders_list[$c]['id']);
			}

			if ($cat_parent_info['param_level'] == 0)
			{
				$children_folders = $shop->getChildrenCategor($folders_list[$c], 3);
				if ($children_folders)
				{
					$ids = array();
					foreach ($children_folders as $val)
					{
						$ids[] = $val['id'];
					}
					$folders_list[$c]['properties'] = $shop->getProductsProperties($ids);
				}
				
			}
          	

          }
          $smarty->assign("folders_list",$folders_list);
        }

        
				$products_list=$db->get_all("
				SELECT *,
						(SELECT id FROM fw_products_images i WHERE i.parent=p.id ORDER BY sort_order ASC LIMIT 1) AS image,
						(SELECT ext FROM fw_products_images WHERE parent=p.id ORDER BY insert_date DESC LIMIT 1) AS ext,
						(SELECT name FROM fw_products_types WHERE id=p.product_type LIMIT 0,1) AS type_name,
						(SELECT id FROM fw_products_types WHERE id=p.product_type LIMIT 0,1) AS type_id,
						(SELECT
							GROUP_CONCAT(CONCAT_WS('||#||',
								cp.id,
								cp.name,
								cp.type,
								cp.elements,
								cp.status,
								(SELECT value FROM fw_products_properties AS pp WHERE pp.product_id = p.id AND pp.property_id = cr.property_id LIMIT 1)
							) ORDER BY cr.sort_order SEPARATOR '##|##')
						FROM fw_catalogue_relations AS cr
						LEFT JOIN fw_catalogue_properties AS cp ON cp.id=cr.property_id
						WHERE cr.cat_id = p.parent) as properties
					FROM fw_products AS p
					WHERE
						p.parent='".$cat_content['id']."'
						AND
						p.status='1' $where
						$order "
				);
				

				foreach ($products_list as $v => $key) {
						$tmp=explode("##|##",$key['properties']);
						$products_list[$v]['properties']=array();
						foreach ($tmp as $val => $k) {
							if (substr_count($k,"||#||")>0) {
								$tmp2=explode("||#||",$k);
								$products_list[$v]['properties'][]=$tmp2;
								if (substr_count($products_list[$v]['properties'][$val][3],"\n")>0) $products_list[$v]['properties'][$val][3]=explode("\n",$products_list[$v]['properties'][$val][3]);
							}
						}
				}
        
				
				$smarty->assign("products_list",$products_list);

				if ($cat_list[$f]['full_title']!='/') {
					$nav_titles=explode("/",$cat_list[$f]['full_title']);

					$nav_urls=explode("/",$cat_list[$f]['full_url']);
					unset($nav_titles[count($nav_titles)-1]);
					unset($nav_urls[count($nav_urls)-1]);
					for ($l=0;$l<count($nav_titles);$l++) {
						$navigation[]=array("url" => $nav_urls[$l],"title" => trim($nav_titles[$l]));
					}
				}
				
				//комменты
				$comments = $db->get_all("select * from fw_products_comments where product_id = '{$cat_content['id']}' order by insert_date desc");
				$smarty->assign("comments",$comments);
				
				$smarty->assign("cat_list",$cat_list);
				
				$template='shop.f_main.html';
				break;
			}
		}

		if (!$page_found) {

			if (preg_match("/^([0-9]+)$/",$url[$n])) {

				$product_content = $shop->getProductInfo( intval($url[$n]) );
				
				//берем картинку из категории продукта
				$category = $shop->getCategory($product_content['parent']);
				if ($category)
				{
					if (@file_exists(SHOP_IMAGE_PATH . $category['image']))
					{	
						
						$product_content['image'] = SHOP_IMAGE . $category['image'];
					}
				}
				
				if ($product_content && !empty($product_content['tire_bodytype']))
				{
					$smarty->assign('product_body',$shop->getBodyById($product_content['tire_bodytype']));
				}

				if (!empty($product_content['disk_type']))
				{
					$smarty->assign('disk_type',$shop->getDiskType($product_content['disk_type']));
				}
				
				

				if ($product_content['id']!='') {
					for ($f=0;$f<count($cat_list);$f++) {
						
						$url_to_check=implode("/",$url).'/';
						if ($cat_list[$f]['full_url']=='/') $cat_list[$f]['full_url']='';
						if ($cat_list[$f]['full_url'].$product_content['id'].'/'==$url_to_check && $product_content['parent']==$cat_list[$f]['id']) {
							
							
							foreach ($cat_list as $key=>$val)
							{
								if ($val['param_left'] < $cat_list[$f]['param_left'] && $val['param_right'] > $cat_list[$f]['param_right'] && $val['param_level'] == $cat_list[$f]['param_level']-1) {
								$cat_parent_info = $val;
								$smarty->assign('cat_parent_info', $cat_parent_info);
								$smarty->assign('cat_content', $cat_list[$f]);
								$cat_parent = $shop->getParent($cat_parent_info);
								$smarty->assign('parent', $cat_parent);
								}								
							}
							
							$page_found=true;
							
							//передаем в шаблон инфу о родительской категории для левого меню
							//$smarty->assign('cat_parent_info', array("id", $product_content['parent']));

							
							$parent1 = $shop->getParent($cat_parent_info);
							if ($parent1)
							{
				            	if ($parent1['id'] == DISK_ID)
				            	{
				            		// тайлты для дисков
				            		$title_template = DISK_TITLE_TEMPLATE;
				            	}
				            	elseif ($parent1['id'] == TIRES_ID)
				            	{
				            		//тайтлы для шин
				            		$title_template = TIRES_TITLE_TEMPLATE;
				            	}
				            	
				            	$title_template = str_replace("{name}", $product_content['name'], $title_template);
				            	
				            	//if ( preg_match_all( '/\[([^\]]*)\]/', $title_template, $matches ) )
				            	if ( preg_match_all( '/\[([^\]]*)\]/', $title_template, $matches ) )
				            	{
									if (is_array($matches))
									{
										foreach ($matches as $key=>$val)
										{
											foreach ($matches[$key] as $key2=>$val2)
											{
												//почему-то повторяется два раза данные паттерн поэтому делаю еще одно условия
												if (preg_match("/\[(.*)\]/", $matches[$key][$key2], $str) )
												{
													if (isset($str[1]))
													{
														$array = explode("|", $str[1]);
														$random = rand(0, count($array)-1);
														$word = $array[$random];
														$title_template = str_replace($matches[$key][$key2], $word, $title_template);
													}
												}
											}
										}
									}
				            	}
							}
							
							
							//if ($product_content['title']!='') $page_title=$product_content['title'];
							if ($title_template) $page_title=$title_template;
							else $page_title=$product_content['name'];

							
							$smarty->assign("product",$product_content);
							
							if (PRODUCT_RATING=='on' or PRODUCT_COMMENTS=='on') {
								$this_module=$db->get_single("SELECT priv FROM fw_modules WHERE name='shop' LIMIT 1");
								if (@$_SESSION['fw_user']['priv']<=$this_module['priv']) {
									$smarty->assign("show_admin_menu","true");
									$is_admin=true;
								}
								else $is_admin=false;

								if (isset($_SESSION['fw_user']['priv']) && $_SESSION['fw_user']['priv']<=9) {
									$smarty->assign("allowed_user",true);
								}
							}

							if (PRODUCT_RATING=='on') {

								$check_rating=explode(",",@$_COOKIE['fw_rating']);
								if (in_array($product_content['id'],$check_rating)) $smarty->assign("rating_done","true");

								$smarty->assign("rating","on");
							}


							if ($cat_list[$f]['full_title']!='/') {
								$nav_titles=explode("/",$cat_list[$f]['full_title']);
								$nav_urls=explode("/",$cat_list[$f]['full_url']);
								unset($nav_titles[count($nav_titles)-1]);
								unset($nav_urls[count($nav_urls)-1]);
								for ($l=0;$l<count($nav_titles);$l++) {
									$navigation[]=array("url" => $nav_urls[$l],"title" => trim($nav_titles[$l]));
								}
							}
							$navigation[]=array("url" => $product_content['id'],"title" => $product_content['name']);


		unset($url[$n]);
					
							$meta_keywords=html_entity_decode($product_content['dictionary']);
							$meta_description=html_entity_decode($product_content['dictionary']);
							$template='product_details.html';
						}
					}
				}
			}
		}
}

}

?>