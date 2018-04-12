<?php
//вспомогательный класс
class Shop extends db {

	
	var $db;
	function Shop($db)
	{
		$this->db = &$db;
	}

	public function getUserOrders($userId)
	{
		$sql = "select * from fw_orders where user='{$userId}' order by insert_date desc";
		$orders = $this->db->get_all($sql);
		if (!empty($orders))
		{
			foreach ($orders as $key=>$val)
			{
				$orders[$key]['items'] = $this->getItemsByOrderId($val['id']);
			}
		}
		return $orders;
	}

	public function getItemsByOrderId($orderId)
	{
		$sql = "select * from fw_orders_products where order_id='{$orderId}'";
		$items = $this->db->get_all($sql);
		if (!empty($items))
		{
			foreach($items as $key=>$val)
			{
				$items[$key]['product'] = $this->getProductInfo($val['product_id']);
			}
		}

		return $items;
	}


	public function productPropertyExist($productId, $propertyKey, $propertyValue, $parentId = 0)
	{
		$query = "select id from properties where product_id='{$productId}' and `key`='{$propertyKey}' and `value`='{$propertyValue}' and parent_id='{$parentId}' limit 1";
		$result =  $this->db->get_single($query);
		return !empty($result['id']) ? $result : null;
	}

	public function addProductProperty($productId, $propertyKey, $propertyValue, $parentId = 0)
	{
		$query = "insert into properties (product_id, `key`, `value`, parent_id)
			values ('{$productId}', '{$propertyKey}', '{$propertyValue}', '{$parentId}')";
		$this->db->query($query);
		$result = $this->db->get_single("select max(id) as `max` from properties limit 1");
		return $result['max'];
	}

	public function getProductProperties($productId, $propertyKey, $parentId = 0, $status = null)
	{
		$where = null;
		if (isset($status))
		{
			$status = (int) $status;
			$where = " and `status` = '{$status}' ";
		}
		$query = "select * from properties where product_id='{$productId}' and `key`='{$propertyKey}' and parent_id='{$parentId}' {$where} order by `value` asc";
		$properties =  $this->db->get_all($query);

		if (!empty($properties))
		{
			foreach($properties as $key => $val)
			{
				$colors = $this->getProductProperties($productId, 'color', $val['id'], $status);
				if (!empty($colors)){
					$properties[$key]['colors'] = $colors;
				}
				$size_brand = $this->getProductProperties($productId, 'size_brand', $val['id'], $status);
				if (!empty($size_brand)){
					$properties[$key]['size_brand'] = $size_brand;
				}

			}
		}

		return !empty($properties) ? $properties : null;

	}

	public function getPropertiesByKey($propertyKey, $status = 1)
	{
		$sql = "select `key`, `value`
				from properties
				where `key`='{$propertyKey}' and `status`='{$status}'
				group by `value`";
		return $this->db->get_all($sql);
	}

	public function findCode($code, $state = null)
	{

		$where = array();
		$where[] = " promo_codes.code='{$code}' ";
		if ($state){
			$where[] = " state='{$state}' ";
		}

		if (!empty($where)){
			$where = " WHERE " . implode(" and ", $where);
		}

		$query = " select * from promo_codes {$where} limit 1";

		return $this->db->get_single($query);
	}

	public function findCodeByUserData($code, $userPhone = null, $userEmail = null)
	{

		$where = array();
		if (!empty($userPhone)){
			$where[] = " promo_codes_users.user_phone='{$userPhone}' ";
		}
		if (!empty($userEmail)){
			$where[] = " promo_codes_users.user_email='{$userEmail}' ";
		}
		if (!empty($where)){
			$where = " WHERE (" . implode(" or ", $where) . ")";
		}

		$where .= " and promo_codes_users.code='{$code}' ";
		$sql = "select promo_codes.code
			from promo_codes
			inner join promo_codes_users
			on promo_codes.code = promo_codes_users.code
			{$where} limit 1";

		return $this->db->get_single($sql);

	}

	public function setUserDataByPromo($code, $userPhone = null, $userEmail = null, $orderId = null)
	{
		$sql = "replace into promo_codes_users(`code`,`user_phone`,`user_email`,`order_id`)
			values('{$code}', '{$userPhone}', '{$userEmail}','{$orderId}');
		";
		$this->db->query($sql);
	}

	function getImageProductByCategory($cat_id)
	{
		$products = $this->getProductsByCategory($cat_id);
		if ($products)
		{
			foreach ($products as $product)
			{
				$image = $this->getProductImage($product['id']);
				if (!empty($image))
				{
					return $image;
				}
			}
		}
	}
	
	function getTopProducts($limit = 1)
	{
		$result = $this->db->get_all("select * from fw_products where status='1' and hit='1'");
		
		if ($result && count($result) > 0)
		{
			foreach ($result as $key=>$val)
			{
				$result[$key]['full_url'] = $this->getFullUrlProduct($val['id'], "catalog");
				$result[$key]['category'] = $this->getCategory($val['parent']);
				$result[$key]['image'] = $this->getProductImage($val['id']);
			}
			return $result;
		}
		else 
		{
			return null;
		}

	}


	function searchCount($where)
	{
		if (count($where) > 0)
		{
			$where = " and " . implode(" and ", $where);
		}
		else 
		{
			$where = "";
		}
		
		$result = $this->db->query("select count(*) as count 
		from fw_products as a
		left join fw_catalogue as b on a.parent = b.id 
		where a.status = '1' and (a.tire_sklad > 0 or a.disk_sklad > 0) " . $where . " order by a.insert_date desc");
		
		return $result;
		
	}


	function search($keyword, $sort_field = "date", $sort_order = "desc")
	{
		if (count($where) > 0)
		{
			$where = " and " . implode(" and ", $where);
		}
		else 
		{
			$where = "";
		}
		
		switch ($sort_field)
		{
			case 'date':
				$sort_field = " order by a.insert_date";
				break;
			case 'name':
				$sort_field = "order by a.name";
				break;
			case 'article':
				$sort_field = "order by a.article";
				break;
			case 'disk_width':
				$sort_field = "order by a.disk_width";
				break;
			case 'tire_width':
				$sort_field = "order by a.tire_width";
				break;
			case 'tire_height':
				$sort_field = "order by a.tire_height";
				break;
			case 'tire_diameter':
				$sort_field = "order by a.tire_diameter";
				break;
			case 'disk_diameter':
				$sort_field = "order by a.disk_diameter";
				break;
			case 'disk_krep':
				$sort_field = "order by a.disk_krep";
				break;
			case 'price':
				$sort_field = "order by a.price";
				break;
			
		}
		
		if ($sort_order == "asc" || $sort_order = "desc")
		{
			$sort_order = $sort_order;
		}
		else 
		{
			$sort_order = "desc";
		}
		
		
		$result = $this->db->get_all("select a.*
		from fw_products as a 
		where a.status = '1' and (name like '{$keyword}%' or article='{$keyword}' or price='{$keyword}' or country='{$keyword}') " . 
		" {$sort_field} {$sort_order} ");
		
		return $result;
		
	}


	/**
	 * Полный путь до продукта
	 *
	 * @param unknown_type $id
	 */
	function getFullUrlProduct($id, $module_name = "")
	{
		$product = self::getProductInfo($id);
		if (!$product)
		{
			return false;
		}
		$category = self::getCategory($product['parent']);
		
		$url = $id;
		if ($category)
		{

			$url = $category['url'] . '/' . $url;
			for ($i = $category['param_level']; $i > 1; $i--)
			{
				$category = self::getParent($category, $category['param_level']-1 );
				$url = $category['url'] . '/' . $url;
			}
		}

		if ($module_name) {
		    return $module_name . "/" . $url;
        } else {
		    return $url;
        }
		
	}

	function getFullUrlCategory($id, $module_name = "")
	{
		$category = self::getCategory($id);
		$url = "";
		if ($category)
		{
			$url = $category['url'];
			for ($i = $category['param_level']; $i > 1; $i--)
			{
				$category = self::getParent($category, $category['param_level']-1 );
				$url = $category['url'] . '/' . $url;
			}
		}
		return ($module_name) ? $module_name . "/" .$url : $url;
		
	}

	function getUser($id)
	{
		$result = $this->db->get_single("select * from fw_users where id = '{$id}'");
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
	}

	function getChildrenCategor($categor, $param_level = null)
	{
		if (isset($param_level))
		{
			$where = " and param_level = '{$param_level}' ";
		}
		else 
		{
			$where = "";
		}
		$result = $this->db->get_all("SELECT * FROM fw_catalogue WHERE param_left BETWEEN '{$categor['param_left']}' 
					and '{$categor['param_right']}' and status = '1' " . $where);
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
		
	}


	function getCategories($param_level = 0)
	{
		$result = $this->db->get_all("select * from fw_catalogue where status='1' and param_level >= '{$param_level}' order by param_left");
		
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
		
	}
	
	
	function getProductsProperties($categories)
	{
		if (is_array($categories))
		{
			$where = " and parent in (" . implode(",", $categories) . ")";
		}
		else 
		{
			$where = " and parent = '{$categories}' ";
		}
		
		$result = $this->db->get_single("
					SELECT min(disk_diameter) as min_diameter, 
					max(disk_diameter) as max_diameter,
					min(disk_width) as min_width,
					max(disk_width) as max_width,
					avg(disk_krep) as avg_krep,
					avg(disk_pcd) as avg_pcd,
					min(price) as price
					from fw_products where status = '1' and (tire_sklad > 0 or disk_sklad > 0) " . $where);
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
		
	}


	function getProductsPropertiesTires($categories)
	{
		if (is_array($categories))
		{
			$where = " and parent in (" . implode(",", $categories) . ")";
		}
		else 
		{
			$where = " and parent = '{$categories}' ";
		}
		
		$result = $this->db->get_single("
					SELECT min(tire_diameter) as min_diameter, 
					max(tire_diameter) as max_diameter,
					min(tire_width) as min_width,
					max(tire_width) as max_width,
					min(price) as price
					from fw_products where status = '1' and tire_sklad > 0 " . $where);
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
		
	}
	
	
	function getProductsPropertiesDisk($categories)
	{
		if (is_array($categories))
		{
			$where = " and parent in (" . implode(",", $categories) . ")";
		}
		else 
		{
			$where = " and parent = '{$categories}' ";
		}
		
		$result = $this->db->get_single("
					SELECT min(disk_diameter) as min_diameter, 
					max(disk_diameter) as max_diameter,
					min(disk_width) as min_width,
					max(disk_width) as max_width,
					min(price) as price
					from fw_products where status = '1' and disk_sklad > 0 " . $where);
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
		
	}
	
	
	function getParent($categor, $param_level = 1)
	{
		$result = $this->db->get_single("
			SELECT * FROM fw_catalogue 
			WHERE param_left < '{$categor['param_left']}' and param_right > '{$categor['param_right']}' and param_level = '{$param_level}'");
		
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
		
	}
	
	
	function getProductInfo($id)
	{
		$result = $this->db->get_single("
			SELECT a.*
			FROM fw_products as a 
			WHERE a.id = '{$id}'");
		
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
		
	}
	
	
	function getDiskType($id)
	{
		$result = $this->db->get_single("select * from fw_disk_types where id = '{$id}'");
		if ($result)
		{
			return $result;
		}
		else
		{
			return null;
		}
	}
	
	
	function getCategory($id)
	{
		$result = $this->db->get_single("SELECT * FROM fw_catalogue WHERE id = '{$id}'");
		
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
		
	}

	function getCategoryByUrl($url, $id = null)
	{
		$url = trim($url);
		$where = "";
		if (!empty($id))
		{
			$where = " and id <> '{$id}'";
		}
		$result = $this->db->get_single("SELECT * FROM fw_catalogue WHERE url = '{$url}' " . $where . " limit 1");

		if ($result)
		{
			return $result;
		}
		else
		{
			return null;
		}

	}

	function checkCategoryUrl($url, $id = null)
	{
		$count = 0;
		while($this->getCategoryByUrl($url, $id) !== null)
		{
			$url = preg_replace("/\_([0-9]+)$/is", "", $url);
			$url .= "_" . ++$count;
		}
		return $url;
	}


	function getBodyById($id)
	{
		$result = $this->db->get_single("SELECT * FROM fw_body_types WHERE id = '{$id}'");
		
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
	}
	
	
	function getProductsByCategory($cat_id)
	{
		
		$result = $this->db->get_all("
				SELECT *,
						(SELECT id FROM fw_products_images i WHERE i.parent=p.id ORDER BY sort_order ASC LIMIT 1) AS image,
						(SELECT ext FROM fw_products_images WHERE parent=p.id ORDER BY insert_date DESC LIMIT 1) AS ext
					FROM fw_products AS p
					WHERE p.parent='".$cat_id."' AND p.status='1' order by p.sort_order");
		
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
		
	}
	
	
	
	function getProductImages($product_id)
	{
		
		$result = $this->db->get_all("select * from fw_products_images where parent='{$product_id}' ");
		
		if ($result)
		{
			return $result;
		}
		else
		{
			return null;
		}
		
	}

	
	function getProductImage($product_id)
	{
		
		$result = $this->db->get_single("select id, ext from fw_products_images where parent='{$product_id}' order by sort_order limit 1 ");
		
		if ($result)
		{
			return $result['id'].'.'.$result['ext'];
		}
		else
		{
			return null;
		}
		
	}
	
	
	function get_product_properties($product_id)
	{
		
		$result = $this->db->get_all("select * from fw_products_properties as a left join fw_catalogue_properties as b on a.property_id=b.id where a.product_id='{$product_id}' ");
		
		if ($result)
		{
			return $result;
		}
		else
		{
			return null;
		}
		
	}
	
	
	function get_catalog_properties($cat_id, $entity = null)
	{
		$where = null;
		if (!empty($entity)){
			$where = " and fw_catalogue_properties.entity='{$entity}' ";
		}
		$result = $this->db->get_all("select *
				from fw_catalogue_relations
				left join fw_catalogue_properties on fw_catalogue_relations.property_id=fw_catalogue_properties.id
				where fw_catalogue_relations.cat_id='{$cat_id}' {$where}
				order by fw_catalogue_properties.id");
		
		if ($result)
		{
			foreach($result as $key=>$value)
			{
				if (!empty($value['elements'])) {
					$result[$key]['elements_array'] = explode("\n", $value['elements']);
				}
			}
			return $result;
		}
		else
		{
			return null;
		}
		
	}

	public function getProductPropertiesByEntity($product_id, $entity)
	{
		$sql = "select fw_products_properties.*
			FROM fw_products_properties
			inner join fw_products on fw_products_properties.product_id = fw_products.id
			inner join fw_catalogue_properties on fw_products_properties.property_id=fw_catalogue_properties.id
			WHERE fw_products_properties.product_id='{$product_id}' and fw_catalogue_properties.entity='{$entity}' ";

		$result = $this->db->get_all($sql);

		return $result;
	}

    public function json_encode_cyr($str) {
        $arr_replace_utf = array('\u0410', '\u0430','\u0411','\u0431','\u0412','\u0432',
            '\u0413','\u0433','\u0414','\u0434','\u0415','\u0435','\u0401','\u0451','\u0416',
            '\u0436','\u0417','\u0437','\u0418','\u0438','\u0419','\u0439','\u041a','\u043a',
            '\u041b','\u043b','\u041c','\u043c','\u041d','\u043d','\u041e','\u043e','\u041f',
            '\u043f','\u0420','\u0440','\u0421','\u0441','\u0422','\u0442','\u0423','\u0443',
            '\u0424','\u0444','\u0425','\u0445','\u0426','\u0446','\u0427','\u0447','\u0428',
            '\u0448','\u0429','\u0449','\u042a','\u044a','\u042b','\u044b','\u042c','\u044c',
            '\u042d','\u044d','\u042e','\u044e','\u042f','\u044f');
        $arr_replace_cyr = array('А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
            'Ё', 'ё', 'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о',
            'П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш',
            'Щ','щ','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я');
        $str1 = json_encode($str);
        $str2 = str_replace($arr_replace_utf,$arr_replace_cyr,$str1);
        return $str2;
    }
	
}
?>