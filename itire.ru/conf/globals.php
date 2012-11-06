<?php

  define("DB_HOST","localhost");
  define("DB_NAME","itire");
  define("DB_USER","itire");
  define("DB_PASS","gthtgenmt");

  define("TIRES_ID",2);
  define("DISK_ID",3);
  define("ROOT", dirname(__FILE__) . "/../");
  define("DOMAIN", 'http://'.$_SERVER['SERVER_NAME'].'/');
  define("SHOP_IMAGE", DOMAIN . 'uploaded_files/shop_images/');
  define("SHOP_IMAGE_PATH", ROOT . 'uploaded_files/shop_images/');
  define("COMPANY_ORDERS", serialize(
  		array(1=>"ЖелдорАльянс",2=>"Деловые линии",3=>"ПЭК")
  ));
  
?>