<?php 
//echo dirname(__FILE__);
require_once 'lib/class.import.php';

$import = new Import();

$xlsfile = "testdisk.xls";
$csvfile = "testdisk.csv";
$import->convert($xlsfile, $csvfile);
$data = $import->read($csvfile);

foreach ($data as $value)
{
	foreach ($value as $key => $val)
	{
		echo $value[$key] . " | ";
	}
	echo "<br>";
}

?>