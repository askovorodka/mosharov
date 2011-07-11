<?php

require_once 'conf/globals.php';
require_once 'lib/class.db.php';
require_once 'lib/class.xml.php';

$xml = new Xml(DB_NAME, DB_HOST, DB_USER, DB_PASS);

//находим все категории
$xml->getCategory();
$category = $xml->getResultQuery();

$xml->getProducts();
$products = $xml->getResultQuery();

$dom = $xml->createXmlFile();

$element = $dom->document_element();

?>