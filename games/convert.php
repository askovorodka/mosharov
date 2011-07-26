<?php 
//пробка
exit();

require_once 'conf/globals.php';
require_once 'lib/class.db.php';
require_once 'modules/shop/front/class.shop.php';
require_once 'lib/class.session.php';
$_SESSION['db_connections'] = 0;

error_reporting(E_ALL);
ini_set('display_errors','On');

$db = new db(DB_NAME, DB_HOST, DB_USER, DB_PASS);
$shop = new Shop($db);

$dir = opendir(ROOT . 'cat');

$file = "";
while (($file = readdir($dir)) !== false)
{
	if ($file != '.' && $file != '..')
	{
		$cat1 = $db->get_single("select id from fw_catalogue where name='". iconv("utf-8", "windows-1251", $file) ."'");
		if (isset($cat1['id']))
		{
			if (is_dir(ROOT . 'cat/' . $file))
			{
				$dir2 = opendir(ROOT . 'cat/' . $file);
				while (($file2 = readdir($dir2)) !== false)
				{
					if ($file != '.' && $file != '..')
					{
						$cat2 = $db->get_single("select id from fw_catalogue where name='". iconv("utf-8", "windows-1251", $file2) ."'");
						//если 2й уровень есть
						if (isset($cat2['id']))
						{
							if (is_dir(ROOT . 'cat/' . $file . '/' . $file2))
							{
								$dir3 = opendir(ROOT . 'cat/' . $file . '/' . $file2);
								while (($file3 = readdir($dir3)) !== false)
								{
									//находим продукт
									$product = $db->get_single("select id from fw_products where name='". iconv("utf-8", "windows-1251", $file3) ."'");
									//echo $product['id'] . ',';
									if (is_dir(ROOT . 'cat/' . $file . '/' . $file2 . '/'.$file3))
									{
										$dir4 = opendir(ROOT . 'cat/' . $file . '/' . $file2 . '/' . $file3);
										while (($file4 = readdir($dir4)) !== false)
										{
											//если пдф
											if (strstr($file4, '.pdf') || strstr($file4, '.doc') || strstr($file4, '.zip'))
											{
												if (!is_dir(ROOT . 'uploaded_files/shop_files/' . $product['id']))
												{
													@mkdir(ROOT . 'uploaded_files/shop_files/' . $product['id'] . '/');
													@chmod(ROOT . 'uploaded_files/shop_files/' . $product['id'] . '/', 0777);
												}
												@copy(ROOT . 'cat/' . $file . '/' . $file2 . '/' . $file3 . '/' . $file4, ROOT . 'uploaded_files/shop_files/' . $product['id'] . '/' . $file4);
												@chmod(ROOT . 'uploaded_files/shop_files/' . $product['id'] . '/' . $file4, 0777);
												
												$check_file_name = explode(".",$file4);
												$ext = $check_file_name[count($check_file_name)-1];
												$filename = $check_file_name[0];
												
												$db->query("insert into fw_products_files2 (parent, file, title) VALUES('{$product['id']}', '{$file4}', '{$filename}') ");
												
											}
											
										}
									}
									
								}
							}
						}
						//значит продукт
						else
						{
							
							
							$product = $db->get_single("select id from fw_products where name='". iconv("utf-8", "windows-1251", $file2) ."'");
							//echo $product['id'] . ',';
							if (isset($product['id']))
							{
								$dir3 = opendir(ROOT . 'cat/' . $file . '/' . $file2);
								while (($file3 = readdir($dir3)) !== false)
								{
									//если пдф
									if (strstr($file3, '.pdf') || strstr($file3, '.doc') || strstr($file3, '.zip'))
									{
										if (!is_dir(ROOT . 'uploaded_files/shop_files/' . $product['id']))
										{
											@mkdir(ROOT . 'uploaded_files/shop_files/' . $product['id'] . '/');
											@chmod(ROOT . 'uploaded_files/shop_files/' . $product['id'] . '/', 0777);
										}
										@copy(ROOT . 'cat/' . $file . '/' . $file2 . '/' . $file3, ROOT . 'uploaded_files/shop_files/' . $product['id'] . '/' . $file3);
										@chmod(ROOT . 'uploaded_files/shop_files/' . $product['id'] . '/' . $file3, 0777);
										
										$check_file_name = explode(".",$file3);
										$ext = $check_file_name[count($check_file_name)-1];
										$filename = $check_file_name[0];
										
										$db->query("insert into fw_products_files2 (parent, file, title) VALUES('{$product['id']}', '{$file3}', '{$filename}') ");
											
									}
									
								}
							}
							
							
						}
						
					}
				}
			}
		}
	}
}


?>