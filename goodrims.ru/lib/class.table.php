<?php

class Table{

	function pregReplace($content,$base_path){
			
			if (preg_match_all('/{table\sid="\d{1,2}"}/',$content,$matches))
				if (is_array($matches))
					foreach ($matches as $key=>$val)
						foreach ($matches[$key] as $key2=>$val2)
							if (preg_match("/\d{1,2}/", $matches[$key][$key2], $submathes)){
								$table_id = intval($submathes[0]);
								$out_table = $this->show_table(array("id"=>$table_id),$base_path);
								if (strlen(trim($out_table))>0)
									$content = str_replace($matches[$key][$key2],$out_table,$content);
							}
			
			return $content;
	}
	
	
	function show_table ($params,$base_path) {

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
			
			require_once $base_path.'/lib/class.excelexplorer.php';
			
			$ee = new ExcelExplorer;
			
			$table_file=fopen($base_path.'/modules/tables/files/'.$table['id'].'.'.$table['format'],'r');
			$file = fread($table_file,filesize($base_path.'/modules/tables/files/'.$table['id'].'.'.$table['format']));
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

		$output=$smarty->fetch($base_path.'/modules/tables/templates/'.$table_template);
		
		return $output;
		
	}
}
?>