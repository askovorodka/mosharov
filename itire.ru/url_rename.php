<?php 

$link = mysql_connect('localhost', 'itire', 'gthtgenmt');

if (!$link)
{
	die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db('itire', $link);

if (!$db_selected)
{
	die ('Can\'t use foo : ' . mysql_error());
}
mysql_set_charset('cp1251');

$res = mysql_query("select * from fw_catalogue where status='1' and param_level > 0");

while ($data = mysql_fetch_assoc($res))
{
	if (!empty($data['url']))
	{

		$url = $data['url'];
		$url = str_replace(".","", $url);
		$url = str_replace("+","", $url);
		mysql_query("update fw_catalogue set url='{$url}' where id='{$data['id']}'");

	}
}

?>