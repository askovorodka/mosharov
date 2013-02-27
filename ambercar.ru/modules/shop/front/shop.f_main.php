<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

//$_SESSION['fw_basket']=array();

if ($switch_default=='on' or $main_module=='on') {
	
	$basket_number=0;
	$basket_total=0;
	for ($i=0;$i<count(@$_SESSION['fw_basket']);$i++) {
		$basket_number+=@$_SESSION['fw_basket'][$i]['number'];
		$basket_total+=@$_SESSION['fw_basket'][$i]['price']*@$_SESSION['fw_basket'][$i]['number'];
	}
	$smarty->assign("basket_number",$basket_number);
	$smarty->assign("basket_total",$basket_total);
	$smarty->assign("currency",DEFAULT_CURRENCY);
	
}

function filter_array($val)
{
	$val = preg_replace("/\d/","", $val);
	
	if (!$val)
		return true;
	else
		return false;
}


if  ($main_module=='on')
{

//$css[]=BASE_URL.'/templates/thickbox.css';

require_once 'lib/class.mail.php';
require_once 'lib/class.image.php';
require_once 'lib/class.photoalbum.php';
require_once 'lib/class.table.php';
require_once 'lib/class.form.php';
require_once 'lib/class.users.php';
require_once 'lib/sphinxapi.php';
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
$users = new Users();



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


	CASE (@$url[$n]=='step1' && $url[$n-1]=='basket'):

		$page_found=true;
		$navigation[]=array("url" => 'basket',"title" => 'Ваша корзина');
		$navigation[]=array("url" => 'step1',"title" => 'Оформление заказа');
		
		if ($user_id = $users->is_auth_user())
		{
			$user = $users->get_user($user_id);
			$smarty->assign('user', $user);
		}
		
		$title="Оформление заказа";
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
		$first_order = 1;
		
		if (!empty($_SESSION['fw_basket']))
		{
			$first_order = 0;
		}

		$number = $_POST['product_count'];
		$product_id = $_POST['product_id'];
		$product=$db->get_single("SELECT id,parent,name,price,sale,article,
						(SELECT id FROM fw_products_images i WHERE i.parent=fw_products.id ORDER BY insert_date DESC LIMIT 1) AS image,
						(SELECT ext FROM fw_products_images WHERE parent=fw_products.id ORDER BY insert_date DESC LIMIT 1) AS ext
		 				FROM fw_products WHERE id='".$product_id."' AND status='1'");

        
		for ($i=0;$i<count($_SESSION['fw_basket']);$i++) {
			if ($_SESSION['fw_basket'][$i]['id']==$product['id']) {
				$_SESSION['fw_basket'][$i]['number']=$_SESSION['fw_basket'][$i]['number']+$number;
				$number_found=true;
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
			$basket_total = number_format($basket_total,2,".","");
			print "$basket_number;$basket_total;$first_order";
			
		}
		exit();
		
	BREAK;


	/*CASE (@$url[$n-1]=='search_product' && preg_match("/\?keyword=(.+)$/",$url[$n]) && count($url)==3):

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

	BREAK;*/




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


	CASE ($url[$n]=='basket' && count($url)==2 || (count($url) >= 2 && $url[$n-1]=='basket' && preg_match("/^\?error=([a-z])/", $url[$n]))):

		$page_found=true;
		$navigation[]=array("url" => 'basket',"title" => 'Моя корзина');

		if ($user_id = $users->is_auth_user())
		{
			$user = $users->get_user($user_id);
			$smarty->assign('user', $user);
		}
		
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
					if ($_SESSION['fw_basket'][$i]['id']==$k && preg_match("/^([0-9]+)$/",$v)) $_SESSION['fw_basket'][$i]['number']=$v;
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
        		$sess['fw_basket'][$key]['full_url'] = $shop->getFullUrlProduct($sess['fw_basket'][$key]['id'],'catalog');
        		$sess['fw_basket'][$key]['image'] = $shop->getProductImage($sess['fw_basket'][$key]['id']);
        		
        }

			$smarty->assign("basket",$_SESSION['fw_basket']);
			
			$smarty->assign("total_price",sprintf("%.2f",$total_price));
			//if (isset($_SESSION['fw_user'])) $smarty->assign("user",$_SESSION['fw_user']);
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

		if (isset($_POST['submit_order'])) 
		{

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
				
				$check = true;
				//если пользователь зареген, берем данные из таблицы
				if ($user_id = $users->is_auth_user())
				{
					$user = $users->get_user($user_id);
				}
				//иначе если он хочет быть зареген, регистрируем и берем данные из таблицы
				elseif (!empty($_POST['password']))
				{
					
					$users->setName($_POST['name']);
					$users->setTel($_POST['phone']);
					$users->setEmail($_POST['email']);
					$users->setAddress($_POST['address']);
					$users->setPassword($_POST['password']);

					if (!$users->get_errors())
					{
						$user = $users->register();
						$smarty->assign('user', $user);
						$smarty->assign('password', $_POST['password']);
						$body=$smarty->fetch($templates_path.'/register_notice.txt');
						Mail::send_mail($user['mail'],"Регистрация Shop-Toy.com <noreply@shop-toy.com>","Регистрация в интернет магазине",$body,'','html','standard','Windows-1251');
						
					}
					else
					{
						$errors = $users->get_errors();
						header("Location: /catalog/basket/?error=" . $errors[0]);
						die();
					}
					
					
				}
				//иначе без регистрации
				else
				{
					$user = array();
					$user['name'] = $_POST['name'];
					$user['mail'] = $_POST['email'];
					$user['id'] = null;
					$user['tel'] = $_POST['phone'];
					$user['address'] = $_POST['address'];
					
					//проверка введенных данных через методы класса пользователя
					$users->setName($_POST['name']);
					$users->setEmail($_POST['email'], false);
					$users->setTel($_POST['phone']);
					if ($users->get_errors())
					{
						$errors = $users->get_errors();
						header("Location: /catalog/basket/?error=" . $errors[0]);
						die();
						
					}
					
				}
				
				$name=$user['name'];
				$comments=$_POST['comment'];
				$dostavka = $_POST['dostavka'];
				$address = $_POST['address'];
				
				if ($dostavka == 2)
				{
					$order_price = SHOP_DOSTAVKA_PRICE;
				}
				else 
				{
					$order_price = 0;
				}
				
				
				$total_price=0;
				for ($i=0;$i<count($_SESSION['fw_basket']);$i++)
				{
					
					$total_price+=$_SESSION['fw_basket'][$i]['price']*$_SESSION['fw_basket'][$i]['number'];
					
				}
				
				$total_sum = $total_price;
				$total_sum += $order_price;
				
				
				
				$db->query("INSERT INTO fw_orders (
					user,
					name,
					tel,
					mail,
					address,
					comments,
					total_price,
					insert_date,
					dostavka,
					order_price)
					VALUES('".$user['id']."','".$user['name']."','".$user['tel']."',
					'".$user['mail']."','".$user['address']."',
					'$comments',
					'$total_price',
					'".time()."',
					'{$dostavka}',
					'{$order_price}')");
				
				
				
				$order_id = mysql_insert_id();
				$rel_prod = array();
				for ($i=0;$i<count($_SESSION['fw_basket']);$i++) {
					$products_list.=$_SESSION['fw_basket'][$i]['id'].'|'.$_SESSION['fw_basket'][$i]['number'].',';
					$total_number=$total_number+$_SESSION['fw_basket'][$i]['number'];
					$rel_prod[] = "('".$_SESSION['fw_basket'][$i]['id']."','".$order_id."','".$_SESSION['fw_basket'][$i]['number']."', '".$_SESSION['fw_basket'][$i]['price']."')";
				}
				
				$db->query("INSERT INTO fw_orders_products (product_id,order_id,product_count, product_price) VALUES ".implode(",",$rel_prod));
				
				
				
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
				
				if ($dostavka > 2)
				{
					$smarty->assign("company_dost",$companies[$dostavka]);
				}
				
				$smarty->assign("name",$user['name']);
				$smarty->assign("site_url",BASE_URL);
				$smarty->assign("order_id",$order_id);
				$smarty->assign("date",time());
				$smarty->assign("order_total",$total_price);
				$smarty->assign("number",$total_number);
				$smarty->assign("currency",DEFAULT_CURRENCY);
				$smarty->assign("user",$user);
				$smarty->assign("dostavka",$dostavka);
				
				$smarty->assign("order_price",$order_price);
				$smarty->assign("total_sum",$total_sum);
				$smarty->assign("address",$address);
				$smarty->assign("comment",$comments);

				$body=$smarty->fetch($templates_path.'/order_notice.txt');

				Mail::send_mail($user['mail'],"Магазин игрушек Shop-Toy.com <orders@shop-toy.com>","Новый заказ в интернет магазине",$body,'','html','standard','Windows-1251');

				$admin_body=$smarty->fetch($templates_path.'/admin_order_notice.txt');

				Mail::send_mail("aschmitz@yandex.ru","Заказ Shop-Toy.com <".$user['mail'].">","Новый заказ в интернет магазине #{$order_id}",$admin_body,'','html','standard','Windows-1251');
				
				header("Location: /catalog/basket/final/");
				die();
			}

		}
		else
		{
			header("Location: ".BASE_URL);
		}

	BREAK;
	
	
	
	
	CASE (count($url) >= 2 && $url[$n-1] == "product_filter" ):

		$navigation[]=array("url" => 'product_filter',"title" => 'Поиск по параметрам');
		
		$where = array();
		$order = "";
		
		if (intval($_GET['age']) > 0)
		{
			$where[] = " fw_products.age = '".intval($_GET['age'])."'";
			$smarty->assign("filter_age",intval($_GET['age']));
		}

		if (intval($_GET['category']) > 0)
		{
			$where[] = " fw_products.parent = '".intval($_GET['category'])."'";
			$smarty->assign("filter_category",intval($_GET['category']));
		}
		

		if (intval($_GET['manufactury']) > 0)
		{
			$where[] = " brands.id = '".intval($_GET['manufactury'])."'";
			$smarty->assign("filter_manufactury",intval($_GET['manufactury']));
		}
		
		if (intval($_GET['price_start']) > 0)
		{
			$where[] = " fw_products.price >= '".intval($_GET['price_start'])."'";
			$smarty->assign("price_start",intval($_GET['price_start']));
			$order = " order by fw_products.price asc ";
		}
		
		if (intval($_GET['price_end']) > 0)
		{
			$where[] = " fw_products.price <= '".intval($_GET['price_end'])."'";
			$smarty->assign("price_end",intval($_GET['price_end']));
			$order = " order by fw_products.price asc ";
		}
		
		
		if (count($where) > 0)
		{
			$where_str = "and " . implode(" and ", $where);

			$search_results = $db->get_all("
			
			select fw_products.* from fw_products
			left join fw_catalogue as model on fw_products.parent = model.id
			left join brands on fw_products.brand_id = brands.id
			where fw_products.status = '1' " . $where_str . $order);
			
			
			if ($search_results)
			{
				foreach ($search_results as $key=>$val)
				{
					$search_results[$key]['full_url'] = $shop->getFullUrlProduct($val['id'],'catalog');
					$search_results[$key]['image'] = $shop->getProductImage($val['id']);
				}
				
				$smarty->assign("search_results",$search_results);
				
			}
			
		}

		


		$page_found=true;
		$template='search.html';

	BREAK;
	
	
	
	
	DEFAULT:

		
		if (!empty($url[$n]))
		{
			
			//если передаются параметры фильтра
			if (preg_match("/^\?(.*)/", $url[$n]))
			{
				unset($url[$n]);
				$n--;
			}

			if (count($url) == 1)
			{
				$categories = $shop->getCategories(1);
				foreach ($categories as $key=>$val)
				{
					$categories[$key]['models'] = $shop->getChildrenCategor($val, 2);
					if (isset($categories[$key]['models']))
					{
						foreach ($categories[$key]['models'] as $key2=>$val2)
						{
							$categories[$key]['models'][$key2]['full_url'] = $shop->getFullUrlCategory($val2['id'],'catalog');
						}
					}
				}

				$smarty->assign('marks', $categories);
				$template = 'marks.tpl';
			}
			
			$page_found = true;
			//находим дочернии категории список категорий товаров марки/модели
			if (count($url) == 3)
			{
				$mark_url = (string)$url[$n];
				$model = $shop->get_category_by_url($mark_url);
				if (!empty($model))
				{
					$types = $shop->get_products_types_by_category($model['id']);
					$mark = $shop->getParent($model,1);
					$smarty->assign('types', $types);
					$smarty->assign('model', $model);
					$smarty->assign('mark', $mark);
					
					$navigation[]=array("url" => $model['url'],"title" => $mark['name']." ".$model['name']);
					$template = 'types.tpl';
					
				}
				
			}
			
			if (count($url) == 4)
			{
				$type_id = intval($url[$n]);
				$model_name = (string)urldecode($url[$n-1]);
				$mark_name = (string)urldecode($url[$n-2]);
				
				$model = $shop->get_category_by_url($model_name);
				$type = $shop->get_product_type($type_id);
				$mark = $shop->get_category_by_url($mark_name);
				
				if (!empty($model) and !empty($type_id))
				{
					$products = $shop->get_products_by_category_and_type($model['id'], $type_id);
					
					if (count($products))
					{
						foreach ($products as $key=>$val)
						{
							$products[$key]['full_url'] = $shop->getFullUrlProduct($val['id'],'catalog');
							$products[$key]['image'] = $shop->getProductImage($val['id']);
						}
						
						$smarty->assign('products', $products);
						
					}
				}
				
				$navigation[]=array("url" => $mark_name . '/' . $model_name,"title" => $mark['name']." ".$model['name']);
				$navigation[]=array("url" => null,"title" => $type['name']);
				
				$smarty->assign('model', $model);
				$smarty->assign('mark', $mark);
				$smarty->assign('type', $type);
				
				$template = 'products.tpl';
			}
			
			if (count($url) == 5)
			{
				
				$type_id = intval($url[$n]);
				$product_id = intval($url[$n-1]);
				$model_name = (string)urldecode($url[$n-2]);
				$mark_name = (string)urldecode($url[$n-3]);
				
				$model = $shop->get_category_by_url($model_name);
				$type = $shop->get_product_type($type_id);
				$mark = $shop->get_category_by_url($mark_name);
				$product = $shop->getProductInfo($product_id);
				$images = $shop->getProductImages($product_id);

				$navigation[]=array("url" => $mark_name . '/' . $model_name,"title" => $mark['name']." ".$model['name']);
				$navigation[]=array("url" => $type['id'],"title" => $type['name']);
				$navigation[]=array("url" => $product['id'],"title" => $product['name']);
				
				$smarty->assign('model', $model);
				$smarty->assign('mark', $mark);
				$smarty->assign('type', $type);
				$smarty->assign('product', $product);
				$smarty->assign('images', $images);
				
				$template = 'product.tpl';
			}
			
			
			/*if (empty($category) && count($url) >= 2)
			{
				Common::_404();
			}*/
			
			
			
			$brands_list = array();
			$brands = array();
			
			
			/*if (!empty($category))
			{
				$categories = $shop->getChildrenCategor($category, 2);
				if (!empty($categories))
				{
					foreach ($categories as $key=>$val)
					{
						$categories[$key]['full_url'] = $shop->getFullUrlCategory($val['id'],'catalog');
						array_push($brands_list, $shop->get_brands_by_category($val['id']));
					}
				}
				else 
				{
					Common::_404();
				}
			}*/
			
			/*if (count($brands_list) > 0)
			{
				
				foreach ($brands_list as $key=>$val)
				{
					foreach ($val as $value)
						$brands[$value['id']] = array("id" => $value['id'], "name" => $value['name']);
				}
			}
			
			$where = array();
			$where[] = "status='1'";
			$limit = "";
			
			if (count($url) == 1)
			{
				
				$limit = " limit 100 ";
				$brands = $shop->get_brands();
			}*/
			
			
			/*if (!empty($url[1]) && empty($url[2]))
			{
				if (!empty($categories))
				{
					foreach($categories as $cat)
					{
						$ids[] = $cat['id'];
					}
					$where[] = "parent in (" . implode(",", $ids) . ")";
					$limit = " limit 100";
				}
			}*/
			
			
			/*if (!empty($_GET['categories']))
			{
				$cats_filter = explode(",", $_GET['categories']);
				$cats_filter = array_filter($cats_filter, "filter_array");
				
				if (empty($cats_filter))
					Common::_404();
				
				$smarty->assign('cats_filter', $cats_filter);
				$where[] = "parent in (" . implode(",", $cats_filter) . ")";
			}
			
			if (!empty($_GET['brands']))
			{
				$brands_filter = explode(",", $_GET['brands']);
				$brands_filter = array_filter($brands_filter, "filter_array");
				
				if (empty($brands_filter))
					Common::_404();
				
				$smarty->assign('brands_filter', $brands_filter);
				$where[] = "brand_id in (" . implode(",", $brands_filter) . ")";
			}
			
			if (!empty($_GET['price_start']))
			{
				$where[] = "price >= " . intval($_GET['price_start']);
				$smarty->assign('filter_price_start', intval($_GET['price_start']));
			}
			
			if (!empty($_GET['price_end']))
			{
				$where[] = "price <= " . intval($_GET['price_end']);
				$smarty->assign('filter_price_end', intval($_GET['price_end']));
			}
			
			if (!empty($_GET['age_start']))
			{
				$where[] = "age >= " . intval($_GET['age_start']);
				$smarty->assign('filter_age_start', intval($_GET['age_start']));
			}
			
			if (!empty($_GET['age_end']))
			{
				$where[] = "age <= " . intval($_GET['age_end']);
				$smarty->assign('filter_age_end', intval($_GET['age_end']));
			}
			
			//текстовый поиск
			if (!empty($_GET['search']))
			{
				$search_string = trim($_GET['search']);
				
				//поиск продуктов
				$sphinx = new SphinxClient();
				$sphinx->SetServer("localhost",3312);
				$sphinx->SetMatchMode(SPH_MATCH_ANY);
				$sphinx->SetSortMode(SPH_SORT_RELEVANCE);
				$result = $sphinx->Query($search_string,'*');
				
				if (!empty($result['matches']))
				{
					$products_ids = array_keys($result['matches']);
					$where[] = " fw_products.id in (" . implode(",", $products_ids) . ")";
				}
				else 
				{
					$where[] = " fw_products.id < 0 ";
				}
				
			}
			
			if (!empty($category))
			{
				$category['full_url'] = $shop->getFullUrlCategory($category['id'],'catalog');
				$smarty->assign('category', $category);
			}
			
			$smarty->assign('brands', $brands);
			
			if (!empty($categories))
			{
				$smarty->assign('categories', $categories);
			}
			*/
			
			/*if (count($url) < 4)
			{
				
				$products = $db->get_all("select * from fw_products where " . implode(" and ", $where) . $limit);
				if ($products)
				{
					
					foreach ($products as $key=>$val)
					{
						$products[$key]['full_url'] = $shop->getFullUrlProduct($val['id'],'catalog');
						$products[$key]['image'] = $shop->getProductImage($val['id']);
					}
					$smarty->assign('products', $products);
				}
				
				
				$page_found = true;
				
				if (!empty($_GET['ajax']))
				{
					$switch_off_smarty = true;
					$content = $smarty->fetch("../modules/shop/front/templates/shop.f_filter_result.html");
					header("Content-type: text/html; charset=Windows-1251");
					echo $content;
					die();
				}
				else 
				{
					$template = "shop.f_filter_result.html";
				}
				
			}*/
			/*else
			{
				
				//если отдельный продукт
				$product_id = intval($url[$n]);
				$product = $shop->getProductInfo($product_id);
				
				if (!$product)
				{
					Common::_404();
				}
				
				$page_found = true;
				
				$parentcat = $shop->getCategory($product['parent']);
				
				$navigation[]=array("url" => $category['url'],"title" => $category['name']);
				$navigation[]=array("url" => "?brands=" . $product['parent'],"title" => $parentcat['name']);
				
				
				
				if ($product['meta_keywords']!='') 
					$meta_keywords=$product['meta_keywords'];
								
				if ($product['meta_description']!='') 
					$meta_description=$product['meta_description'];
								
				$smarty->assign("product",$product);
				
				$images = $shop->getProductImages($product['id']);
				$smarty->assign("images",$images);
				
				$template='product_details.html';
				
			}*/
			
			
		}
		
		
		if (!$page_found) {

			$product_id = intval($url[$n]);
			
			$product = $shop->getProductInfo($product_id);
			if (!$product)
			{
				Common::_404();
			}
			
			$page_found = true;
			
			if ($product['meta_keywords']!='') 
				$meta_keywords=$product['meta_keywords'];
			else
				$meta_keywords=$page_title;
							
			if ($product['meta_description']!='') 
				$meta_description=$product['meta_description'];
			else 
				$meta_description=$page_title;
							
			$smarty->assign("product",$product);
			
			$images = $shop->getProductImages($product['id']);
			$smarty->assign("images",$images);
			
			$template='product_details.html';
			
		}
}

}

?>