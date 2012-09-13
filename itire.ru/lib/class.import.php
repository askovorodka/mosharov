<?php

set_time_limit(1000);

class Import
{

	var $xls_dir;
	var $csv_dir;
	var $data = array();
	var $db;
	var $tree;
	var $string;
	var $import_id = null;
	var $updated_category = 0;
	var $inserted_category = 0;
	var $updated_product = 0;
	var $inserted_product = 0;
	var $import_items = array();

	function Import(&$db, &$tree, &$string)
	{
		$this->xls_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploaded_files/xls/' . date("d-m-y") . '/';
		$this->csv_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploaded_files/csv/' . date("d-m-y") . '/';
		$this->db = $db;
		$this->tree = $tree;
		$this->string = $string;
	}

	function upload(&$file)
	{
		if ($file['name'])
		{
			if (!is_dir($this->xls_dir))
			{
				@mkdir($this->xls_dir);
				@chmod($this->xls_dir, 0777);
			}

			$filename = md5($file['name']) . '.xls';

			if (move_uploaded_file($file['tmp_name'], $this->xls_dir . $filename))
			{
				@chmod($this->xls_dir . $filename, 0777);
				return $filename;
			}
		}
		return null;
	}

	function convert($xlsfile, $csvfile)
	{
		if ($xlsfile)
		{
			if (file_exists($this->xls_dir . $xlsfile))
			{

				if (!is_dir($this->csv_dir))
				{
					@mkdir($this->csv_dir);
					@chmod($this->csv_dir, 0777);
				}
				$cmd = '/usr/local/bin/xls2csv -q 3 -c "¦" -s cp1251 -d cp1251 ' . $this->xls_dir . $xlsfile . ' > ' . $this->csv_dir . $csvfile;
				exec($cmd);

				if (file_exists($this->csv_dir . $csvfile))
				{
					@chmod($this->csv_dir . $csvfile, 0777);
					$this->_preprocess($this->csv_dir . $csvfile);
					$this->_preprocess_csv($this->csv_dir . $csvfile);
					return true;
				}

			}
		}
		return false;
	}
	
	
	function getImportTypeByFile($file)
	{
		if (file_exists($this->csv_dir . $file))
		{
			
			$f = fopen($this->csv_dir . $file, "r") or die("Ошибка!");
			for ($i=0; $data=fgetcsv($f,1000,"¦"); $i++)
			{
				
				if ($data[7] == 'PCD' && $data[9] == 'ET' && $_POST['type'] == 'disk')
				{
					return true;
				}
				elseif ($data[7] != 'PCD' && $data[9] != 'ET' && $_POST['type'] == 'tires')
				{
					return true;
				}
				else 
				{
					return false;
				}
				
				break;
			}
			fclose($f);			

		}
		
	}

	
	function read($csvfile)
	{

		
		if (file_exists($this->csv_dir . $csvfile))
		{
			$content = fopen($this->csv_dir . $csvfile, 'r');
			
			$f = fopen($this->csv_dir . $csvfile, "rt") or die("Ошибка!");
			for ($i=0; $data=fgetcsv($f,1000,"¦"); $i++)
			{
				if ($i > 0)
				{
					$this->data[$i - 1] = array();

					if (preg_match("/([0-9]+)/", $data[0]))
					{
						{
							$this->data[$i - 1] = $data;
						}
					}
					
				} 
				
			}
			fclose($f);			
			

		}
		return $this->data;
	}

	
	
	function importDisk($parent_id)
	{
		if (count($this->data))
		{
			$this->_addImportLog('disk');
			
			foreach ($this->data as $val)
			{
				echo ' ';
				flush();
				
				$parent = $this->getParent($parent_id);
				$brand_name = $val[1];
				
				if (trim($brand_name) == "") continue;
				
				$brand = $this->db->get_single("
					SELECT * FROM fw_catalogue 
					WHERE name = '{$brand_name}' and param_level = '2' and 
					param_left  between '{$parent['param_left']}' 
					and '{$parent['param_right']}' ");
				if (isset($brand) && isset($brand['id']))
				{
					$brand_id = $brand['id'];
					$url = $this->string->string_formater($this->string->translit(strtolower($brand_name)));
					$this->db->query("update fw_catalogue set url='$url' where id='{$brand_id}'");
				}
				else 
				{
					
					$this->tree->insert($parent['id'], array(
						'name' => $brand_name,
						'url' => $this->string->string_formater($this->string->translit(strtolower($brand_name))),
						'text' => '',
						'status' => '1',
						'title' => $brand_name,
						'meta_keywords' => $brand_name,
						'meta_description' => $brand_name
					));
					$brand_id = mysql_insert_id();
					$brand = $this->getParent($brand_id);
					$this->inserted_category++;
					$this->import_items[] = array(
						"type" => "category", 
						"name" => $brand_name, 
						"id" => $brand_id,
						"type_import" => "insert");
				}
				if ($brand_id)
				{
					$model = $this->db->get_single("SELECT * FROM fw_catalogue
					WHERE name = '{$val[2]}' and param_level = '3'
					and param_left between '{$brand['param_left']}' and '{$brand['param_right']}' ");
					if (isset($model) && isset($model['id']))
					{
						$model_id = $model['id'];
					}
					else
					{
						$this->tree->insert($brand['id'], array(
							'name' => $val[2],
							'url' => $this->string->string_formater($this->string->translit(strtolower($val[2]))),
							'text' => str_replace("{brand_name}", $brand['name'], str_replace("{model_name}", $val[2], CATEGORY_TEXT_TEMPLATE) ),
							'status' => '1',
							'title' => "{$brand['name']} {$val[2]}",
							'meta_keywords' => "{$brand['name']} {$val[2]}",
							'meta_description' => "{$brand['name']} {$val[2]}"
						));
						$model_id = mysql_insert_id();
						$this->inserted_category++;
						$this->import_items[] = array(
							"type" => "category", 
							"name" => $val[2], 
							"id" => $model_id,
							"type_import" => "insert");
						
					}
				}
				
				if (!empty($brand_id) && !empty($model_id))
				{
					$fields = array(
							'article' => $val[0],
							'brand_name' => $val[1],
							'model_name' => $val[2],
							'name' => $val[3],
							'disk_width' => str_replace(",",".",$val[4]),
							'disk_diameter' => $val[5],
							'disk_krep' => $val[6],
							'disk_pcd' => str_replace(",", ".",$val[7]),
							'disk_pcd2' => str_replace(",", ".",$val[8]),
							'disk_et' => str_replace(",", ".",$val[9]),
							'disk_dia' => str_replace(",", ".",$val[10]),
							'disk_color' => $val[11],
							'disk_type' => $val[12],
							'disk_sklad' => $val[13],
							'price' => $val[14],
							'dictionary' => $val[20]
					);
					
					$disk_type = $this->db->get_single("SELECT id FROM fw_disk_types where name = '{$fields['disk_type']}'");
					if (isset($disk_type['id']))
					{
						$disk_type_id = $disk_type['id'];
					}
					else 
					{
						$disk_type_id = null;
					}
					
					$hash = $this->getDiskHash($brand_id, $model_id, $disk_type_id, $fields);
					
					if ($product_id = $this->isProductExists($hash))
					{
						$product = $this->getProduct($product_id);
						if ($product['disk_sklad'] != $fields['disk_sklad'] || $product['price'] != $fields['price'] || $product['dictionary'] != $fields['dictionary'])
						{
							$this->updateDisk($product_id, $fields);
							$this->updated_product++;
							$this->import_items[] = array(
								"type" => "product", 
								"name" => $product['name'], 
								"id" => $product['id'],
								"type_import" => "update");
							$this->db->query("replace into products_sklad (product_id, sklad) values('{$product['id']}','{$fields['disk_sklad']}')");
							
						}
					}
					else 
					{
						$id = $this->insertDisk($brand_id, $model_id, $disk_type_id, $fields);
						$this->inserted_product++;
						$this->import_items[] = array(
							"type" => "product", 
							"name" => $val[2], 
							"id" => $id,
							"type_import" => "insert");
						$this->db->query("replace into products_sklad (product_id, sklad) values('{$id}','{$fields['disk_sklad']}')");
						
					}
					
				}
				
			}

		}
		
		$this->_updateImportLog();
		
	}
	
	
	
	
	
	function importTires($parent_id)
	{
		if (count($this->data))
		{
			$this->_addImportLog('tires');
			
			foreach ($this->data as $val)
			{
				echo ' ';
				flush();
				
				$parent = $this->getParent($parent_id);
				$brand_name = $val[1];
				
				if (trim($brand_name) == "") continue;
				
				$brand = $this->db->get_single("
					SELECT * FROM fw_catalogue 
					WHERE name = '{$brand_name}' and param_level = '2' and 
					param_left between '{$parent['param_left']}' 
					and '{$parent['param_right']}' ");
				
				if (isset($brand) && isset($brand['id']))
				{
					$brand_id = $brand['id'];
					$url = $this->string->string_formater($this->string->translit(strtolower($brand_name)));
					$this->db->query("update fw_catalogue set url='$url' where id='{$brand_id}'");
				}
				else
				{
					$this->tree->insert($parent['id'], array(
						'name' => $brand_name,
						'url' => $this->string->string_formater($this->string->translit(strtolower($brand_name))),
						'text' => '',
						'status' => '1',
						'title' => $brand_name,
						'meta_keywords' => $brand_name,
						'meta_description' => $brand_name
					));
					
					$brand_id = mysql_insert_id();
					$brand = $this->getParent($brand_id);
					$this->inserted_category++;
					$this->import_items[] = array(
						"type" => "category", 
						"name" => $brand_name, 
						"id" => $brand_id,
						"type_import" => "insert");
					
				}
				
				if ($brand_id)
				{
					
					$model = $this->db->get_single("SELECT * FROM fw_catalogue
					WHERE name = '{$val[2]}' and param_level = '3'
					and param_left between '{$brand['param_left']}' and '{$brand['param_right']}'");
					if (isset($model) && isset($model['id']))
					{
						$model_id = $model['id'];
					}
					else
					{
						$this->tree->insert($brand['id'], array(
							'name' => $val[2],
							'url' => $this->string->string_formater($this->string->translit(strtolower($val[2]))),
							'text' => str_replace("{brand_name}", $brand['name'], str_replace("{model_name}", $val[2], CATEGORY_TEXT_TEMPLATE) ),
							'status' => '1',
							'title' => "{$brand['name']} {$val[2]}",
							'meta_keywords' => "{$brand['name']} {$val[2]}",
							'meta_description' => "{$brand['name']} {$val[2]}"
						));
						$model_id = mysql_insert_id();
						$this->inserted_category++;
						$this->import_items[] = array(
							"type" => "category", 
							"name" => $val[2], 
							"id" => $model_id,
							"type_import" => "insert");
						
					}
				}
				
				if (!empty($brand_id) && !empty($model_id))
				{
					$fields = array(
						'article' => $val[0],
						'brand_name' => $val[1],
						'model_name' => $val[2],
						'name' => $val[3],
						'tire_width' => $val[4],
						'tire_height' => $val[5],
						'tire_diameter' => $val[6],
						'tire_in' => $val[7],
						'tire_is' => $val[8],
						'tire_usil' => $val[9],
						'tire_spike' => $val[10],
						'tire_season' => $val[11],
						'tire_bodytype' => $val[12],
						'tire_sklad' => $val[13],
						'price' => $val[14],
						'dictionary' => $val[20]
					);
					
					$body_type = $this->db->get_single("SELECT id FROM fw_body_types where name = '{$fields['tire_bodytype']}'");
					if (isset($body_type['id']))
					{
						$body_type_id = $body_type['id'];
					}
					else 
					{
						$body_type_id = null;
					}
					
					$hash = $this->getTireHash($brand_id, $model_id, $body_type_id, $fields);
					if ($product_id = $this->isProductExists($hash))
					{
						$product = $this->getProduct($product_id);
						if ($product['tire_sklad'] != $fields['tire_sklad'] || $product['price'] != $fields['price'] || $product['dictionary'] != $fields['dictionary'])
						{
							$this->updateTire($product_id, $fields);
							$this->updated_product++;
							$this->import_items[] = array(
								"type" => "product", 
								"name" => $product['name'], 
								"id" => $product['id'],
								"type_import" => "update");
							$this->db->query("replace into products_sklad (product_id, sklad) values('{$product['id']}','{$fields['tire_sklad']}')");
						
						}
					}
					else 
					{
						$id = $this->insertTire($brand_id, $model_id, $body_type_id, $fields);
						$this->inserted_product++;
						$this->import_items[] = array(
							"type" => "product", 
							"name" => $val[2], 
							"id" => $id,
							"type_import" => "insert");
						$this->db->query("replace into products_sklad (product_id, sklad) values('{$id}','{$fields['tire_sklad']}')");
						
					}
					
				}
				
			}
			
		}
		
		$this->_updateImportLog();
		
	}
	
	
	function getDiskHash($brand_id, $model_id, $disk_type_id, $fields)
	{
		
		$hashfield = array(
			$fields['article'],
			$brand_id,
			$model_id,
			$disk_type_id,
			$fields['name'],
			$fields['disk_width'],
			$fields['disk_diameter'],
			$fields['disk_pcd'],
			$fields['disk_pcd2'],
			$fields['disk_et'],
			$fields['disk_dia'],
			$fields['disk_color']
		);
		$hash = md5( implode(";", $hashfield) );
		return $hash;
		
	}

	
	function getTireHash($brand_id, $model_id, $body_type_id, $fields)
	{
		
		$hashfield = array(
			$fields['article'],
			$brand_id,
			$model_id,
			$body_type_id,
			$fields['name'],
			$fields['tire_width'],
			$fields['tire_height'],
			$fields['tire_diameter'],
			$fields['tire_in'],
			$fields['tire_is'],
			$fields['tire_usil'],
			$fields['tire_spike'],
			$fields['tire_season'],
			$fields['tire_bodytype']
		);
		$hash = md5( implode(";", $hashfield) );
		return $hash;
		
	}
	
	
	
	function isProductExists($hash)
	{
		$product = $this->db->get_single("select id from fw_products where hash='{$hash}'");
		if (isset($product['id']))
		{
			return $product['id'];
		}
		else 
		{
			return null;
		}
	}

	/**
	 * Обновление диска
	 *
	 * @param unknown_type $id
	 * @param unknown_type $fields
	 */
	function updateDisk($id, $fields)
	{
		$this->db->query("update fw_products set 
			article='{$fields['article']}', 
			price={$fields['price']}, 
			dictionary='{$fields['dictionary']}',
			disk_sklad='{$fields['disk_sklad']}',
			status='1'
			where id={$id} ");
	}

	/**
	 * Обновление шины
	 *
	 * @param unknown_type $id
	 * @param unknown_type $fields
	 */
	function updateTire($id, $fields)
	{
		$this->db->query("update fw_products 
		set article='{$fields['article']}', 
		price={$fields['price']}, 
		dictionary='{$fields['dictionary']}', 
		tire_sklad='{$fields['tire_sklad']}',
		status='1' 
		where id={$id} ");
	}

	/**
	 * Добавление диска
	 *
	 * @param unknown_type $brand_id
	 * @param unknown_type $model_id
	 * @param unknown_type $type_id
	 * @param unknown_type $fields
	 */
	function insertDisk($brand_id, $model_id, $type_id, $fields)
	{
		$hash = $this->getDiskHash($brand_id, $model_id, $type_id, $fields);
		$this->db->query("
		insert into fw_products (parent, article, name, title, price, insert_date, status,
		disk_width, disk_diameter, disk_krep, disk_pcd, disk_pcd2, disk_et, 
		disk_dia, disk_color, disk_type, disk_sklad, dictionary, hash)
		
		values ('{$model_id}', '{$fields['article']}', '{$fields['name']}', '{$fields['name']}', '{$fields['price']}',
		'".time()."', '1', '" . $fields['disk_width'] . "', 
		'{$fields['disk_diameter']}', '{$fields['disk_krep']}', '" . $fields['disk_pcd'] . "', 
		'" . $fields['disk_pcd2'] . "',
		'{$fields['disk_et']}', 
		'" . $fields['disk_dia'] . "', 
		'{$fields['disk_color']}', '{$type_id}', '{$fields['disk_sklad']}', '{$fields['dictionary']}', '{$hash}')
		
		");
		
		return mysql_insert_id();
		
	}


	function insertTire($brand_id, $model_id, $body_id, $fields)
	{
		//определяем сезон
		if ($fields['tire_season'] == '������')
		{
			$season = 1;
		}
		elseif ($fields['tire_season'] == '������')
		{
			$season = 2;
		}
		else 
		{
			$season = 3;
		}
			
		//определяем шип/нешип
		if ($fields['tire_spike'] == '���')
		{
			$spike = 2;
		}
		else 
		{
			$spike = 1;
		}
		
		$hash = $this->getTireHash($brand_id, $model_id, $body_id, $fields);
		$this->db->query("
		insert into fw_products (parent, article, name, title, price, insert_date, status,
		tire_width, tire_height, tire_diameter, tire_in, tire_is, tire_usil, tire_spike, 
		tire_season, tire_sklad, tire_bodytype, dictionary, hash)
		
		values ('{$model_id}', '{$fields['article']}', '{$fields['name']}', '{$fields['name']}', '{$fields['price']}',
		'".time()."', '1', '{$fields['tire_width']}', '{$fields['tire_height']}', '{$fields['tire_diameter']}', 
		'{$fields['tire_in']}', '{$fields['tire_is']}',
		'{$fields['tire_usil']}', '{$spike}', '{$season}', '{$fields['tire_sklad']}', '{$body_id}', '{$fields['dictionary']}', '{$hash}')
		
		");
		
		return mysql_insert_id();
		
	}
	
	function getParent($id)
	{
		$result = $this->db->get_single("SELECT * FROM fw_catalogue WHERE id = '$id'");
		return $result;
	}
	
	
	
	private function _preprocess($csv_filename)
	{
		$content = join(file($csv_filename));
		$new_content = '';

		$in_field = false;

		for ($i = 0; $i < strlen($content); $i++)
		{
			if ($content[$i] != '"' && !$in_field)
			{
				$new_content .= $content[$i];
				continue;
			}

			if ($content[$i] == '"')
			{
				$new_content .= $content[$i];
				$in_field = !$in_field;
				continue;
			}

			if ($in_field)
			{
				if ($content[$i] == "\n" || $content[$i] == "\r")
				{
					$new_content .= '<br>';
				}
				else
				{
					$new_content .= $content[$i];
				}
			}
		}

		$handle = fopen($csv_filename, 'w');
		fwrite($handle, $new_content);
		fclose($handle);
		
		// почистим сами память на всякий случай

		unset($new_content);
		unset($content);
	}


	private function _preprocess_csv($csv_filename)
	{
		$content = join(file($csv_filename));
		$content = str_replace(';', '¦', $content);

		$handle = fopen($csv_filename, 'w');
		fwrite($handle, $content);
		fclose($handle);
		
		unset($content);
	}
	
	function _addImportLog($type)
	{
		$this->db->query("insert into fw_import_log (date, type) values('". date("Y-m-d H:i:s") ."', '{$type}')");
		//echo "insert into fw_import_log (date, type) values('". date("Y-m-d H:i:s") ."', '{$type}')"; exit();
		$this->import_id = mysql_insert_id();
	}
	
	private function _updateImportLog()
	{
		$this->db->query("update fw_import_log 
		set updated_category = '{$this->updated_category}',
		inserted_category = '{$this->inserted_category}',
		updated_product = '{$this->updated_product}',
		inserted_product = '{$this->inserted_product}',
		import_details = '". serialize($this->import_items) ."'
		where id = '{$this->import_id}' ");
	}
	

	function getProduct($id)
	{
		$result = $this->db->get_single("SELECT * FROM fw_products WHERE id = '$id'");
		return $result;
	}

	
	function getImports()
	{
		$result = $this->db->get_all("select * from fw_import_log order by date desc");
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
	}
	
	function getImportById($id)
	{
		$result = $this->db->get_single("select * from fw_import_log where id = '{$id}'");
		if ($result)
		{
			return $result;
		}
		else 
		{
			return null;
		}
	}
	
}

?>
