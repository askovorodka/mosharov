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
    	<div class="toplogo"><a href="http://ambercar.ru/" title="�� �������"><img src="http://ambercar.ru/templates/img/logo.jpg" /></a></div>
    	<div class="search"><form action="{$base_url}/catalog/"><input type="text" name="search_product" value="{$search}" /><br />��� - <u>������ �������� Subaru Outback</u></form></div>
    	<div class="tel"><strong>� 9:00 �� 20:00</strong><div class="phonenumber">+7 (495) 772-13-98</div>������, ��. ����� ������ ������, �. 15<br /><img src="http://ambercar.ru/templates/img/skype.png" align="absmiddle"> <b>ambercar1</b></div>
    </td>
  </tr>
  <tr>
    <td class="topmenu">
    	{include file="`$smarty.const.ROOT`templates/top_menu.tpl"}
    </td>
  </tr>