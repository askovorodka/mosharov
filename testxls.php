<?php

//error_reporting(E_ALL);
//ini_set('display_errors','On');

/*set_include_path(get_include_path() . PATH_SEPARATOR .'PHPExcel/Classes/');
//подключаем и создаем класс PHPExcel
include_once 'PHPExcel.php';
$pExcel = new PHPExcel();
$pExcel->setActiveSheetIndex(0);
$aSheet = $pExcel->getActiveSheet();
$aSheet->setTitle('Первый лист');
//устанавливаем данные
//номера по порядку
$aSheet->setCellValue('A1','№');
$aSheet->setCellValue('A2','1');
$aSheet->setCellValue('A3','2');
$aSheet->setCellValue('A4','3');
$aSheet->setCellValue('A5','4');
//названия сайтов
$aSheet->setCellValue('B1','Названия');
$aSheet->setCellValue('B2','http://www.web-junior.net');
$aSheet->setCellValue('B3','http://www.google.com');
$aSheet->setCellValue('B4','http://www.yandex.ru');
$aSheet->setCellValue('B5','http://www.twitter.com');
//мой личный рейтинг
$aSheet->setCellValue('C1','Рейтинг');
$aSheet->setCellValue('C2','100');
$aSheet->setCellValue('C3','99');
$aSheet->setCellValue('C4','90');
$aSheet->setCellValue('C5','85');
//устанавливаем ширину
$aSheet->getColumnDimension('B')->setWidth(25);
//отдаем пользователю в браузер
include("PHPExcel/Writer/Excel5.php");
$objWriter = new PHPExcel_Writer_Excel5($pExcel);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="rate.xls"');
header('Cache-Control: max-age=0');
$objWriter->save('php://output');*/


		set_include_path(get_include_path() . PATH_SEPARATOR .'PHPExcel/Classes/');
		include_once 'PHPExcel/IOFactory.php';
		
		$objPHPExcel = PHPExcel_IOFactory::load("factura.xls");
		$objPHPExcel->setActiveSheetIndex(0);
		$aSheet = $objPHPExcel->getActiveSheet();		
		$aSheet->setCellValue('C6',"привет");
		
		include("PHPExcel/Writer/Excel5.php");
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="print.xls"');
		header('Cache-Control: max-age=0');
		//выводим в браузер таблицу с бланком
		$objWriter->save('php://output');

?>