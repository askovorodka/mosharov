<?php

if (($switch_default=='on' or $switch_support=='on') && $main_module!='on') {
	
	$smarty->register_function("table", "show_table");

	function show_table ($params) {

		global $db;
		global $smarty;
		
		$table_id=$params['id'];
		
		if (!isset($params['template'])) $table_template='main.html';
		else $table_template=$params['template'];
		
		$table=$db->get_single("SELECT * FROM fw_tables WHERE id='$table_id'");
		
		if ($table['format']=='csv') {
			
			$table_file=file(BASE_PATH.'/modules/tables/files/'.$table['id'].'.'.$table['format']);
			
			foreach ($table_file as $k=>$v) {
				$gen_table[]=explode(';',$v);			
			}
		}
		
		if ($table['format']=='xls') {
			
			require_once BASE_PATH.'/lib/class.excelexplorer.php';
			
			$ee = new ExcelExplorer;
			
			$table_file=fopen(BASE_PATH.'/modules/tables/files/'.$table['id'].'.'.$table['format'],'r');
			$file = fread($table_file,filesize(BASE_PATH.'/modules/tables/files/'.$table['id'].'.'.$table['format']));
			fclose($table_file);

			$ee->Explore($file);

			$p=0;
			$sheet=0;
			//for( $sheet=0; $sheet<$ee->GetWorksheetsNum(); $sheet++ ) {

			if( !$ee->IsEmptyWorksheet($sheet) ) {

				for($row=0; $row<=$ee->GetLastRowIndex($sheet); $row++) {

					if( !$ee->IsEmptyRow($sheet,$row) ) {
						$da=array();
						for($col=0; $col<=$ee->GetLastColumnIndex($sheet); $col++) {

							if( !$ee->IsEmptyColumn($sheet,$col) ) {

								$data = $ee->GetCellData($sheet,$col,$row);
												
								$data = $ee->AsHTML($data);
								$data=String::Unicode2Charset($data);
												
								//if ($col==0) {
								//	$parent=0;
								//}
								//$da[$row][$col]=$data;
								$da[]=$data;
								//$gen_table[$col][$row]=$data;
							}
				
						}
						$gen_table[]=$da;
					}
				}
			}
			//}
			
		}
		
		$smarty->assign("gen_table",$gen_table);

		$output=$smarty->fetch(BASE_PATH.'/modules/tables/templates/'.$table_template);
		
		return $output;
		
	}
	
}
else {

}

?>