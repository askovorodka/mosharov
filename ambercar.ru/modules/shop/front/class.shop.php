<?php

//вспомогательный класс
class Shop extends db {

	var $db;
	function Shop($db)
	{
		$this->db = &$db;
	}
	
	function get_product_type($type_id)
	{
		$result = $this->db->get_single("select * from fw_products_types where id = '$type_id'");
		
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
		
	}
	
	function get_products_by_category_and_type($parent_id, $type_id)
	{
		
		$result = $this->db->get_all(sprintf("select fw_products.* 
		from fw_products 
		where fw_products.parent='%d' and fw_products.product_type='%d' and fw_products.status='1'", intval($parent_id), intval($type_id)));
		
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
		
	}
	
	function get_brands_by_category($cat_id)
	{
		$query = "select brands.* from brands
		inner join fw_products on brands.id=fw_products.brand_id
		where fw_products.parent = '". intval($cat_id) ."' group by fw_products.brand_id order by brands.name";
		
		$result = $this->db->get_all($query);
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
	}
	
	
	function get_brands()
	{
		$query = "select brands.id,brands.name from brands
		left join fw_products on brands.id=fw_products.brand_id
		where fw_products.status = '1' group by fw_products.brand_id order by brands.name";
		$result = $this->db->get_all($query);
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
		
	}
	
	function get_category_by_url($url)
	{
		$result = $this->db->get_single("select * from fw_catalogue where url='{$url}' and status='1' limit 1");
		
		if (!empty($result))
			return $result;
		else
			return null;
	}
	
	function delete_products_by_category($category_id)
	{
		$products = $this->db->get_all("select id from fw_products where parent='{$category_id}'");
		
		foreach ($products as $product)
		{
			$this->delete_image_by_product($product['id']);
		}
		$this->db->query("delete from fw_products where parent='{$category_id}'");
	}
	
	function delete_image_by_product($product_id)
	{
		//удаляем запись в БД
		$this->db->query("delete from product_images where product_id='{$product_id}'");
		system("rm -rf " . ROOT . '/uploaded_files/product_images/' . $product_id);
		system("rm -rf " . ROOT . '/resized/img105x105/uploaded_files/product_images/'.$product_id);
		system("rm -rf " . ROOT . '/resized/img100x100/uploaded_files/product_images/'.$product_id);
		system("rm -rf " . ROOT . '/resized/img315x228/uploaded_files/product_images/'.$product_id);
		system("rm -rf " . ROOT . '/resized/img71x74/uploaded_files/product_images/'.$product_id);
		system("rm -rf " . ROOT . '/resized/img80x80/uploaded_files/product_images/'.$product_id);
	}
	
	function getTopProducts($limit = 1)
	{
		$result = $this->db->get_all("select * from fw_products where status='1' and hit='1'");
		
		if ($result && count($result) > 0)
		{
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

	function search_product($text)
	{
		$result = $this->db->get_all("select fw_products.*, model.name as model_name, mark.name as mark_name
		from fw_products
		left join fw_catalogue as model on fw_products.parent = model.id 
		left join fw_catalogue as mark on model.param_left > mark.param_left and model.param_right < mark.param_right and mark.param_level = 1
		where (fw_products.name like '%{$text}%' or model.name like '%{$text}%' or mark.name like '%{$text}%')
		and fw_products.status = '1'  ");
		
		if (!empty($result))
			return $result;
			
		return null;
		
	}
	
	function search($where, $pager, $sort_field = "date", $sort_order = "desc")
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
		
		
		$result = $this->db->get_all("select a.*, b.image 
		from fw_products as a
		left join fw_catalogue as b on a.parent = b.id 
		where a.status = '1' " . 
		$where . " {$sort_field} {$sort_order} ");
		
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
		
		return ($module_name) ? $module_name . "/" .$url : $url;
		
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
					and '{$categor['param_right']}' and status = '1' " . $where." order by name ");
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
		$result = $this->db->get_all("select * from fw_catalogue where status='1' and param_level = '{$param_level}' order by param_left");
		
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
				SELECT p.*,
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
	
	
	function get_products_types_by_category($cat_id)
	{
		$result = $this->db->get_all(sprintf("select fw_products_types.* 
		from fw_products 
		inner join fw_products_types on fw_products.product_type = fw_products_types.id
		where fw_products.parent='%d' and fw_products.status='1' group by fw_products_types.id 
		order by fw_products_types.name asc", intval($cat_id)));
		
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
		
		$result = $this->db->get_all("select concat(id,'.',ext) as image from fw_products_images where parent='{$product_id}' order by sort_order asc ");
		
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
		
		//$result = $this->db->get_single("select image from product_images where product_id = '{$product_id}' limit 1 ");
		$result = $this->db->get_single("select concat(id,'.',ext) as image 
		from fw_products_images 
		where parent = '{$product_id}' order by sort_order asc limit 1 ");
		
		if ($result)
		{
			return $result['image'];
		}
		else
		{
			return null;
		}
		
	}
	
	
}
?>