<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{$page_title}</title>
<meta name="Keywords" content="{$meta_keywords}">
<meta name="Description" content="{$meta_description}">
{foreach from=$css item=css}
<link rel="stylesheet" type="text/css" href="{$css}">
{/foreach}
{foreach from=$js item=js}
<script src="{$js}" type="text/javascript"></script>
{/foreach}
</head>
<body>
<table class="maintable">
  <tr>
    <td class="toper">
    	<div class="search"><form action="{$base_url}/catalog/"><input type="text" name="search_product" value="{$search}" /><br />Ищу - <u>VIN</u>, <u>Frame</u>, <u>Наименование</u></form></div>
    	<div class="tel"><strong>С 9:00 до 20:00</strong><div class="phonenumber">+7 (926) 612-17-19</div>Москва, ул. Аллея Первой Маевки, д. 15</div>
    </td>
  </tr>
  <tr>
    <td class="topmenu">
    	{include file="`$smarty.const.ROOT`templates/top_menu.tpl"}
    </td>
  </tr>
