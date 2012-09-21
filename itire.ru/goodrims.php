<?php 

$path = dirname(__FILE__) . "/";

$link = mysql_connect("localhost", "itire", "gthtgenmt", true);

if (!$link)
	die("Error connect to db");

mysql_select_db("demo", $link);

mysql_set_charset("cp1251", $link);

$res = mysql_query("select * from suppliers", $link);

$suppliers = array();
while ($row = mysql_fetch_assoc($res))
{
	$suppliers['goodrims'][$row['name']] = $row['goodrims'];
	$suppliers['selltire'][$row['name']] = $row['selltire'];
	$suppliers['cccpshina'][$row['name']] = $row['cccpshina'];
}


$suppliers['goodrims']['itire.ru'] = 1;
$suppliers['selltire']['itire.ru'] = 1;
$suppliers['cccpshina']['itire.ru'] = 1;

$res = mysql_query("select * from exported_products", $link);

@unlink($path . "xml/goodrims.xml");

$dom = new domDocument("1.0", "utf-8");

$root = $dom->createElement("export");
$root->setAttribute("date", date("d.m.Y H:i"));
$dom->appendChild($root);
$tires = $dom->createElement("tires");
$rims = $dom->createElement("rims");

$goodrims_disk_koef = get_koef('GOODRIMS_DISK_KOEF');
$goodrims_tire_koef = get_koef('GOODRIMS_TIRE_KOEF');
$goodrims_tire_round_koef = get_koef('GOODRIMS_TIRE_ROUND_KOEF'); 
$goodrims_disk_round_koef = get_koef('GOODRIMS_DISK_ROUND_KOEF');

while ($item = mysql_fetch_assoc($res))
{
	//goodrims
	if ($item['type'] == 'disk' && $suppliers['goodrims'][$item['dealer']] == 1)
	{
		$rim = $dom->createElement("rim");
		$rim->setAttribute("id", $item['id']);
		$brand = $dom->createElement("brand", iconv("windows-1251", "utf-8", $item['brand']));
		$model = $dom->createElement("model", iconv("windows-1251","utf-8",$item['model']));
		$dealer = $dom->createElement("dealer", iconv("windows-1251","utf-8",$item['dealer']));
		$name = $dom->createElement("name", iconv("windows-1251","utf-8",$item['name']));
		$article = $dom->createElement("article", iconv("windows-1251","utf-8",$item['article']));
		$disk_width = $dom->createElement("disk_width", iconv("windows-1251","utf-8",$item['disk_width']));
		$disk_diameter = $dom->createElement("disk_diameter", iconv("windows-1251","utf-8",$item['disk_diameter']));
		$disk_krep = $dom->createElement("disk_krep", iconv("windows-1251","utf-8",$item['disk_krep']));
		$disk_pcd = $dom->createElement("disk_pcd", iconv("windows-1251","utf-8",$item['disk_pcd']));
		$disk_pcd2 = $dom->createElement("disk_pcd2", iconv("windows-1251","utf-8",$item['disk_pcd2']));
		$disk_et = $dom->createElement("disk_et", iconv("windows-1251","utf-8",$item['disk_et']));
		$disk_dia = $dom->createElement("disk_dia", iconv("windows-1251","utf-8",$item['disk_dia']));
		$disk_color = $dom->createElement("disk_color", iconv("windows-1251","utf-8",$item['disk_color']));
		$disk_type = $dom->createElement("disk_type", iconv("windows-1251","utf-8",$item['disk_type']));
		$sklad = $dom->createElement("sklad", $item['sklad']);
		
		$price = floatval($item['price'] + ( $item['price'] * ($goodrims_disk_koef / 100) ));
		while ($price % $goodrims_disk_round_koef != 0)
			$price++;
		$price = $dom->createElement("price", $price);
		
		$rim->appendChild($brand);
		$rim->appendChild($model);
		$rim->appendChild($dealer);
		$rim->appendChild($name);
		$rim->appendChild($price);
		$rim->appendChild($article);
		$rim->appendChild($disk_width);
		$rim->appendChild($disk_diameter);
		$rim->appendChild($disk_krep);
		$rim->appendChild($disk_pcd);
		$rim->appendChild($disk_pcd2);
		$rim->appendChild($disk_et);
		$rim->appendChild($disk_dia);
		$rim->appendChild($disk_color);
		$rim->appendChild($disk_type);
		$rim->appendChild($sklad);
		
		$rims->appendChild($rim);
	}
	
	if ($item['type'] == 'tire' && $suppliers['goodrims'][$item['dealer']] == 1)
	{
		$tire = $dom->createElement("tire");
		$tire->setAttribute("id", $item['id']);
		$brand = $dom->createElement("brand", iconv("windows-1251","utf-8",$item['brand']));
		$model = $dom->createElement("model", iconv("windows-1251","utf-8",$item['model']));
		$dealer = $dom->createElement("dealer", iconv("windows-1251","utf-8",$item['dealer']));
		$name = $dom->createElement("name", iconv("windows-1251","utf-8",$item['name']));
		$article = $dom->createElement("article", iconv("windows-1251","utf-8",$item['article']));
		$tire_width = $dom->createElement("tire_width", iconv("windows-1251","utf-8",$item['tire_width']));
		$tire_height = $dom->createElement("tire_height", iconv("windows-1251","utf-8",$item['tire_height']));
		$tire_diameter = $dom->createElement("tire_diameter", iconv("windows-1251","utf-8",$item['tire_diameter']));
		$tire_in = $dom->createElement("tire_in", iconv("windows-1251","utf-8",$item['tire_in']));
		$tire_is = $dom->createElement("tire_is", iconv("windows-1251","utf-8",$item['tire_is']));
		$tire_usil = $dom->createElement("tire_usil", iconv("windows-1251","utf-8",$item['tire_usil']));
		$tire_spike = $dom->createElement("tire_spike", iconv("windows-1251","utf-8",$item['tire_spike']));
		$tire_season = $dom->createElement("tire_season", iconv("windows-1251","utf-8",$item['tire_season']));
		$tire_bodytype = $dom->createElement("tire_bodytype", iconv("windows-1251","utf-8",$item['tire_bodytype']));
		$sklad = $dom->createElement("sklad", $item['sklad']);
		
		$price = floatval($item['price'] + ( $item['price'] * ($goodrims_tire_koef / 100) ));
		while ($price % $goodrims_tire_round_koef != 0)
			$price++;
		
		$price = $dom->createElement("price", $price);
		
		$tire->appendChild($brand);
		$tire->appendChild($model);
		$tire->appendChild($dealer);
		$tire->appendChild($name);
		$tire->appendChild($price);
		$tire->appendChild($article);
		$tire->appendChild($tire_width);
		$tire->appendChild($tire_height);
		$tire->appendChild($tire_diameter);
		$tire->appendChild($tire_in);
		$tire->appendChild($tire_is);
		$tire->appendChild($tire_usil);
		$tire->appendChild($tire_spike);
		$tire->appendChild($tire_season);
		$tire->appendChild($tire_bodytype);
		$tire->appendChild($sklad);
		
		$tires->appendChild($tire);
	}
	
}

$root->appendChild($rims);
$root->appendChild($tires);
$dom->save($path."xml/goodrims.xml");





//вспомогательная функция для доступа к настройкам и коефициентам
function get_koef($key)
{
	$rst = mysql_query("select conf_value from fw_conf where conf_key='{$key}'");
	$row = mysql_fetch_assoc($rst);
	return $row['conf_value'];
}

?>