<?php
class Xml extends db
{
	
	var $result_query = array();
	var $dom = null;
	
	function __construct($db, $host, $user, $pass)
	{
		parent::db($db, $host, $user, $pass);
	}
	
	
	function getCategory()
	{
		$this->result_query = $this->get_all("select * from fw_catalogue where status = '1' order by param_left");
	}

	
	function getProducts()
	{
		$this->result_query = $this->get_all("select * from fw_products where status = '1' and (tire_sklad > 4 or disk_sklad > 4) ");
	}
	
	function getResultQuery()
	{
		return $this->result_query;
	}
	
	
	function createXmlFile()
	{
		//$this->dom = domxml_open_file($_SERVER['DOCUMENT_ROOT'] . "yandex.xml");
		$this->dom = domxml_open_mem('<?xml version="1.0" encoding="Windows-1251"?><!DOCTYPE yml_catalog SYSTEM "shops.dtd">');
		return $this->dom;
	}
	
}