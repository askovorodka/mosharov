<?php

  define("DB_HOST","localhost");
  define("DB_NAME","cccp");
  define("DB_USER","cccp");
  define("DB_PASS","gthtgenmt");

  define("TIRES_ID",2);
  define("DISK_ID",3);
  define("ROOT", dirname(__FILE__) . "/../");
  define("DOMAIN", 'http://'.$_SERVER['SERVER_NAME'].'/');
  define("SHOP_IMAGE", DOMAIN . 'uploaded_files/shop_images/');
  define("SHOP_IMAGE_PATH", ROOT . 'uploaded_files/shop_images/');
  define("COMPANY_ORDERS", serialize(
  	array(3 => "ГРУЗОВОЗОФФ",4 => "Деловые линии", 5 => "ПЭК")
  ));

?>