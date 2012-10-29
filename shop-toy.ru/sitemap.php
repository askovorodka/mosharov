<?php

require_once 'conf/globals.php';
require_once 'lib/class.array.php';
require_once 'lib/class.common.php';
require_once 'lib/class.db.php';
require_once 'modules/shop/front/class.shop.php';
require_once 'lib/class.session.php';
$_SESSION['db_connections'] = 0;

error_reporting(E_ALL);
ini_set('display_errors','On');

		print "start\n";
		//ini_set('memory_limit', '300M');
		
		
		if (@file_exists(ROOT . "/sitemap.xml"))
		{
			system("rm -rf " . ROOT . "/sitemap.xml");
		}
		
		$db = new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);
		$shop = new Shop($db);
		
		$db->query('SET wait_timeout = 0');

		$content=Common::generate_main_menu();
		
		$cat_list=$db->get_all("SELECT c.*, 
		(SELECT id FROM fw_catalogue WHERE 
		c.param_left>param_left AND c.param_level-param_level=1 ORDER BY param_left DESC LIMIT 1) as parent 
		FROM fw_catalogue as c WHERE c.status='1' and c.param_level > 0 ORDER BY c.id");
		
		if (count($content) > 0)
		{

			
			$imp = new DOMImplementation;
			$dtd = $imp->createDocumentType('yml_catalog', '', 'shops.dtd');
			
			$dom = $imp->createDocument("", "", $dtd);
			$dom->encoding = 'UTF-8';
			$dom->version = '1.0';
			
			$urlset = $dom->createElement('urlset');
			$urlset->setAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');
			
			foreach ($content as $item)
			{
				$url = $dom->createElement('url');
				$loc = $dom->createElement('loc');
				if (empty($item['full_url']))
					$full_url = 'http://shop-toy.com' . htmlspecialchars($item['url']);
				else 
					$full_url = 'http://shop-toy.com' . htmlspecialchars($item['full_url']);
				$link = $dom->createTextNode($full_url);
				$loc->appendChild($link);
				$url->appendChild($loc);
				$urlset->appendChild($url);
				
				if ($item['module'] == "shop")
				{
					foreach ($cat_list as $category)
					{
						$url = $dom->createElement('url');
						$loc = $dom->createElement('loc');
						$full_url = 'http://shop-toy.com/' . htmlspecialchars($shop->getFullUrlCategory($category['id'],'catalog')) . '/';
						$link = $dom->createTextNode($full_url);
						$loc->appendChild($link);
						$url->appendChild($loc);
						$urlset->appendChild($url);
						if ($category['param_level'] == 2)
						{
							$products_list = $db->get_all("
							SELECT p.* 
							FROM fw_products AS p 
							WHERE p.status='1' and p.price > 0 and p.parent = '{$category['id']}'");
							
							if (count($products_list))
							{
								foreach ($products_list as $product)
								{
									
									$url = $dom->createElement('url');
									$loc = $dom->createElement('loc');
									$full_url = 'http://shop-toy.com/' . htmlspecialchars($shop->getFullUrlProduct($product['id'],'catalog')) . '/';
									$link = $dom->createTextNode($full_url);
									$loc->appendChild($link);
									$url->appendChild($loc);
									$urlset->appendChild($url);
									
								}
							}
							
						}
					}
				}
				
			}
			
			$dom->appendChild($urlset);
			
			$dom->save(ROOT . "/sitemap.xml");
			
		}

		print "end\n";
		exit();
			
?>