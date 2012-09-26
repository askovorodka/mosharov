<?php 



//error_reporting(E_ALL);
//ini_set('display_errors','On');

$path = dirname(__FILE__) . "/";

require_once $path.'conf/globals.php';
require_once $path.'lib/class.db.php';
require_once $path.'lib/class.string.php';
require_once $path.'lib/class.tree.php';
require_once ($path.'modules/shop/front/class.shop.php');

$_SESSION['db_connections'] = 0;

$db=new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

$table='fw_catalogue';
$id_name='id';
$field_names = array(
   'left' => 'param_left',
   'right'=> 'param_right',
   'level'=> 'param_level',
);

$tree=new CDBTree($db, $table, $id_name, $field_names);
$string = new String();
$shop = new Shop($db);

/*$id = $tree->clear();
$tree->insert($id, array("name" => "Шины", "url" => "tires"));
$tree->insert($id, array("name" => "Диски", "url" => "disk"));*/

$conf = $db->get_single("select conf_value from fw_conf where conf_key='CATEGORY_TEXT_TEMPLATE'");
$cat_text_template = $conf['conf_value'];

$db->query("update fw_products set disk_sklad=0, tire_sklad=0");

system("/usr/local/bin/wget --user=demon --password=gthtgenmt -c --content-disposition -P {$path}xml/ http://demo.itire.ru/xml/cccpshina.xml");

$xml = simplexml_load_file($path.'xml/cccpshina.xml');
$rims = $xml->rims->rim;

foreach ($rims as $rim)
{
	$parent0 = $shop->getCategory(DISK_ID);
	$brand_name = mysql_real_escape_string(iconv("utf-8", "windows-1251", $rim->brand));
	$model_name = mysql_real_escape_string(iconv("utf-8", "windows-1251", $rim->model));
	$name = mysql_real_escape_string(iconv("utf-8", "windows-1251", $rim->name));
	$price = $rim->price;
	$article = $rim->article;
	$disk_width = $rim->disk_width;
	$disk_diameter = $rim->disk_diameter;
	$disk_krep = $rim->disk_krep;
	$disk_pcd = $rim->disk_pcd;
	$disk_pcd2 = $rim->disk_pcd2;
	$disk_et = $rim->disk_et;
	$disk_dia = $rim->disk_dia;
	$disk_color = iconv("utf-8", "windows-1251", $rim->disk_color);
	$disk_type = $rim->disk_type;
	$disk_sklad = $rim->sklad;
	
	
	$brand = $db->get_single("
		SELECT * FROM fw_catalogue 
					WHERE name = '{$brand_name}' and param_level = '2' and 
					param_left  between '{$parent0['param_left']}' 
					and '{$parent0['param_right']}' ");
	if (isset($brand) && isset($brand['id']))
	{
		$brand_id = $brand['id'];
	}
	else 
	{
					
		$tree->insert($parent0['id'], array(
			'name' => $brand_name,
			'url' => $string->string_formater($string->translit(strtolower($brand_name))),
			'text' => '',
			'status' => '1',
			'title' => $brand_name,
			'meta_keywords' => $brand_name,
			'meta_description' => $brand_name
		));
					
		$brand_id = mysql_insert_id();
		$brand = $shop->getCategory($brand_id);
					
	}
	
	
	if ($brand_id)
	{
		$model = $db->get_single("SELECT * FROM fw_catalogue
		WHERE name = '{$model_name}' and param_level = '3'
		and param_left between '{$brand['param_left']}' and '{$brand['param_right']}' ");
		if (isset($model) && isset($model['id']))
		{
			$model_id = $model['id'];
		}
		else
		{
			$tree->insert($brand['id'], array(
				'name' => $model_name,
				'url' => $string->string_formater($string->translit(strtolower($model_name))),
				'text' => str_replace("{brand_name}", $brand['name'], str_replace("{model_name}", $model_name, $cat_text_template) ),
				'status' => '1',
				'title' => "{$brand['name']} {$model_name}",
				'meta_keywords' => "{$brand['name']} {$model_name}",
				'meta_description' => "{$brand['name']} {$model_name}"
			));
			$model_id = mysql_insert_id();
		}
	}
	
	
	$product = $shop->search_product($name, $model_id);
	if (!$product)
	{
		$product_id = $shop->insert_disk($model_id, $name, $disk_width, $disk_diameter, $disk_krep, $disk_pcd, $disk_pcd2, $disk_et, $disk_dia, $disk_color, $price, $disk_sklad);
		print "insert rim " . $product_id . "\n";
	}
	else 
	{
		$shop->update_disk($product['id'], $price, $disk_sklad);
		print "update rim " . $product['id'] . "\n";
	}
	
	
}









$tires = $xml->tires->tire;

foreach ($tires as $tire)
{
	$parent0 = $shop->getCategory(TIRES_ID);
	$brand_name = mysql_real_escape_string(iconv("utf-8", "windows-1251", $tire->brand));
	$model_name = mysql_real_escape_string(iconv("utf-8", "windows-1251", $tire->model));
	$name = mysql_real_escape_string(iconv("utf-8", "windows-1251", $tire->name));
	$price = $tire->price;
	$article = $tire->article;
	$tire_width = $tire->tiree_width;
	$tire_height = $tire->tire_height;
	$tire_diameter = $tire->tire_diameter;
	$tire_in = $tire->tire_in;
	$tire_is = $tire->tire_is;
	$tire_usil = $tire->tire_usil;
	$tire_spike = $tire->tire_spike;
	$tire_season = $tire->tire_season;
	$tire_bodytype = $tire->tire_bodytype;
	$tire_sklad = $tire->sklad;
	
	
	$brand = $db->get_single("
		SELECT * FROM fw_catalogue 
					WHERE name = '{$brand_name}' and param_level = '2' and 
					param_left  between '{$parent0['param_left']}' 
					and '{$parent0['param_right']}' ");
	if (isset($brand) && isset($brand['id']))
	{
		$brand_id = $brand['id'];
	}
	else 
	{
					
		$tree->insert($parent0['id'], array(
			'name' => $brand_name,
			'url' => $string->string_formater($string->translit(strtolower($brand_name))),
			'text' => '',
			'status' => '1',
			'title' => $brand_name,
			'meta_keywords' => $brand_name,
			'meta_description' => $brand_name
		));
					
		$brand_id = mysql_insert_id();
		$brand = $shop->getCategory($brand_id);
					
	}
	
	
	if ($brand_id)
	{
		$model = $db->get_single("SELECT * FROM fw_catalogue
		WHERE name = '{$model_name}' and param_level = '3'
		and param_left between '{$brand['param_left']}' and '{$brand['param_right']}' ");
		if (isset($model) && isset($model['id']))
		{
			$model_id = $model['id'];
		}
		else
		{
			$tree->insert($brand['id'], array(
				'name' => $model_name,
				'url' => $string->string_formater($string->translit(strtolower($model_name))),
				'text' => str_replace("{brand_name}", $brand['name'], str_replace("{model_name}", $model_name, $cat_text_template) ),
				'status' => '1',
				'title' => "{$brand['name']} {$model_name}",
				'meta_keywords' => "{$brand['name']} {$model_name}",
				'meta_description' => "{$brand['name']} {$model_name}"
			));
			$model_id = mysql_insert_id();
		}
	}
	
	
	$product = $shop->search_product($name, $model_id);
	if (!$product)
	{
		$product_id = $shop->insert_tire($model_id, $name, 
			$tire_width, $tire_height, $tire_diameter, $tire_in, $tire_is, 
			$tire_usil, $tire_spike, $price, $tire_sklad);
		print "insert tire " . $product_id . "\n";
	}
	else 
	{
		$shop->update_tire($product['id'], $price, $tire_sklad);
		print "update tire " . $product['id'] . "\n";
	}
	
	
}


?>