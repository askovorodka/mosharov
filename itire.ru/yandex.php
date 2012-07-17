<?php

require_once 'conf/globals.php';
require_once 'lib/class.db.php';
require_once 'modules/shop/front/class.shop.php';
require_once 'lib/class.session.php';
$_SESSION['db_connections'] = 0;

error_reporting(E_ALL);
ini_set('display_errors','On');

/**
 * ����� �������� ������� � xml �������
 */
		//ini_set('memory_limit', '300M');
		
		
		if (@file_exists(BASE_PATH . "/yandexmarket.xml"))
		{
			@unlink(BASE_PATH . "/yandexmarket.xml");
		}
		
		$db = new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);
		$shop = new Shop($db);
		
		$db->query('SET wait_timeout = 0');

		echo "start time:" . date("Y-m-d H:i:s") . "\n\n";
		$time = time();

		
		$result=$db->query("SELECT * FROM fw_conf");
		while ($data=mysql_fetch_assoc($result)) {
			if (!defined($data["conf_key"])) define($data["conf_key"],$data["conf_value"]);
		}
		
		
		$cat_list=$db->get_all("SELECT c.*, 
		(SELECT id FROM fw_catalogue WHERE 
		c.param_left>param_left AND c.param_level-param_level=1 ORDER BY param_left DESC LIMIT 1) as parent 
		FROM fw_catalogue as c WHERE c.status='1' and c.param_level > 0 ORDER BY c.id");
		
		
		$products_list = $db->get_all("
			SELECT p.*, c.image FROM 
			fw_products AS p 
			LEFT JOIN fw_catalogue as c on p.parent = c.id
			WHERE p.status='1' and (p.tire_sklad > 0 or p.disk_sklad > 0)");


		if (count($products_list) > 0)
		{

			for ($a=0;$a<count($products_list);$a++)
			{
				$products_list[$a]['full_url']=$shop->getFullUrlProduct($products_list[$a]['id']);
			}
			
			$imp = new DOMImplementation;
			$dtd = $imp->createDocumentType('yml_catalog', '', 'shops.dtd');
			
			$dom = $imp->createDocument("", "", $dtd);
			$dom->encoding = 'UTF-8';
			$dom->version = '1.0';
			
			$yml_catalog = $dom->createElement('yml_catalog');
			$yml_catalog->setAttribute('date',date("Y-m-d H:i:s"));
			$shop = $dom->createElement('shop');
			
			
			$name = $dom->createElement('name');
			$text = $dom->createTextNode(iconv('windows-1251','utf-8',YANDEX_XML_TITLE));
			$name->appendChild($text);
			$shop->appendChild($name);
			
			$company = $dom->createElement('company');
			$text = $dom->createTextNode(BASE_URL);
			$company->appendChild($text);
			
			$url = $dom->createElement('url');
			$text = $dom->createTextNode(BASE_URL);
			$url->appendChild($text);
			
			$currencies = $dom->createElement('currencies');
			$currency = $dom->createElement('currency');
			$currency->setAttribute('id','RUR');
			$currency->setAttribute('rate','1');
			$currencies->appendChild($currency);
			$currency = $dom->createElement('currency');
			$currency->setAttribute('id','USD');
			$currency->setAttribute('rate','CBRF');
			$currencies->appendChild($currency);
			
			$shop->appendChild($company);
			$shop->appendChild($url);
			$shop->appendChild($currencies);
			
			$categories = $dom->createElement('categories');
			foreach ($cat_list as $item)
			{
				
				$category = $dom->createElement('category');
				$category->setAttribute('id',$item['id']);
				if ($item['param_level'] > 1)
				{
					$category->setAttribute('parentId', $item['parent']);
				}
				$text = $dom->createCDATASection(iconv('windows-1251','utf-8',$item['name']));
				$category->appendChild($text);
				$categories->appendChild($category);
				
				echo "add category: " . $item['id'] . " parent: {$item['parent']}\n";
				
			}
			
			$shop->appendChild($categories);
			
			$offers = $dom->createElement('offers');
			foreach ($products_list as $product)
			{
				$offer = $dom->createElement('offer');
				$offer->setAttribute('id',$product['id']);
				$offer->setAttribute('available','true');
				
				$url = $dom->createElement('url');
				$text = $dom->createTextNode(BASE_URL . '/shop' . $product['full_url']);
				$url->appendChild($text);
				$offer->appendChild($url);
				
				$price = $dom->createElement('price');
				$text = $dom->createTextNode($product['price']);
				$price->appendChild($text);
				$offer->appendChild($price);
				
				$currencyId = $dom->createElement('currencyId');
				$text = $dom->createTextNode('RUR');
				$currencyId->appendChild($text);
				$offer->appendChild($currencyId);
				
				$categoryId = $dom->createElement('categoryId');
				$text = $dom->createTextNode($product['parent']);
				$categoryId->appendChild($text);
				$offer->appendChild($categoryId);
				
				if (!empty($product['image']))
				{
					$picture = $dom->createElement('picture');
					$text = $dom->createTextNode(BASE_URL . '/uploaded_files/shop_images/b' . $product['image']);
					$picture->appendChild($text);
					$offer->appendChild($picture);
				}
				
				$store = $dom->createElement('store');
				$text = $dom->createTextNode('true');
				$store->appendChild($text);
				$offer->appendChild($store);
				
				$pickup = $dom->createElement('pickup');
				$text = $dom->createTextNode("true");
				$pickup->appendChild($text);
				$offer->appendChild($pickup);
				
				$delivery = $dom->createElement('delivery');
				$text = $dom->createTextNode('true');
				$delivery->appendChild($text);
				$offer->appendChild($delivery);
				
				$name = $dom->createElement('name');
				$text = $dom->createCDATASection(iconv('windows-1251','utf-8',$product['name']));
				$name->appendChild($text);
				$offer->appendChild($name);
				
				$sales_notes = $dom->createElement('sales_notes');
				if ($product['tire_sklad'] > 3 || $product['disk_sklad'] > 3)
					$text = $dom->createTextNode("Заказ от 4. Менее по согласованию.");
				elseif ($product['tire_sklad'] > 0)
					$text = $dom->createTextNode("Заказ от " . $product['tire_sklad'] . " штук.");
				elseif ($product['disk_sklad'] > 0)
					$text = $dom->createTextNode("Заказ от " . $product['disk_sklad'] . " штук.");
				//$text = $dom->createTextNode(iconv('windows-1251','utf-8',YANDEX_XML_SALES));
				$sales_notes->appendChild($text);
				$offer->appendChild($sales_notes);
				
				$offers->appendChild($offer);
				
				echo "add product: " . $product['id'] . "\n";
				
			}
			
			$shop->appendChild($offers);
			$yml_catalog->appendChild($shop);
			$dom->appendChild($yml_catalog);
			
			$dom->save(BASE_PATH . "/yandexmarket.xml");
			
			
			$time = time() - $time;
			echo "\nendtime time:" . date("Y-m-d H:i:s") . "\n\n";
			echo "total time running:" . ($time/60) . " minutes\n\n";
			
			exit();
			
		}


?>