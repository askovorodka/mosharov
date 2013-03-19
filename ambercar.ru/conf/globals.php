<?php

  define("DB_HOST","localhost");
  define("DB_NAME","amber");
  define("DB_USER","amber");
  define("DB_PASS","gfhjkm12");

  define("ROOT", dirname(__FILE__) . "/../");
  define("DOMAIN", 'http://'.$_SERVER['SERVER_NAME'].'/');
  
  define("SHOP_IMAGE", DOMAIN . 'uploaded_files/product_images/');
  
  define("SHOP_DOSTAVKA_PRICE", 300);
  
  define("TPL_PATH", ROOT . "templates/");
  define("TPL_SHOP_PATH", ROOT . "modules/shop/front/templates/");
  define("TPL_PAGE_PATH", ROOT . "modules/page/front/templates/");
  
?>