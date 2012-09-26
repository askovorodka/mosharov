<?php
//вспомогательный класс
class Shop extends db {

	var $db;
	function Shop($db)
	{
		$this->db = &$db;
	}

	function update_tire($id,$price,$tire_sklad)
	{
		$this->db->query("update fw_products set price='{$price}', tire_sklad = tire_sklad + '{$tire_sklad}', status='1' where id='{$id}' ");
	}
	
	
	function insert_tire($model_id, $name, $tire_width, $tire_height, $tire_diameter, $tire_in, $tire_is, $tire_usil, $tire_spike, $price, $tire_sklad)
	{
		$this->db->query("insert fw_products (parent,name,tire_width,tire_height,tire_diameter,tire_in,tire_is,tire_usil,
		tire_spike,price, tire_sklad,status) values ('{$model_id}', '{$name}', '{$tire_width}', '{$tire_height}',
		'{$tire_diameter}', '{$tire_in}', '{$tire_is}', '{$tire_usil}', '{$tire_spike}', '{$price}',
		'{$tire_sklad}','1')");
		return mysql_insert_id();
	}
	
	
	function update_disk($id,$price,$disk_sklad)
	{
		$this->db->query("update fw_products set price='{$price}', disk_sklad = disk_sklad + '{$disk_sklad}', status='1' where id='{$id}' ");
	}
	
	function insert_disk($parent,$name,$width,$diameterm,$krep,$pcd,$pcd2,$et,$dia,$color,$price,$sklad)
	{
		$this->db->query("insert fw_products (parent,name,disk_width,disk_diameter,disk_krep,
		disk_pcd,disk_pcd2,disk_et,disk_dia,disk_color,price,disk_sklad,status)
		values ('$parent','$name','$width','$diameterm','$krep','$pcd','$pcd2','$et','$dia','$color','$price','$sklad','1')");
		return mysql_insert_id();
	}
	
	
	function search_product($name, $parent)
	{
		$result = $this->db->get_single("select * from fw_products where name='{$name}' and parent='{$parent}'");
		
		if ($result)
			return $result;
		else
			return null;
	}
	
	
	function getProductsByFeed($cat_id)
	{
		$result = $this->db->get_single("
			SELECT count(*) as count FROM 
			fw_products AS p 
			WHERE p.status='1' and (p.tire_sklad > 3 or p.disk_sklad > 3) and p.parent='{$cat_id}'");
		
		return $result['count'];
	}
	
	function getTopProducts($limit = 1)
	{
		$result = $this->db->get_all("select * from fw_products where status='1' and hit='1'");
		
		if ($result && count($result) > 0)
		{
			$rnd = rand(0, count($result)-1);
			$result[$rnd]['full_url'] = $this->getFullUrlProduct($result[$rnd]['id']);
			return $result[$rnd];
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
	 * ѕолный путь до продукта
	 *
	 * @param unknown_type $id
	 */
	function getFullUrlProduct($id)
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
			for ($i = $category['param_level']; $i > 0; $i--)
			{
				$category = self::getParent($category, $category['param_level']-1 );
				$url = $category['url'] . '/' . $url;
			}
		}
		return $url . '/';
	}
	
	function getFullUrlCategory($id)
	{
		$category = self::getCategory($id);
		$url = "";
		if ($category)
		{
			$url = $category['url'];
			for ($i = $category['param_level']; $i > 0; $i--)
			{
				$category = self::getParent($category, $category['param_level']-1 );
				$url = $category['url'] . '/' . $url;
			}
		}
		return $url . '/';
		
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
					SELECT 
					min(disk_diameter) as min_diameter, 
					max(disk_diameter) as max_diameter,
					min(tire_diameter) as min_tire_diameter, 
					max(tire_diameter) as max_tire_diameter,
					
					min(disk_width) as min_width,
					max(disk_width) as max_width,
					min(tire_width) as min_tire_width,
					max(tire_width) as max_tire_width,
					
					avg(disk_krep) as avg_krep,
					avg(disk_pcd) as avg_pcd,
					min(price) as price
					from fw_products where status = '1'  " . $where);
				
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
					max(tire_width) as max_width
					from fw_products where status = '1' " . $where);

		
		
		$price = $this->db->get_single("
					SELECT min(price) as price
					from fw_products where status = '1'  " . $where);
		
		$result['price'] = $price['price'];
		
		
		
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
					max(disk_width) as max_width
					
					from fw_products where status = '1' " . $where);
		
		$price = $this->db->get_single("
					SELECT min(price) as price
					from fw_products where status = '1' and disk_sklad > 0 " . $where);
		$result['price'] = $price['price'];
		
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
	
	
	function getProductInfo($id, $status=1)
	{
		$result = $this->db->get_single("
			SELECT a.*
			FROM fw_products as a 
			WHERE a.id = '{$id}' and status='{$status}'");
		
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
	
	
	/*function getTires()
	{
		$result = $this->db->get_all("select id from fw_products where tire_width")
	}*/
	
}
?>