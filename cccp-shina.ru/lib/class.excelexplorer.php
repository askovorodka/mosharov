<?php
//
// +---------------------------------------+
// | Excel Explorer Version 3.0            |
// | Professional Edition                  |
// +---------------------------------------+
//

/*
 * This class provides functions for retrieve data stored in the
 * Microsoft's Excel file.
 *
 */

class ExcelExplorer {

	var $known_date_formats = array(
		// custom date formats
		0x0 => 'd/m',
		0x1 => 'd/m/yy',
		0x2 => 'dd/mm/yy',
		0x3 => 'd\ mmm',
		0x4 => 'd\ mmm\ yy',
		0x5 => 'dd\ mmm\ yy',
		0x6 => 'mmm\ yy',
		0x7 => 'mmmm\ yy',
		0x8 => 'd\ mmmm\,\ yyyy',
		0x9 => 'dd/mm/yy\ h:mm\ AM/PM',
		0xa => 'dd/mm/yy\ h:mm',
		0xb => 'mmmm',
		0xc => 'mmmmm\-yy',
		0xd => 'mmmm\ d',
		0xe => 'd\ mmmm',
		0xf => 'd/mm/yyyy',
		0x10 => 'dd/mm/yyyy',
		0x11 => 'd/m/yyyy',
		0x12 => 'dd\-mmm\-yy',

		// build-in date formats written as custom
		0x010e => 'm/d/yyyy',
		0x010f => 'd\-mmm\-yy',
		0x0110 => 'd\-mmm',
		0x0111 => 'mmm\-yy',
		0x0112 => 'h:mm\ AM/PM',
		0x0113 => 'h:mm:ss\ AM/PM',
		0x0114 => 'h:mm',
		0x0115 => 'h:mm:ss',
		0x0116 => 'm/d/yyyy\ h:mm',
		0x012d => 'mm:ss',
		0x012e => '[h]:mm:ss',
		0x012f => 'mm:ss.0'
	 );

	var $border_styles = array(
		0x0 => 0, // none
		0x1 => 6, // thin
		0x2 => 11, // medium
		0x3 => 5, // dashed
		0x4 => 2, // dotted
		0x5 => 12, // thick
		0x6 => 13, // double
		0x7 => 1, //hair
		0x8 => 10, // medium dashed
		0x9 => 4, // thin dash-dotted
		0xa => 9, // medium dash-dotted
		0xb => 3, // thin dash-dot-dotted 
		0xc => 7, // medium dash-dot-dotted
		0xd => 8 // slanted medium dash-dotted
	 );

	var $last_block;
	var $last_small_block;
	var $fat;
	var $small_fat;
	var $directory;
	var $worksheet;
	var $date1904;
	var $book_offset;
	var $opt;

/*
 * Public interface
 *
 */

	function ExcelExplorer($memory_safe=false) {
		$this->memory_safe = (boolean)$memory_safe;
		$this->explore_from_file = false;
		$this->explore_mode = 0;
		$this->explore_sheet = false;
		$this->opt = array(
			'read_font' => true,
			'read_format' => true,
			'read_align' => true,
			'read_bgcolor' => true,
			'read_border' => true,
			'read_formula' => true,
			'read_link' => true
		);

		$this->file_cache = array();
		$this->file_cache_max_blocks = 256;
		$this->row_cache = array();
		$this->row_cache_max_records = 1024;
		$this->cell_cache = array();
		$this->cell_cache_max_records = 1024;
		$this->link_cache = array();
		$this->link_cache_max_records = 128;
	}

	function Close() {
		if( $this->explore_from_file &&
		    ($this->file_handle !== false) ) {
			@fclose($this->file_handle);
		}
		return true;
	}

	function ExploreWorksheet($sheet) {
		$pws = $this->explore_worksheet($sheet);
		if( is_array($pws) ) {
			$this->worksheet[$sheet]['last_col'] = $pws['last_col'];
			$this->worksheet[$sheet]['last_row'] = $pws['last_row'];
			$this->worksheet[$sheet]['data'] = $pws;
		} else
			return $pws;

		return 0;
	}

/*
 * Data convertion functions
 *
 */

	function IsUnicode($data) {
		return !(!is_string($data) || (ord($data[0])==0));
	}

	function AsIs($data) {
		if( is_string($data) ) {
			return substr($data,1);
		} else {
			return $data;
		}
	}

	function AsPlain($data) {
		if( is_string($data) ) {
			if( ord($data[0])==0 ) {
				return substr($data,1);
			} else {
				$s = '';
				for( $i=1; $i<strlen($data); $i+=2 )
					$s .= $data[$i];
				return $s;
			}
		} else {
			return $data;
		}
	}

	function AsHTML($data) {
		if( is_string($data) ) {
			if( ord($data[0])==0 ) {
				return substr($data,1);
			} else {
				$s = '';
				for( $c=1; $c<strlen($data); $c+=2 ) {
				 $l = ord($data[$c]);
				 $h = ord($data[$c+1]);
				 if( ($h>0) || ($l<32) ) {
			 		$s .= '&#'.(256*$h+$l).';';
				 } else {
					$s .= $data[$c];
				 }
				}
				return $s;
			}
		} else {
			return $data;
		}
	}

	function AsDate($data) {
		$d = $this->AsPlain($data);
		if( is_numeric($d) )
			return $this->as_date($d);
		return false;
	}

/*
 * Worksheets functions
 *
 */

	function GetWorksheetsNum() {
		if( isset($this->worksheet) && is_array($this->worksheet) )
			return count($this->worksheet);
		return 0;
	}

	function GetWorksheetType($n) {
		if( isset($this->worksheet[$n]['type']) )
			return $this->worksheet[$n]['type'];
		return 0;
	}

	function GetWorksheetTitle($n) {
		if( isset($this->worksheet[$n]['title']) )
			return $this->worksheet[$n]['title'];
		return chr(0);
	}

	function IsEmptyWorksheet($n) {
		return !( isset($this->worksheet[$n]['data']) &&
			  is_array($this->worksheet[$n]['data']) &&
			  ($this->worksheet[$n]['last_row'] >= 0) &&
			  ($this->worksheet[$n]['last_col'] >= 0) );
	}

	function IsHiddenWorksheet($n) {
		if( isset($this->worksheet[$n]['hidden']) )
			return $this->worksheet[$n]['hidden'];
		return false;
	}

/*
 * Columns functions
 *
 */

	function GetLastColumnIndex($n) {
		if( isset($this->worksheet[$n]['last_col']) &&
		    ($this->worksheet[$n]['last_col'] >= 0) )
			return $this->worksheet[$n]['last_col'];
		else
			return false;
	}

	function GetColumnLevel($n,$col) {
		if( isset($this->worksheet[$n]['data']['column_level'][$col]) )
		 return $this->worksheet[$n]['data']['column_level'][$col];
		return 0;
	}

	function IsEmptyColumn($n,$col) {
		if( isset($this->worksheet[$n]['last_row']) ) {
		 if( $this->memory_safe ) {
		  for($i=0; $i<=$this->worksheet[$n]['last_row']; $i++)
		    if( isset($this->worksheet[$n]['data']['lc'][$i]) &&
			(($this->worksheet[$n]['data']['lc'][$i] == $col) ||
			 (($this->worksheet[$n]['data']['lc'][$i] > $col) &&
			  ($this->GetCellType($n,$col,$i) != 0))) )
			return false;
		 } else {
		  for($i=0; $i<=$this->worksheet[$n]['last_row']; $i++)
			if( isset($this->worksheet[$n]['data']['cell_type'][$i][$col]) )
				return false;
		 }
		}
		return true;
	}

	function IsHiddenColumn($n,$col) {
		if( isset($this->worksheet[$n]['data']['column_hidden'][$col]) )
			return true;
		return false;
	}

	function GetColumnWidth($n,$col) {
		if( isset($this->worksheet[$n]['data']['column_width'][$col]) ) {
			return $this->worksheet[$n]['data']['column_width'][$col];
		} elseif ( isset($this->worksheet[$n]['data']['defcolwidth']) ) {
			return $this->worksheet[$n]['data']['defcolwidth'];
		}
		return false;
	}

/*
 * Rows functions
 *
 */

	function GetLastRowIndex($n) {
		if( isset($this->worksheet[$n]['last_row']) &&
		    ($this->worksheet[$n]['last_row'] >= 0) )
			return $this->worksheet[$n]['last_row'];
		else
			return false;
	}

	function GetRowLevel($n,$row) {
		if( $this->memory_safe ) {
		  $r = $this->read_row($n,$row);
		  if( $r === false )
			return false;

		  if( isset($r['row_level']) )
			return $r['row_level'];

		  return 0;
		}

		if( isset($this->worksheet[$n]['data']['row_level'][$row]) )
		 return $this->worksheet[$n]['data']['row_level'][$row];
		return 0;
	}

	function IsEmptyRow($n,$row) {
		if( $this->memory_safe ) {
			return !isset($this->worksheet[$n]['data']['lc'][$row]);
		} else {
			return (!isset($this->worksheet[$n]['data']['cell_type'][$row]) ||
				count($this->worksheet[$n]['data']['cell_type'][$row])==0);
		}
	}

	function IsHiddenRow($n,$row) {
		if( $this->memory_safe ) {
		  $r = $this->read_row($n,$row);
		  if( $r === false )
			return false;

		  if( isset($r['row_hidden']) )
			return true;

		  return false;
		}

		if( isset($this->worksheet[$n]['data']['row_hidden'][$row]) )
			return true;
		return false;
	}

	function GetRowHeight($n,$row) {
		if( $this->memory_safe ) {
		  $r = $this->read_row($n,$row);
		  if( $r === false )
			return false;

		  if( isset($r['row_height']) ) {
			return $r['row_height'];
		  } elseif ( isset($this->worksheet[$n]['data']['defrowheight']) ) {
			return $this->worksheet[$n]['data']['defrowheight'];
		  }

		  return false;
		}

		if( isset($this->worksheet[$n]['data']['row_height'][$row]) ) {
			return $this->worksheet[$n]['data']['row_height'][$row];
		} elseif ( isset($this->worksheet[$n]['data']['defrowheight']) ) {
			return $this->worksheet[$n]['data']['defrowheight'];
		}
		return false;
	}

/*
 * Cells functions
 *
 */

	function GetCellLink($n,$col,$row) {
		if( !$this->opt['read_link'] ) return false;
		if( $this->memory_safe ) {
		  return $this->read_hlink($n,$col,$row);
		} else {
		  if( !isset($this->worksheet[$n]['data']['cell_link'][$row][$col]) )
			return false;

		  $d = $this->worksheet[$n]['data']['cell_link'][$row][$col];
		}

		if( !is_numeric($d) || !isset($this->link[$d]) )
			return false;

		return $this->link[$d];
	}

	function GetCellType($n,$col,$row) {
		if( $this->memory_safe ) {
		  if( !isset($this->worksheet[$n]['data']['cell_type'][$row][$col]) ) {
			$cell = $this->read_cell($n,$col,$row);
			if( !isset($cell['cell_type']) )
				return 0;

			$t = $cell['cell_type'];
		  } else {
			$t = $this->worksheet[$n]['data']['cell_type'][$row][$col];
		  }
		} else {
		  if( !isset($this->worksheet[$n]['data']['cell_type'][$row][$col]) ) {
			return 0;
		  }

		  $t = $this->worksheet[$n]['data']['cell_type'][$row][$col];
		}

		if( $t == 0x83 ) return 3;
		if( ($t==1) && $this->opt['read_format'] ) {
			$opt = $this->opt;
			$this->opt = array(
				'read_font' => false,
				'read_format' => true,
				'read_align' => false,
				'read_bgcolor' => false,
				'read_border' => false
			);
			$style = $this->GetCellStyle($n,$col,$row);
			$this->opt = $opt;
			if( isset($style['format_index']) ) {
			  if( $this->is_percent_format($style['format_index']) )
				return 2;
			  if( $this->is_date_format($style['format_index']) )
				return 6;
			}
		}
		return $t;
	}

	function GetCellData($n,$col,$row) {
		$t = $this->GetCellType($n,$col,$row);
		if( ($t==0) || ($t==7) || ($t==8) )
			return null;

		if( $this->memory_safe ) {
		  $cell = $this->read_cell($n,$col,$row);
		  if( ($cell === false) || !isset($cell['cell_data']) )
			return null;

		  $d = $cell['cell_data'];
		} else {
		  $d = $this->worksheet[$n]['data']['cell_data'][$row][$col];
		}

		if( $t==3 ) {

		  if( $this->memory_safe ) {
		    $t = $cell['cell_type'];
		  } else {
		    $t = $this->worksheet[$n]['data']['cell_type'][$row][$col];
		  }

		  if( $t == 0x83 ) {
			return $d;
		  } else {
			$ind = $d;
			if( isset($ind) && is_numeric($ind) ) {
				if( $this->memory_safe ) {
					$s = $this->read_sst($ind);
					if( is_string($s) ) {
						return $s;
					} else {
						return chr(0);
					}
				} else {
					if( isset($this->sst[$ind]) )
						return $this->sst[$ind];
					return chr(0);
				}
			} else
				return chr(0);
		  }
		}

		if( ($t==6) && $this->opt['read_format'] ) {
			$opt = $this->opt;
			$this->opt = array(
				'read_font' => false,
				'read_format' => true,
				'read_align' => false,
				'read_bgcolor' => false,
				'read_border' => false
			);
			$style = $this->GetCellStyle($n,$col,$row);
			$this->opt = $opt;
			return $this->date_format($d,$style['format_index']);
		}

		return $d;
	}

	function GetCellFont($n,$col,$row) {
	 $font = false;
	 if( $this->opt['read_font'] &&
	      (($font_ind = $this->get_xf($n,$col,$row,'font')) !== false) ) {
		if( $font_ind > 3 ) $font_ind--;
		if( isset($this->font[$font_ind]) ) {
			$font = array();
			$font['font'] = $this->font[$font_ind];
			unset($font['font']['pal_ind']);
			$font['font_index'] = $font_ind;
			$pal_ind = $this->font[$font_ind]['pal_ind'];
			if( isset($this->palette[$pal_ind]) )
				$font['color'] = $this->palette[$pal_ind];
		}
	 }
	 return $font;
	}

	function GetCellFormat($n,$col,$row) {
	 $format = false;
	 if( $this->opt['read_format'] &&
	     (($format_ind = $this->get_xf($n,$col,$row,'format')) !== false) ) {
		if( isset($this->format[$format_ind]) ) {
			$format = array();
			$format['format'] = $this->format[$format_ind];
			$format['format_index'] = $format_ind;
		}
		if( (($format_ind >= 0) && ($format_ind <= 4)) ||
		    (($format_ind >= 9) && ($format_ind <= 0x16)) ||
		    (($format_ind >= 0x25) && ($format_ind <= 0x28)) ||
		    (($format_ind >= 0x2d) && ($format_ind <= 0x31)) ) {
			$format = array();
			$format['format_index'] = $format_ind;
		}
	 }
	 return $format;
	}

	function GetCellBgcolor($n,$col,$row) {
	 $bgcolor = false;
	 if( $this->opt['read_bgcolor'] &&
	     (($bgcolor_ind = $this->get_xf($n,$col,$row,'bgcolor')) !== false) ) {
		if( isset($this->palette[$bgcolor_ind]) )
			$bgcolor = $this->palette[$bgcolor_ind];
	 }
	 return $bgcolor;
	}

	function GetCellAlign($n,$col,$row) {
	 $al = false;
	 if( $this->opt['read_align'] &&
	     (($align = $this->get_xf($n,$col,$row,'align')) !== false) ) {
		$al['align'] = $align & 7;
		$al['valign'] = ($align >> 4) & 7;
		$al['word_wrap'] = (boolean)(($align >> 3) & 1);
	 }
	 return $al;
	}

	function GetCellBorders($n,$col,$row,$ex_hidden=false,$ex_merged=false) {
	 if( !$this->opt['read_border'] ) return false;

	 $b = array();
	 if( ($border = $this->get_xf($n,$col,$row,'border')) === false )
		$border = array(0,0,0,0,0x40,0x40,0x40,0x40,0,0,0,0x40);

	 $col_l = $border[4];
	 $col_r = $border[5];
	 $col_t = $border[6];
	 $col_b = $border[7];
	 $b['border']['left_style'] = $border[0];
	 $b['border']['right_style'] = $border[1];
	 $b['border']['top_style'] = $border[2];
	 $b['border']['bottom_style'] = $border[3];

	 $trow = $row - 1;
	 $lcol = $col - 1;

	 if( $ex_merged ) {
	  $brow = $row + $this->getMergedRowsNum($n,$col,$row) - 1;
	  $rcol = $col + $this->getMergedColumnsNum($n,$col,$row) - 1;
	  if( ($mborder = $this->get_xf($n,$rcol,$brow,'border')) !== false ) {
	   $col_r = $mborder[5];
	   $col_b = $mborder[7];
	   $b['border']['right_style'] = $mborder[1];
	   $b['border']['bottom_style'] = $mborder[3];
	  }
	  $brow++;
	  $rcol++;
	 } else {
	  $brow = $row + 1;
	  $rcol = $col + 1;
	 }

	 if( $ex_hidden ) {
	   while( ($trow >= 0) && $this->IsHiddenRow($n,$trow) ) $trow--;
	   if( $trow < 0 ) $trow = false;
	   while( ($lcol >= 0) && $this->IsHiddenColumn($n,$lcol) ) $lcol--;
	   if( $lcol < 0 ) $lcol = false;
	   $lc = $this->GetLastColumnIndex($n);
	   while( ($rcol <= $lc) && $this->IsHiddenColumn($n,$rcol) ) $rcol++;
	   if( $rcol > $lc ) $rcol = false;
	   $lr = $this->GetLastRowIndex($n);
	   while( ($brow <= $lr) && $this->IsHiddenRow($n,$brow) ) $brow++;
	   if( $brow > $lr ) $brow = false;
	 }

	 if( ($trow !== false) && (($cl = $this->get_xf($n,$col,$trow,'border')) !== false) &&
	     ($cl[3] > $border[2]) ) {
		$b['border']['top_style'] = $cl[3];
		$col_t = $cl[7];
	 }

	 if( ($lcol !== false) && (($cl = $this->get_xf($n,$lcol,$row,'border')) !== false) &&
	     ($cl[1] > $border[0]) ) {
		$b['border']['left_style'] = $cl[1];
		$col_l = $cl[5];
	 }

	 if( ($rcol !== false) && (($cl = $this->get_xf($n,$rcol,$row,'border')) !== false) &&
	     ($cl[0] > $border[1]) ) {
		$b['border']['right_style'] = $cl[0];
		$col_r = $cl[4];
	 }

	 if( ($brow !== false) && (($cl = $this->get_xf($n,$col,$brow,'border')) !== false) &&
	     ($cl[2] > $border[3]) ) {
		$b['border']['bottom_style'] = $cl[2];
		$col_b = $cl[6];
	 }

	 if( isset($this->worksheet[$n]['data']['grid_color']) ) {
	  $dgc = $this->worksheet[$n]['data']['grid_color'];
	  $b['border']['left_color'] = $dgc;
	  $b['border']['right_color'] = $dgc;
	  $b['border']['top_color'] = $dgc;
	  $b['border']['bottom_color'] = $dgc;
	  $b['border']['diag_color'] = $dgc;
	 }

	 if( isset($this->palette[$col_l]) && ($b['border']['left_style'] != 0) )
		$b['border']['left_color'] = $this->palette[$col_l];

	 if( isset($this->palette[$col_r]) && ($b['border']['right_style'] != 0) )
		$b['border']['right_color'] = $this->palette[$col_r];

	 if( isset($this->palette[$col_t]) && ($b['border']['top_style'] != 0) )
		$b['border']['top_color'] = $this->palette[$col_t];

	 if( isset($this->palette[$col_b]) && ($b['border']['bottom_style'] != 0) )
		$b['border']['bottom_color'] = $this->palette[$col_b];

	 $b['border']['diag_tl2rb'] = $border[8];
	 $b['border']['diag_bl2rt'] = $border[9];
	 $b['border']['diag_style'] = $border[10];

	 if( isset($this->palette[$border[11]]) && ($b['border']['diag_style'] != 0) )
		$b['border']['diag_color'] = $this->palette[$border[11]];

	 return $b;
	}

	function GetCellStyle($n,$col,$row,$ex_hidden=false,$ex_merged=false) {
	 $style = array();

	 if( ($font = $this->GetCellFont($n,$col,$row)) !== false )
		$style = $font;

	 if( ($format = $this->GetCellFormat($n,$col,$row)) !== false )
		$style += $format;

	 if( ($bgcolor = $this->GetCellBgcolor($n,$col,$row)) !== false )
		$style['bgcolor'] = $bgcolor;

	 if( ($align = $this->GetCellAlign($n,$col,$row)) !== false )
		$style += $align;

	 if( ($borders = $this->GetCellBorders($n,$col,$row,$ex_hidden,$ex_merged)) !== false )
		$style += $borders;

	 return $style;
	}

	function GetMergedColumnsNum($n,$col,$row,$exclude_hidden=false) {
		if( !isset($this->worksheet[$n]['data']['merged_columns']) ||
		    !isset($this->worksheet[$n]['data']['merged_columns'][$row][$col]) ) {
			return 1;
		}
		$mc = (int)($this->worksheet[$n]['data']['merged_columns'][$row][$col]);
		if( $exclude_hidden ) {
			$new_mc = $mc;
			for( $i=$col; $i<$col+$mc; $i++ ) {
				if( $this->IsHiddenColumn($n,$i) )
					$new_mc--;
			}
			$mc = $new_mc;
		}
		return $mc;
	}

	function GetMergedRowsNum($n,$col,$row,$exclude_hidden=false) {
		if( !isset($this->worksheet[$n]['data']['merged_rows']) ||
		    !isset($this->worksheet[$n]['data']['merged_rows'][$row][$col]) ) {
			return 1;
		}
		$mc = (int)($this->worksheet[$n]['data']['merged_rows'][$row][$col]);
		if( $exclude_hidden ) {
			$new_mc = $mc;
			for( $i=$row; $i<$row+$mc; $i++ ) {
				if( $this->IsHiddenRow($n,$i) )
					$new_mc--;
			}
			$mc = $new_mc;
		}
		return $mc;
	}

/*
 * Miscellaneous functions
 *
 */

	function SerializeData() {
	 $sst = '';
	 for( $i=0; $i<count($this->sst); $i++ ) {
		$sz = strlen($this->sst[$i]);
		$sst .= chr($sz & 0xFF).chr($sz >> 8).$this->sst[$i];
	 }

	 return serialize(array(
		$this->worksheet,
		$sst,
		$this->xf,
		$this->format,
		$this->font,
		$this->palette,
		$this->date1904,
		$this->link
	 ));
	}

	function UnserializeData($data) {
	 $data = unserialize($data);
	 if( !is_array($data) || (count($data)<8) ) {
		return false;
	 }

	 $this->worksheet = $data[0];

	 $ofs = 0;
	 $this->sst = array();
	 while( $ofs<strlen($data[1])-1 ) {
		$sz = ord($data[1][$ofs])|(ord($data[1][$ofs+1])<<8);
		$this->sst[] = substr($data[1],$ofs+2,$sz);
		$ofs += 2+$sz;
	 }

	 $this->xf = $data[2];
	 $this->format = $data[3];
	 $this->font = $data[4];
	 $this->palette = $data[5];
	 $this->date1904 = $data[6];
	 $this->link = $data[7];

	 return true;
	}

	function GetFontsList() {
	 $fl = array();
	 for( $i=0; $i<count($this->font); $i++ ) {
		$f = $this->font[$i];
		unset($f['pal_ind']);
		$pal_ind = $this->font[$i]['pal_ind'];
		if( isset($this->palette[$pal_ind]) ) {
			$f['color'] = $this->palette[$pal_ind];
		}
		$fl[] = $f;
	 }
	 return $fl;
	}

	function GetFormatsList() {
	 return $this->format;
	}

/*
 * End of public interface
 *
 */

	function get_xf($n,$col,$row,$id) {
	 $xf_ind = false;
	 if( $this->memory_safe ) {
	 	$cell = $this->read_cell($n,$col,$row);
		if( ($cell !== false) && isset($cell['cell_xf']) )
			$xf_ind = $cell['cell_xf'];
	 } else {
		if( isset($this->worksheet[$n]['data']['cell_xf'][$row][$col]) )
		  $xf_ind = $this->worksheet[$n]['data']['cell_xf'][$row][$col];
	 }

	 if( ($xf_ind !== false) && isset($this->xf[$id][$xf_ind]) )
		return $this->xf[$id][$xf_ind];

	 if( $this->memory_safe ) {
		$r = $this->read_row($n,$row);
		if( ($r !== false) && isset($r['row_xf']) ) {
			$xf_ind = $r['row_xf'];
			if( isset($this->xf[$id][$xf_ind]) )
				return $this->xf[$id][$xf_ind];
		}
	 } else {
		if( isset($this->worksheet[$n]['data']['row_xf'][$row]) ) {
			$xf_ind = $this->worksheet[$n]['data']['row_xf'][$row];
			if( isset($this->xf[$id][$xf_ind]) )
				return $this->xf[$id][$xf_ind];
		}
	 }

	 if( isset($this->worksheet[$n]['data']['column_xf'][$col]) ) {
		$xf_ind = $this->worksheet[$n]['data']['column_xf'][$col];
		if( isset($this->xf[$id][$xf_ind]) )
			return $this->xf[$id][$xf_ind];
	 }

	 if( isset($this->xf[$id][15]) )
		return $this->xf[$id][15];

	 return false;
	}

	function set_options($options) {
	 if( isset($options['read_only_sheets_info']) &&
	     $options['read_only_sheets_info'] )
		$this->explore_mode = 1;

	 if( isset($options['explore_sheet']) )
		$this->explore_sheet = (int)$options['explore_sheet'];

	 if( isset($options['read_font']) )
		$this->opt['read_font'] = (boolean)$options['read_font'];

	 if( isset($options['read_format']) )
		$this->opt['read_format'] = (boolean)$options['read_format'];

	 if( isset($options['read_align']) )
		$this->opt['read_align'] = (boolean)$options['read_align'];

	 if( isset($options['read_bgcolor']) )
		$this->opt['read_bgcolor'] = (boolean)$options['read_bgcolor'];

	 if( isset($options['read_border']) )
		$this->opt['read_border'] = (boolean)$options['read_border'];

	 if( isset($options['read_formula']) )
		$this->opt['read_formula'] = (boolean)$options['read_formula'];

	 if( isset($options['read_link']) )
		$this->opt['read_link'] = (boolean)$options['read_link'];

	}

	function file_add2cache($block,$data) {
		unset($this->file_cache[$block]);
		$this->file_cache[$block] = $data;

		if( count($this->file_cache) > $this->file_cache_max_blocks ) {
			reset($this->file_cache);
			$ind = key($this->file_cache);
			unset($this->file_cache[$ind]);
		}
	}

	function file_read($ofs,$sz) {

	  if( $sz < 0 ) return false;

	  if( $this->explore_from_file ) {
	      if( $ofs + $sz > $this->book_length ) return false;

	      $data = '';
	      while( $sz > 0 ) {
		$ci = $ofs >> 9;
		if( !isset($this->book_fat_chain[$ci]) ) {
			return false;
		}

		if( isset($this->file_cache[$ci]) ) {
			$b = $this->file_cache[$ci];
		} else {

		  for( $j=1; $j<64; $j++ )
		    if( !isset($this->book_fat_chain[$ci+$j]) ||
			($this->book_fat_chain[$ci+$j-1]+1 != $this->book_fat_chain[$ci+$j]) ) {
			break;
		    }

		  if( fseek( $this->file_handle, 0x200+$this->book_fat_chain[$ci]*0x200 ) == -1 )
			return false;

		  $b = fread( $this->file_handle, 0x200*$j );
		  if( strlen($b) != 0x200*$j ) return false;

		  $c = 0;
		  while( $c < $j ) {
			$this->file_add2cache($ci+$c,substr($b,0x200*$c,0x200));
			$c++;
		  }
		}

		$rofs = $ofs & 0x1FF;
		$rdsz = strlen($b);
		$rsz = ($sz > $rdsz-$rofs) ? $rdsz-$rofs : $sz;
		$b = substr($b,$rofs,$rsz);
		if( strlen($b) != $rsz )
			return false;

		$data .= $b;
		$sz -= $rsz;
		$ofs = (($ofs >> 9) << 9) + $rdsz;
	      }
	  } else {
		$data = substr($this->bd,$ofs,$sz);
		if( strlen($data) != $sz )
			return false;
	  }

	  return $data;
	}

	// $whence:
	// 0 - seek to absolute position of the readed and assembled book stream
	// 1 - seek to relative position of the readed and assembled book stream
	function file_seek($pos,$whence=0) {
		if( $whence == 0 ) {
			$this->book_offset = $pos;
		} elseif( $whence == 1 ) {
			$this->book_offset += $pos;
		} else {
			return $this->book_offset;
		}
		if( $this->book_offset < 0 )
			$this->book_offset = 0;
		if( $this->book_offset > $this->book_length )
			$this->book_offset = $this->book_length;
		return $this->book_offset;
	}

	function file_getRecordType() {
	  $str = $this->file_read($this->book_offset,2);
	  if( strlen($str) != 2 )
		return false;

	  return ord($str[0])|(ord($str[1])<<8);
	}

	function file_getRecordSize() {
	  $str = $this->file_read($this->book_offset+2,2);
	  if( strlen($str) != 2 )
		return false;

	  return ord($str[0])|(ord($str[1])<<8);
	}

	function file_nextRecord() {
		return $this->file_seek($this->file_getRecordSize()+4,1);

	}

	function file_getRecord($sz=false) {
	  $recsz = $this->file_getRecordSize();
	  if( ($sz !== false) && ($sz < $recsz) ) $recsz = $sz;
	  if( $recsz === false )
		return false;

	  return $this->file_read($this->book_offset+4,$recsz);
	}

	function is_percent_format($f) {
	 if( ($f==9) || ($f==0x0a) )
		return true;

	 if( !isset($this->format[$f]) )
		return false;

	 $fs = $this->format[$f];
	 if( !$fs || $this->IsUnicode($fs) )
		return false;

	 $fs = $this->AsPlain($fs);

	 if( (strlen($fs) > 0) && ($fs[strlen($fs)-1] == '%')  )
		return true;

	 return false;
	}

	function is_date_format($f) {
	 if ( (($f>=0x0e) && ($f<=0x16)) || (($f>=0x2d) && ($f<=0x2f)) )
		return true;

	 if( !isset($this->format[$f]) )
		return false;

	 $fs = $this->format[$f];
	 if( !$fs || $this->IsUnicode($fs) )
		return false;

	 $fs = $this->AsPlain($fs);
	 if( $fs=='' )
		return false;

	 $f = 0xff;
	 foreach( $this->known_date_formats as $i => $value )
		if( !strcmp($value,$fs) ) {
			$f = $i;
			break;
		}

	 if( $f==0xff )
		return false;

	 return true;
	}

	function as_date($s) {
	 if( $s<0 )
		return $s;

	 $DaysInMonths = array(0,31,59,90,120,151,181,212,243,273,304,334);
	 $DaysInMonthsV = array(0,31,60,91,121,152,182,213,244,274,305,335);

	 if( ($this->date1904==0) && ($s<60) )
		$s++;
	 // days in 1900 years (1-1899)
	 $ds = (int)$s+693595-2+1462*$this->date1904;

	 // 400-year periods in $ds
	 $d1 = (int)($ds/146097);
	 // days after last 400-year period (0-146096)
	 $d2 = $ds-146097*$d1;
	 // 100-year periods in $d2
	 $d3 = (int)($d2/36524);
	 if( $d3>3 )
		$d3 = 3;
	 // days after last 100-year period (0-36523 or 0-36524)
	 $d4 = $d2-36524*$d3;
	 // 4-year periods in $d4
	 $d5 = (int)($d4/1461);
	 // days after last 4-year period (0-1460)
	 $d6 = $d4-1461*$d5;
	 // years in $d6
	 $d7 = (int)($d6/365);
	 if( $d7>3 )
		$d7 = 3;
	 // days in a last year (1-365 or 1-366)
	 $d8 = $d6-365*$d7+1;

	 $date_year = 400*$d1 + 100*$d3 + 4*$d5 + $d7 + 1;

	 $v = false;
	 if( (($date_year % 400) == 0) || 
	     ((($date_year % 100) != 0) && (($date_year % 4) == 0)) )
		$v = true;

	 $i = 1;
	 if( $v ) {
		while( ($i<12) && ($d8>$DaysInMonthsV[$i]) ) $i++;
		$date_month = $i;
		$date_day = $d8 - $DaysInMonthsV[$i-1];
	 } else {
		while( ($i<12) && ($d8>$DaysInMonths[$i]) ) $i++;
		$date_month = $i;
		$date_day = $d8 - $DaysInMonths[$i-1];
	 }

	 $tm = $s-(int)$s;
	 $tm = round(24*60*60*1000*$tm);
	 $time_msec = ($tm % 1000);
	 $tm = (int)(($tm-$time_msec)/1000);
	 $time_sec = ($tm % 60);
	 $tm = (int)(($tm-$time_sec)/60);
	 $time_min = ($tm % 60);
	 $tm = (int)(($tm-$time_min)/60);
	 $time_hour = ($tm % 24);

	 return array(
		'year'	=> $date_year,
		'month'	=> $date_month,
		'day'	=> $date_day,
		'hour'	=> $time_hour,
		'min'	=> $time_min,
		'sec'	=> $time_sec,
		'usec'	=> $time_msec
	 );
	}

	function date_format($s,$f) {

	 if ( !((($f>=0x0e) && ($f<=0x16)) || (($f>=0x2d) && ($f<=0x2f))) ) {

	  $fs = $this->AsPlain($this->format[$f]);
	  foreach( $this->known_date_formats as $i => $value )
		if( !strcmp($value,$fs) ) {
			$f = $i;
			break;
		}
	 } else {
		$f += 0x100;
	 }

	 $ret = $this->as_date($s);
	 $date_year = $ret['year'];
	 $date_month = $ret['month'];
	 $date_day = $ret['day'];
	 $time_hour = $ret['hour'];
	 $time_min = $ret['min'];
	 $time_sec = $ret['sec'];
	 $time_msec = $ret['usec'];

	 for($i=1; $i<=12; $i++) {
		$month[$i] = date('F',mktime(12,0,0,$i,10,2000));
		$month3[$i] = date('M',mktime(12,0,0,$i,10,2000));
	 }

	 $date_year2 = sprintf('%02d',($date_year % 100));
	 $date_month2 = sprintf('%02d',$date_month);
	 $date_day2 = sprintf('%02d',$date_day);
	 $time_hour2 = sprintf('%02d',$time_hour);
	 $time_min2 = sprintf('%02d',$time_min);
	 $time_sec2 = sprintf('%02d',$time_sec);
	 if( $time_hour>=12 ) {
		$time_ap = 'PM';
		$time_hour12 = $time_hour-12;
	 } else {
		$time_ap = 'AM';
		$time_hour12 = $time_hour;
	 }
	 if( $time_hour12==0 )
		$time_hour12 = 12;
	 $time_hour_full = (int)($s*24);


	 $s = '';
	 switch ($f) {

		//--- CUSTOM ---
		// d/m/yy
		case 1:
			$s = '/'.$date_year2;

		// d/m
		case 0:
			$s = $date_day.'/'.$date_month.$s;
			break;

		// dd/mm/yy\ h:mm\ AM/PM
		case 9:
			$s = ' '.$time_hour12.':'.$time_min2.' '.$time_ap;

		// dd/mm/yy
		case 2:
			$s = $date_day2.'/'.$date_month2.'/'.$date_year2.$s;
			break;

		// d\ mmm\ yy
		case 4:
			$s = ' '.$date_year2;

		// d\ mmm
		case 3:
			$s = $date_day.' '.$month3[$date_month].$s;
			break;

		// dd\ mmm\ yy
		case 5:
			$s = $date_day2.' '.$month3[$date_month].' '.$date_year2;
			break;

		// mmm\ yy
		case 6:
			$s = $month3[$date_month].' '.$date_year2;
			break;

		// mmmm\ yy
		case 7:
			$s = $month[$date_month].' '.$date_year2;
			break;

		// d\ mmmm\,\ yyyy
		case 8:
			$s = $date_day.' '.$month[$date_month].', '.$date_year;
			break;

		// dd/mm/yy\ h:mm
		case 0x0a:
			$s = $date_day2.'/'.$date_month2.'/'.$date_year2.' '.$time_hour.':'.$time_min2;
			break;

		// mmmm\ d
		case 0x0d:
			$s = ' '.$date_day;

		// mmmm
		case 0x0b:
			$s = $month[$date_month].$s;
			break;

		// mmmmm\-yy
		case 0x0c:
			$s = $month[$date_month][0].'-'.$date_year2;
			break;

		// d\ mmmm
		case 0x0e:
			$s = $date_day.' '.$month[$date_month];
			break;

		// d/mm/yyyy
		case 0x0f:
			$s = $date_day.'/'.$date_month2.'/'.$date_year;
			break;

		// dd/mm/yyyy
		case 0x10:
			$s = $date_day2.'/'.$date_month2.'/'.$date_year;
			break;

		// d/m/yyyy
		case 0x11:
			$s = $date_day.'/'.$date_month.'/'.$date_year;
			break;

		// dd\-mmm\-yy
		case 0x12:
			$s = $date_day2.'-'.$month3[$date_month].'-'.$date_year2;
			break;

		//--- BUILD-IN ---
		// m/d/yyyy\ h:mm
		case 0x0116:
			$s = ' '.$time_hour.':'.$time_min2;

		// m/d/yyyy
		case 0x010e:
			$s = $date_month.'/'.$date_day.'/'.$date_year.$s;
			break;

		// d\-mmm\-yy
		case 0x010f:
			$s = '-'.$date_year2;

		// d\-mmm
		case 0x0110:
			$s = $date_day.'-'.$month3[$date_month].$s;
			break;

		// mmm\-yy
		case 0x0111:
			$s = $month3[$date_month].'-'.$date_year2;
			break;

		// h:mm AM/PM
		case 0x0112:
			$s = $time_hour12.':'.$time_min2.' '.$time_ap;
			break;

		// h:mm:ss AM/PM
		case 0x0113:
			$s = $time_hour12.':'.$time_min2.':'.$time_sec2.' '.$time_ap;
			break;

		// h:mm:ss
		case 0x0115:
			$s = ':'.$time_sec2;

		// h:mm
		case 0x0114:
			$s = $time_hour.':'.$time_min2.$s;
			break;

		// mm:ss
		case 0x012d:
			$s = $time_min2.':'.$time_sec2;
			break;

		// [h]:mm:ss
		case 0x012e:
			$s = $time_hour_full.':'.$time_min2.':'.$time_sec2;
			break;

		// mm:ss.0
		case 0x012f:
			$s = $time_min2.':'.$time_sec2.'.'.round(($time_msec-1)/100);
			break;
	 }
	 return array(
		'string'=> $s,
		'year'	=> $date_year,
		'month'	=> $date_month,
		'day'	=> $date_day,
		'hour'	=> $time_hour,
		'min'	=> $time_min,
		'sec'	=> $time_sec,
		'usec'	=> $time_msec
	 );
	}

	function s2l($s) {
	 return 16777216*ord($s[3])+(ord($s[0])|(ord($s[1])<<8)|(ord($s[2])<<16));
	}

	function chain($first) {
		$chain = array();

		$next = $first;
		while(  ($next!=0xfffffffe) &&
			($next <= $this->last_block) &&
			(($next+1) <= count($this->fat)) ) {
			$chain[] = $next;
			$next = $this->fat[$next];
		}
		if( $next != 0xfffffffe ) return false;
		return $chain;
	}

	function small_chain($first) {
		$chain = array();

		$next = $first;
		while(  ($next!=0xfffffffe) &&
			($next <= $this->last_small_block) &&
			(($next+1) <= count($this->small_fat)) ) {
			$chain[] = $next;
			$next = $this->small_fat[$next];
		}
		if( $next != 0xfffffffe ) return false;
		return $chain;
	}

	function stream($item_name,$item_num=0) {

		$dt = ord($this->directory[$item_num*0x80+0x42]);
		$prev = $this->s2l(substr($this->directory,$item_num*0x80+0x44,4));
		$next = $this->s2l(substr($this->directory,$item_num*0x80+0x48,4));
		$dir = $this->s2l(substr($this->directory,$item_num*0x80+0x4c,4));

		$curr_name = '';
		if( ($dt==2) || ($dt==5) )
			for( $i=0;
			 $i < (ord($this->directory[$item_num*0x80+0x40]) + 
			  256*ord($this->directory[$item_num*0x80+0x41]))/2-1;
			 $i++ )
				$curr_name .= $this->directory[$item_num*0x80+$i*2];

		if( (($dt==2) || ($dt==5)) && (strcasecmp($curr_name,$item_name)==0) )
			return $item_num;

		if( $prev != 0xffffffff ) {
			$i = $this->stream($item_name,$prev);
			if( $i>=0 ) return $i;
		}
		if( $next != 0xffffffff ) {
			$i = $this->stream($item_name,$next);
			if( $i>=0 ) return $i;
		}
		if( $dir != 0xffffffff ) {
			$i = $this->stream($item_name,$dir);
			if( $i>=0 ) return $i;
		}

		return -1;
	}

	function rk($rk) {
		if( $rk & 2 ) {
			$val = ($rk & 0xfffffffc) >> 2;
			if( $rk & 1 ) $val = $val / 100;
			return (int)$val;
		}

		$frk = $rk;

		$fexp =  (($frk & 0x7ff00000) >> 20) - 1023;
		$val = 1+(($frk & 0x000fffff) >> 2)/262144;

		if( $fexp > 0 ) {
			for( $i=0; $i<$fexp; $i++ )
				$val *= 2;
		} else {
			if( $fexp==-1023 ) {
				$val=0;
			} else {
			 for( $i=0; $i<abs($fexp); $i++ )
				$val /= 2;
			}
		}

		if( $rk & 1 ) $val = $val / 100;
		if( $rk & 0x80000000 ) $val = -$val;

		return (float)$val;
	}

	function ieee($ieee) {
		$num_lo = 16777216*ord($ieee[3])+(ord($ieee[0])|(ord($ieee[1])<<8)|(ord($ieee[2])<<16));
		$num_hi = 16777216*ord($ieee[7])+(ord($ieee[4])|(ord($ieee[5])<<8)|(ord($ieee[6])<<16));

		$fexp = (($num_hi & 0x7ff00000) >> 20) - 1023;
		$val = 1+(($num_hi & 0x000fffff)+$num_lo/4294967296)/1048576;

		if( ($fexp==1024) || ($fexp==-1023) )
			return (float)0;

		if( $fexp > 0 ) {
			for( $i=0; $i<$fexp; $i++ )
				$val *= 2;
		} else {
			for( $i=0; $i<abs($fexp); $i++ )
				$val /= 2;
		}
		if( $num_hi & 0x80000000 ) $val = -$val;

		return (float)$val;
	}

	function row_add2cache($w,$r,$data) {
		$ind = "{$w}_{$r}";
		unset($this->row_cache[$ind]);
		$this->row_cache[$ind] = $data;

		if( count($this->row_cache) > $this->row_cache_max_records ) {
			reset($this->row_cache);
			$ind = key($this->row_cache);
			unset($this->row_cache[$ind]);
		}
	}

	// Read ROWINFO for specified row
	// Used only in memory_safe mode
	function read_row($w,$r) {
		$ind = "{$w}_{$r}";
		if( isset($this->row_cache[$ind]) )
			return $this->row_cache[$ind];

		if( !isset($this->worksheet[$w]['data']['rofs'][$r]) )
			return false;

		$this->file_seek($this->worksheet[$w]['data']['rofs'][$r]);
		if( ($this->file_getRecordType() != 0x0208) ||
		    (($record = $this->file_getRecord()) === false) )
			return false;

		$row_data = array();

		$height = ord($record[6])|(ord($record[7])<<8);
		if( !($height & 0x8000) ) {
			if( !isset($this->worksheet[$w]['data']['defrowheight']) ||
			    ($height != $this->worksheet[$w]['data']['defrowheight']) ) {
				$row_data['row_height'] = $height;
			}
		}

		$opts = 16777216*ord($record[15])+(ord($record[12])|(ord($record[13])<<8)|(ord($record[14])<<16));
		if( $opts & 0x0020 )
			$row_data['row_hidden'] = true;
		if( $level = ($opts & 0x7) )
			$row_data['row_level'] = $level;
		if( $opts & 0x80 )
			$row_data['row_xf'] = ($opts & 0x0fff0000) >> 16;

		$this->row_add2cache($w,$r,$row_data);
		return $row_data;
	}

	function cell_add2cache($w,$c,$r,$data) {
		$ind = "{$w}_{$c}_{$r}";
		unset($this->cell_cache[$ind]);
		$this->cell_cache[$ind] = $data;

		if( count($this->cell_cache) > $this->cell_cache_max_records ) {
			reset($this->cell_cache);
			$ind = key($this->cell_cache);
			unset($this->cell_cache[$ind]);
		}
	}

	// Read cell record of the specified row
	// Used only in memory_safe mode
	// Returns false in no cell data found
	function read_cell($w,$c,$r) {
		$ind = "{$w}_{$c}_{$r}";
		if( isset($this->cell_cache[$ind]) )
			return $this->cell_cache[$ind];

		if( !isset($this->worksheet[$w]['data']['lc'][$r]) ||
		    ($this->worksheet[$w]['data']['lc'][$r] < $c) )
			return false;

		if( !isset($this->worksheet[$w]['data']['fcofs'][$r]) ) {
		  if( !isset($this->worksheet[$w]['data']['fcofs']) ||
		      (count($this->worksheet[$w]['data']['fcofs']) == 0) ) {
			$this->file_seek($this->ws_offsets[$w]);
		  } else {
			return false;
		  }
		} else {
		  $this->file_seek($this->worksheet[$w]['data']['fcofs'][$r]);
		}

		$fcell = false;
		while( (($record_type = $this->file_getRecordType()) != 0x0a) &&
		       ($record_type != 0x0208) ) {
		if(   !(($record_type == 0x0201) ||
		        ($record_type == 0x00be) ||
		        ($record_type == 0x0205) ||
		        ($record_type == 0x0203) ||
		        ($record_type == 0x027e) ||
		        ($record_type == 0x00bd) ||
		        ($record_type == 0x0204) ||
		        ($record_type == 0x00d6) ||
		        ($record_type == 0x0006) ||
		        ($record_type == 0x00fd)) ) {
			$this->file_nextRecord();
			continue;
		}

		  if( ($record = $this->file_getRecord()) === false ) break;
		  $data = array('last_row'=>0xffff,'last_col'=>0xffff);
		  $this->process_cell_record($record_type,$record,$data);
		  if( !isset($data['cell_type'][$r]) ) {
			if( isset($data['cell_type']) ) {
				reset($data['cell_type']);
				list($key,$value) = each($data['cell_type']);
				if( $key > $r ) break;
			}
			$this->file_nextRecord();
			continue;
		  }

		  foreach( $data['cell_type'][$r] as $col => $ct ) {
			$cell = array();
			$cell['cell_type'] = $data['cell_type'][$r][$col];
			if( isset($data['cell_data'][$r][$col]) ) {
			  $cell['cell_data'] = $data['cell_data'][$r][$col];
			}
			if( isset($data['cell_xf'][$r][$col]) ) {
			  $cell['cell_xf'] = $data['cell_xf'][$r][$col];
			}
			$this->cell_add2cache($w,$col,$r,$cell);
			if( $col == $c ) $fcell = $cell;
		  }
		  $this->file_nextRecord();
		}
		if( $fcell !== false ) {
			return $fcell;
		}

		return false;
	}

	// Process HLINK and QUICKTIP records
	// Returns array of link data or false if an error occurs
	function process_hlink($id,$record,&$data,$read_one_link=false) {
	  switch( $id ) {
		// HLINK
		case 0x01b8:
			$len = strlen($record);
			if( $len < 32 ) return false;
			$row = ord($record[0])|(ord($record[1])<<8);
			$lrow = ord($record[2])|(ord($record[3])<<8);
			$col = ord($record[4])|(ord($record[5])<<8);
			$lcol = ord($record[6])|(ord($record[7])<<8);

			$opt = $this->s2l(substr($record,28,4));

			$link = array('type' => 0,'absolute' => ($opt & 2) >> 1);

			$lofs = 32;
			if( ($opt & 0x14) == 0x14 ) {
				$dlen = $this->s2l(substr($record,32,4));
				if( $len < 36+2*$dlen ) return false;
				$lofs = 36+2*$dlen;
			}

			if( ($opt & 0x101) == 1 ) {
			  if( $len < $lofs+16 ) return false;

			  $url_id = array(
				0xe0,0xc9,0xea,0x79,0xf9,0xba,0xce,0x11,
				0x8c,0x82,0x00,0xaa,0x00,0x4b,0xa9,0x0b
			  );
			  $file_id = array(
				0x03,0x03,0x00,0x00,0x00,0x00,0x00,0x00,
				0xc0,0x00,0x00,0x00,0x00,0x00,0x00,0x46
			  );

			  $url = true;
			  for( $i=0; $i<count($url_id); $i++ ) {
				if( $url_id[$i] != ord($record[$lofs+$i]) ) {
					$url = false;
					break;
				}
			  }

			  if( !$url ) {
				$file = true;
				for( $i=0; $i<count($file_id); $i++ ) {
				  if( $file_id[$i] != ord($record[$lofs+$i]) ) {
					$file = false;
					break;
				  }
				}
			  } else {
				$file = false;
			  }

			  if( $url || $file ) {
			    if( $url ) {
				$link['type'] = 1;
				$ulen = $this->s2l(substr($record,$lofs+16,4));
				if( $len < $lofs+20+$ulen ) return false;

				$url = chr(1);
				if( $ulen > 2 ) {
				  $url .= substr($record,$lofs+20,$ulen-2);
				}
				$lofs += 20+$ulen;
				$link['link'] = $url;
			    } elseif( $file ) {
				$link['type'] = 2;
				$link['updir'] = ord($record[$lofs+16])|(ord($record[$lofs+17])<<8);

				$sfnlen = $this->s2l(substr($record,$lofs+18,4));

				if( $len < $lofs+22+$sfnlen ) return false;

				$sfn = chr(0);
				if( $sfnlen > 1 ) {
					$sfn .= substr($record,$lofs+22,$sfnlen-1);
				}

				$lfnslen = $this->s2l(substr($record,$lofs+46+$sfnlen,4));
				$lfnlen = 0;
				if( $lfnslen > 4 ) {
					$lfnlen = $this->s2l(substr($record,$lofs+50+$sfnlen,4));
				}

				if( $len < $lofs+50+$sfnlen+$lfnslen ) return false;

				if( $lfnlen > 0 ) {
					$fn = chr(1).substr($record,$lofs+56+$sfnlen,$lfnlen);
				} else {
					$fn = $sfn;
				}

				$lofs += 50+$sfnlen+$lfnslen;
				$link['link'] = $fn;
			    }

			  }

			} elseif( ($opt & 0x103) == 0x103 ) {
				$link['type'] = 3;
				$ulen = $this->s2l(substr($record,$lofs,4));
				if( $len < $lofs+$ulen*2 ) return false;
				$unc = chr(1);
				if( $ulen > 0 ) {
				  $unc .= substr($record,$lofs+4,$ulen*2-2);
				}
				$lofs += 4+$ulen*2;
				$link['link'] = $unc;
			}

			if( $opt & 0x80 ) {
				$tlen = $this->s2l(substr($record,$lofs,4));
				if( $len < $lofs+$tlen*2 ) return false;
				$target = chr(1);
				if( $tlen > 0 ) {
				  $target .= substr($record,$lofs+4,$tlen*2-2);
				}
				$lofs += 4+$tlen*2;
				$link['target'] = $target;
			}

			if( $opt & 8 ) {
				$tlen = $this->s2l(substr($record,$lofs,4));
				if( $len < $lofs+$tlen*2 ) return false;
				$tmark = chr(1);
				if( $tlen > 0 ) {
				  $tmark .= substr($record,$lofs+4,$tlen*2-2);
				}
				$lofs += 4+$tlen*2;
				$link['tmark'] = $tmark;
			}

			if( $read_one_link ) {
				$data = $link;
				return true;
			}

			$this->link[] = $link;
			$ind = count($this->link)-1;

			for( $i=$row; $i<=$lrow; $i++ ) {
			  for( $j=$col; $j<=$lcol; $j++ ) {
				$data['cell_link'][$row][$col] = $ind;
			  }
			}

			return true;

		  // QUICKTIP
		  case 0x0800:
			$len = strlen($record);
			if( $len < 10 ) return false;

			$qtlen = $len-10;
			if( $qtlen <= 2 ) return true;

			$row = ord($record[2])|(ord($record[3])<<8);
			$lrow = ord($record[4])|(ord($record[5])<<8);
			$col = ord($record[6])|(ord($record[7])<<8);
			$lcol = ord($record[8])|(ord($record[9])<<8);

			$qt = chr(1).substr($record,10,$qtlen-2);

			if( $read_one_link ) {
				$data['quick_tip'] = $qt;
				return true;
			}

			for( $i=$row; $i<=$lrow; $i++ ) {
			  for( $j=$col; $j<=$lcol; $j++ ) {
				if( isset($data['cell_link'][$row][$col]) ) {
					$lind = $data['cell_link'][$row][$col];
					$this->link[$lind]['quick_tip'] = $qt;
				} else {
					$this->link[]['quick_tip'] = $qt;
					$data['cell_link'][$row][$col] = count($this->link)-1;
				}
			  }
			}

			return true;

		default:
			return false;
	  }
	  return true;
	}

	function link_add2cache($w,$c,$r,$data) {
		$ind = "{$w}_{$c}_{$r}";
		unset($this->link_cache[$ind]);
		$this->link_cache[$ind] = $data;

		if( count($this->link_cache) > $this->link_cache_max_records ) {
			reset($this->link_cache);
			$ind = key($this->link_cache);
			unset($this->link_cache[$ind]);
		}
	}

	// Read cell link (if any) of the specified cell and row
	// Used only in memory_safe mode
	// Returns false in no cell link data found or readed data is invalid
	// Returns $link structure otherwise
	function read_hlink($w,$c,$r) {
		$ind = "{$w}_{$c}_{$r}";

		if( isset($this->link_cache[$ind]) )
			return $this->link_cache[$ind];

		if( !isset($this->worksheet[$w]['data']['lofs']["{$c}_{$r}"]) )
			return false;

		$this->file_seek($this->worksheet[$w]['data']['lofs']["{$c}_{$r}"]);
		if( ($this->file_getRecordType() != 0x01b8) ||
		    (($record = $this->file_getRecord()) === false) )
			return false;

		$link_data = array();
		if( $this->process_hlink(0x01b8,$record,$link_data,true) !== false ) {
		  if( isset($this->worksheet[$w]['data']['qtofs']["{$c}_{$r}"]) ) {
		    $this->file_seek($this->worksheet[$w]['data']['qtofs']["{$c}_{$r}"]);
		    if( ($this->file_getRecordType() == 0x0800) &&
			(($record = $this->file_getRecord()) !== false) ) {
				$this->process_hlink(0x0800,$record,$link_data,true);
		    }
		  }
		  $this->link_add2cache($w,$c,$r,$link_data);
		  return $link_data;
		}

		return false;
	}

	function process_cell_record($id,$record,&$data,$no_read=false) {
	  switch( $id ) {
		// BLANK
		case 0x0201:
			if( strlen($record) < 6 ) return 1;

			$row = ord($record[0])|(ord($record[1])<<8);
			$col = ord($record[2])|(ord($record[3])<<8);
			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			if( $no_read ) {
			  if( isset($data['rofs'][$row]) &&
			      !isset($data['fcofs'][$row]) ) {
				$data['fcofs'][$row] = $this->book_offset;
			  }
			  if( !isset($data['lc'][$row]) ||
				($data['lc'][$row] < $col) )
					$data['lc'][$row] = $col;
			  break;
			}

			$data['cell_type'][$row][$col] = 7;
			$data['cell_xf'][$row][$col] = ord($record[4])|(ord($record[5])<<8);
			break;

		  // MULBLANK
		  case 0x00be:
			$len = strlen($record);
			if( $len < 8 ) return 1;
			$row = ord($record[0])|(ord($record[1])<<8);
			$col = ord($record[2])|(ord($record[3])<<8);
			$lcol = ord($record[$len-2])|(ord($record[$len-1])<<8);
			if( $lcol < $col ) break;
			if( $len != ($lcol-$col+1)*2+6 ) break;

			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $lcol ) $data['last_col'] = $lcol;

			if( $no_read ) {
			  if( isset($data['rofs'][$row]) &&
			      !isset($data['fcofs'][$row]) ) {
				$data['fcofs'][$row] = $this->book_offset;
			  }
			  if( !isset($data['lc'][$row]) ||
				($data['lc'][$row] < $lcol) )
					$data['lc'][$row] = $lcol;
			  break;
			}

			for( $i=$col; $i<=$lcol; $i++) {
				$data['cell_type'][$row][$i] = 7;
				$data['cell_xf'][$row][$i] = ord($record[4+2*($i-$col)])|(ord($record[5+2*($i-$col)])<<8);
			}

			break;

		  // BOOLERR
		  case 0x0205:
			if( strlen($record) < 8 ) return 1;
			$row = ord($record[0])|(ord($record[1])<<8);
			$col = ord($record[2])|(ord($record[3])<<8);
			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			if( $no_read ) {
			  if( isset($data['rofs'][$row]) &&
			      !isset($data['fcofs'][$row]) ) {
				$data['fcofs'][$row] = $this->book_offset;
			  }
			  if( !isset($data['lc'][$row]) ||
				($data['lc'][$row] < $col) )
					$data['lc'][$row] = $col;
			  break;
			}

			if( ord($record[7])==0 ) {
				$data['cell_type'][$row][$col] = 4;
				$data['cell_data'][$row][$col] = (boolean)(ord($record[6]));
			} else {
				$data['cell_type'][$row][$col] = 5;
				$data['cell_data'][$row][$col] = (int)(ord($record[6]));
			}

			$data['cell_xf'][$row][$col] = ord($record[4])|(ord($record[5])<<8);

			break;

		  // NUMBER
		  case 0x0203:
			if( strlen($record) < 14 ) return 1;
			$row = ord($record[0])|(ord($record[1])<<8);
			$col = ord($record[2])|(ord($record[3])<<8);
			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			if( $no_read ) {
			  if( isset($data['rofs'][$row]) &&
			      !isset($data['fcofs'][$row]) ) {
				$data['fcofs'][$row] = $this->book_offset;
			  }
			  if( !isset($data['lc'][$row]) ||
				($data['lc'][$row] < $col) )
					$data['lc'][$row] = $col;
			  break;
			}

			$data['cell_type'][$row][$col] = 1;
			$data['cell_xf'][$row][$col] = ord($record[4])|(ord($record[5])<<8);
			$data['cell_data'][$row][$col] = $this->ieee(substr($record,6,8));

			break;

		  // RK
		  case 0x027e:
			if( strlen($record) < 0x0a ) return 1;
			$row = ord($record[0])|(ord($record[1])<<8);
			$col = ord($record[2])|(ord($record[3])<<8);
			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			if( $no_read ) {
			  if( isset($data['rofs'][$row]) &&
			      !isset($data['fcofs'][$row]) ) {
				$data['fcofs'][$row] = $this->book_offset;
			  }
			  if( !isset($data['lc'][$row]) ||
				($data['lc'][$row] < $col) )
					$data['lc'][$row] = $col;
			  break;
			}

			$data['cell_type'][$row][$col] = 1;
			$data['cell_data'][$row][$col] = $this->rk(16777216*ord($record[9])+(ord($record[6])|(ord($record[7])<<8)|(ord($record[8])<<16)));
			$data['cell_xf'][$row][$col] = ord($record[4])|(ord($record[5])<<8);

			break;

		  // MULRK
		  case 0x00bd:
			$rksz = strlen($record);
			if( $rksz < 6 ) return 1;

			$row = ord($record[0])|(ord($record[1])<<8);
			$fc = ord($record[2])|(ord($record[3])<<8);
			$lc = ord($record[$rksz-2])|(ord($record[$rksz-1])<<8);
			if( $lc < $fc ) break;
			if( $rksz != ($lc-$fc+1)*6+6 ) break;

			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $lc ) $data['last_col'] = $lc;

			if( $no_read ) {
			  if( isset($data['rofs'][$row]) &&
			      !isset($data['fcofs'][$row]) ) {
				$data['fcofs'][$row] = $this->book_offset;
			  }
			  if( !isset($data['lc'][$row]) ||
				($data['lc'][$row] < $lc) )
					$data['lc'][$row] = $lc;
			  break;
			}

			for( $i=0; $i<=$lc-$fc; $i++) {
			 $data['cell_type'][$row][$fc+$i] = 1;
			 $data['cell_data'][$row][$fc+$i] = $this->rk(16777216*ord($record[9+$i*6])+(ord($record[6+$i*6])|(ord($record[7+$i*6])<<8)|(ord($record[8+$i*6])<<16)));
			 $data['cell_xf'][$row][$fc+$i] = ord($record[4+$i*6])|(ord($record[5+$i*6])<<8);
			}

			break;

		  // LABEL or LABEL with formatting info
		  case 0x0204:
		  case 0x00d6:
			if( strlen($record) < 8 ) return 1;
			$row = ord($record[0])|(ord($record[1])<<8);
			$col = ord($record[2])|(ord($record[3])<<8);
			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			if( $no_read ) {
			  if( isset($data['rofs'][$row]) &&
			      !isset($data['fcofs'][$row]) ) {
				$data['fcofs'][$row] = $this->book_offset;
			  }
			  if( !isset($data['lc'][$row]) ||
				($data['lc'][$row] < $col) )
					$data['lc'][$row] = $col;
			  break;
			}

			$str_len = ord($record[6])|(ord($record[7])<<8);
			if( 8+$str_len > strlen($record) ) return 1;
			$data['cell_type'][$row][$col] = 0x83;
			$data['cell_data'][$row][$col] = chr(0).substr($record,8,$str_len);
			$data['cell_xf'][$row][$col] = ord($record[4])|(ord($record[5])<<8);

			break;

		  // FORMULA
		  case 0x0006:
			if( !$this->opt['read_formula'] ) break;
			if( strlen($record) < 20 ) return 1;

			$row = ord($record[0])|(ord($record[1])<<8);
			$col = ord($record[2])|(ord($record[3])<<8);
			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			if( $no_read ) {
			  if( isset($data['rofs'][$row]) &&
			      !isset($data['fcofs'][$row]) ) {
				$data['fcofs'][$row] = $this->book_offset;
			  }
			  if( !isset($data['lc'][$row]) ||
				($data['lc'][$row] < $col) )
					$data['lc'][$row] = $col;
			  break;
			}

			$xf = ord($record[4])|(ord($record[5])<<8);

			$data_ok = false;

			if( (ord($record[12])==0xff) && (ord($record[13])==0xff) ) {
			 switch (ord($record[6])) {

			  // STRING
	 		  case 0:
			   $file_offset = $this->book_offset;
			   $this->file_nextRecord();
			   $record = $this->file_getRecord();

			   if( $record === false ) return 1;

			   if( $this->file_getRecordType() != 0x0207 ) {
				$this->file_seek($file_offset);
			   } else {
			    $ln = ord($record[0])|(ord($record[1])<<8);

			    if( $this->biff_version < 8 ) {
			     if( $ln <= strlen($record)-2 ) {
				$s = chr(0).substr($record,2,$ln);
			     } else {
				$str = substr($record,2);
				$ln -= strlen($record)-2;
				while( $ln>0 ) {
				 $this->file_nextRecord();
				 if( ($this->file_getRecordType() != 0x3c) ||
				     ($record = $this->file_getRecord()) === false )
					return 1;

				 $str .= $record;
				 $ln -= strlen($record);
				}
			     }
			    } else {

			     $rt = 0;
			     $fesz = 0;
			     $s = chr(0);
			     $fln = $ln;
			     $sofs = 2;
			     $sz = strlen($record);

			     while ( $fln>0 ) {
			      $uc = ord($record[$sofs]) & 1;
			      $ln = $fln;

			      switch (ord($record[$sofs]) & 0x0c) {

			       case 0x0c:
				if( $sofs+7+$ln*($uc+1) > $sz )
					$ln = (int)($sz-$sofs-7)/($uc+1);
				$str = substr($record,$sofs+7,$ln*($uc+1));
				break;

			       case 8:
				if( $sofs+3+$ln*($uc+1) > $sz )
					$ln = (int)($sz-$sofs-3)/($uc+1);
				$str = substr($record,$sofs+3,$ln*($uc+1));
				break;

			       case 4:
				if( $sofs+5+$ln*($uc+1) > $sz )
					$ln = (int)($sz-$sofs-5)/($uc+1);
				$str = substr($record,$sofs+5,$ln*($uc+1));
				break;

			       case 0:
				if( $sofs+1+$ln*($uc+1) > $sz )
					$ln = (int)($sz-$sofs-1)/($uc+1);
			 	$str = substr($record,$sofs+1,$ln*($uc+1));
				break;
			      } // switch ...

			      if( ($uc==0) && (ord($s[0]) & 1) ) {
				$s2 = '';
				for( $i=0; $i<strlen($str); $i++ )
					$s2 .= $str[$i].chr(0);
				$str = $s2;
			      }

			      if( ($uc==1) && !(ord($s[0]) & 1) ) {
				$s2 = chr(1);
				for( $i=1; $i<strlen($s); $i++ )
					$s2 .= $s[$i].chr(0);
				$s = $s2;
			      }

			      $s .= $str;
			      $fln -= $ln;

			      if( $fln > 0 ) {
				$this->file_nextRecord();
				if( ($this->file_getRecordType() != 0x3c) ||
				    ($record = $this->file_getRecord()) === false )
					return 1;

				$sz = strlen($record);
				$sofs = 0;
			      }

			     } // while fln > 0 ...
			    } // if biff < 8 ...

			    $data['cell_type'][$row][$col] = 0x83;
			    $data['cell_data'][$row][$col] = $s;
			   }
			   $data_ok = true;
			   break;

			  // BOOLEAN
			  case 1:
				$data['cell_type'][$row][$col] = 4;
				$data['cell_data'][$row][$col] = (boolean)(ord($record[8]));
				$data_ok = true;
				break;

			  // ERROR
			  case 2:
				$data['cell_type'][$row][$col] = 5;
				$data['cell_data'][$row][$col] = (int)(ord($record[8]));
				$data_ok = true;
				break;

			  // BLANK
			  case 3:
				$data['cell_type'][$row][$col] = 7;
				$data_ok = true;
				break;

			 }
			} else {

			 // IEEE
			 $data['cell_type'][$row][$col] = 1;
			 $data['cell_data'][$row][$col] = $this->ieee(substr($record,6,8));
			 $data_ok = true;
                        }

			if( $data_ok ) $data['cell_xf'][$row][$col] = $xf;
			break;

		  // LABELSST
		  case 0x00fd:
			if( strlen($record) < 0x0a ) return 1;
			$row = ord($record[0])|(ord($record[1])<<8);
			$col = ord($record[2])|(ord($record[3])<<8);
			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $col ) $data['last_col'] = $col;

			if( $no_read ) {
			  if( isset($data['rofs'][$row]) &&
			      !isset($data['fcofs'][$row]) ) {
				$data['fcofs'][$row] = $this->book_offset;
			  }
			  if( !isset($data['lc'][$row]) ||
				($data['lc'][$row] < $col) )
					$data['lc'][$row] = $col;
			  break;
			}

			$data['cell_type'][$row][$col] = 3;
			$data['cell_data'][$row][$col] = 16777216*ord($record[9])+(ord($record[6])|(ord($record[7])<<8)|(ord($record[8])<<16));
			$data['cell_xf'][$row][$col] = ord($record[4])|(ord($record[5])<<8);

			break;

		default:
			break;
	  }
	  return 0;
	}

	function explore_worksheet($sheet) {

		$data = array('last_row'=>-1,'last_col'=>-1);

		if( !isset($this->ws_offsets[$sheet]) )
			return $data;

		$this->file_seek($this->ws_offsets[$sheet]);

		if( (($this->file_getRecordType() & 0xFF) != 0x09) ||
		    (($record = $this->file_getRecord()) === false) )
			return 1;

		$wtype = ord($record[2])|(ord($record[3])<<8);
		if( $wtype != 0x0010 )
			return $data;

		$merged = array();

		$defcolwidth = false;
		$last_row_data_ofs = false;

		while( ($record_type = $this->file_getRecordType()) != 0x0a ) {

		 if( $record_type === false )
			return 1;

		 if( ($record = $this->file_getRecord()) === false )
			return 1;

		 switch( $record_type ) {

		  // COLINFO
		  case 0x007d:
			if( strlen($record) < 10 ) return 1;
			$fc = ord($record[0])|(ord($record[1])<<8);
			$lc = ord($record[2])|(ord($record[3])<<8);
			$width = ord($record[4])|(ord($record[5])<<8);
			$xf = ord($record[6])|(ord($record[7])<<8);
			$opts = ord($record[8])|(ord($record[9])<<8);
			$hidden = (($opts & 1)==1);
			$level = ($opts & 0x0700) >> 8;
			for( $i=$fc; $i<=$lc; $i++ ) {
				if( $hidden ) {
					$data['column_hidden'][$i] = true;
				}
				if( $level > 0 ) {
					$data['column_level'][$i] = $level;
				}
				if( !$hidden && ($level == 0) )
					$data['column_width'][$i] = $width;
				$data['column_xf'][$i] = $xf;
			}

			if( ($data['last_col'] < $lc) &&
			    isset($this->xf['bgcolor'][$xf]) &&
			    isset($this->palette[$this->xf['bgcolor'][$xf]]) )
				$data['last_col'] = $lc;

			break;

		  // STANDARDWIDTH
		  case 0x0099:
			$defcolwidth = 292.5*(ord($record[0])|(ord($record[1])<<8));
			break;

		  // DEFCOLWIDTH
		  case 0x0055:
			if( $defcolwidth === false ) {
			  $defcolwidth = 292.5*(ord($record[0])|(ord($record[1])<<8));
			}
			break;

		  // DEFAULTROWHEIGHT
		  case 0x0225:
			$data['defrowheight'] = ord($record[2])|(ord($record[3])<<8);
			break;

		  // MERGEDCELLS
		  case 0x00e5:
			$mgsz = strlen($record);
			if( $mgsz < 2 ) return 1;
			$cells = ord($record[0])|(ord($record[1])<<8);
			if( $mgsz < 2+8*$cells ) return 1;

			$n = count($merged);
			for( $i=0; $i<$cells; $i++ ) {
			 $merged[$n+$i]['fr'] = ord($record[2+8*$i])|(ord($record[3+8*$i])<<8);
			 $merged[$n+$i]['lr'] = ord($record[4+8*$i])|(ord($record[5+8*$i])<<8);
			 $merged[$n+$i]['fc'] = ord($record[6+8*$i])|(ord($record[7+8*$i])<<8);
			 $merged[$n+$i]['lc'] = ord($record[8+8*$i])|(ord($record[9+8*$i])<<8);
			}

			break;

		  // ROWINFO
		  case 0x0208:
			if( strlen($record) < 16 ) return 1;
			$row = ord($record[0])|(ord($record[1])<<8);
			$lc = (ord($record[4])|(ord($record[5])<<8)) - 1;
			if( $data['last_row'] < $row ) $data['last_row'] = $row;
			if( $data['last_col'] < $lc ) $data['last_col'] = $lc;

			if( $this->memory_safe ) {
				$data['rofs'][$row] = $this->book_offset;
				break;
			}

			$height = ord($record[6])|(ord($record[7])<<8);
			if( !($height & 0x8000) ) {
				if( !isset($data['defrowheight']) ||
				    ($height != $data['defrowheight']) ) {
					$data['row_height'][$row] = $height;
				}
			}
			$opts = 16777216*ord($record[15])+(ord($record[12])|(ord($record[13])<<8)|(ord($record[14])<<16));
			if( $opts & 0x0020 )
				$data['row_hidden'][$row] = true;
			if( $level = ($opts & 0x7) )
				$data['row_level'][$row] = $level;
			if( $opts & 0x80 )
				$data['row_xf'][$row] = ($opts & 0x0fff0000) >> 16;
			break;

		  // WINDOW2
		  case 0x023e:
			if( $this->biff_version < 8 ) {
				if( strlen($record) < 10 ) break;

				if( ord($record[0]) & 0x20 ) {
					unset($this->palette[0x7ffe]);
					unset($data['grid_color']);
					break;
				}

				$c['red'] = ord($record[6]);
				$c['green'] = ord($record[7]);
				$c['blue'] = ord($record[8]);

				$red = dechex($c['red']);
				if( strlen($red) < 2 )
					$red = '0'.$red;
				$green = dechex($c['green']);
				if( strlen($green) < 2 )
					$green = '0'.$green;
				$blue = dechex($c['blue']);
				if( strlen($blue) < 2 )
					$blue = '0'.$blue;

				$c['html'] = '#'.$red.$green.$blue;

				$data['grid_color'] = $c;
			} else {
				if( strlen($record) < 8 ) break;

				if( ord($record[0]) & 0x20 ) {
					unset($data['grid_color']);
					break;
				}

				$i = ord($record[6])|(ord($record[7])<<8);
				if( isset($this->palette[$i]) )
					$data['grid_color'] = $this->palette[$i];
			}
			break;

		  // HLINK
		  case 0x01b8:
			if( !$this->opt['read_link'] ) break;
			$len = strlen($record);
			if( $len < 32 ) return 1;

			$row = ord($record[0])|(ord($record[1])<<8);
			$lrow = ord($record[2])|(ord($record[3])<<8);
			$col = ord($record[4])|(ord($record[5])<<8);
			$lcol = ord($record[6])|(ord($record[7])<<8);
			if( $data['last_row'] < $lrow ) $data['last_row'] = $lrow;
			if( $data['last_col'] < $lcol ) $data['last_col'] = $lcol;

			if( $this->memory_safe ) {
			  for( $i=$row; $i<=$lrow; $i++ ) {
			    for( $j=$col; $j<=$lcol; $j++ ) {
				$data['lofs']["{$j}_{$i}"] = $this->book_offset;
			    }
			  }

			  break;
			}

			if( $this->process_hlink($record_type,$record,$data) === false )
				return 1;
			break;

		  // QUICKTIP
		  case 0x0800:
			if( !$this->opt['read_link'] ) break;
			$len = strlen($record);
			if( $len < 10 ) return 1;

			$qtlen = $len-10;
			if( $qtlen <= 2 ) break;

			if( $this->memory_safe ) {
			  $row = ord($record[2])|(ord($record[3])<<8);
			  $lrow = ord($record[4])|(ord($record[5])<<8);
			  $col = ord($record[6])|(ord($record[7])<<8);
			  $lcol = ord($record[8])|(ord($record[9])<<8);

			  for( $i=$row; $i<=$lrow; $i++ ) {
			    for( $j=$col; $j<=$lcol; $j++ ) {

				$data['qtofs']["{$j}_{$i}"] = $this->book_offset;
			    }
			  }

			  break;
			}

			if( $this->process_hlink($record_type,$record,$data) === false )
				return 1;

			break;

		  // BLANK
		  case 0x0201:

		  // MULBLANK
		  case 0x00be:

		  // BOOLERR
		  case 0x0205:

		  // NUMBER
		  case 0x0203:

		  // RK
		  case 0x027e:

		  // MULRK
		  case 0x00bd:

		  // LABEL or LABEL with formatting info
		  case 0x0204:
		  case 0x00d6:

		  // FORMULA
		  case 0x0006:

		  // LABELSST
		  case 0x00fd:

			$result = $this->process_cell_record($record_type,$record,$data,$this->memory_safe);
			if( $result != 0 ) return $result;

			break;

		  // unknown, unsupported or unused id
		  default:
			break;

		 } // switch ...

		 $this->file_nextRecord();
		}

		if( $defcolwidth !== false ) {
			$data['defcolwidth'] = $defcolwidth;
		}

		if( !$this->memory_safe &&
		    isset($data['row_height']) &&
		    is_array($data['row_height']) &&
		    isset($data['defrowheight']) ) {
			foreach( $data['row_height'] as $key => $val ) {
				if( $val == $data['defrowheight'] ) {
					unset($data['row_height'][$key]);
				}
			}
		}

		for( $n=0; $n<count($merged); $n++ ) {
			if( ($merged[$n]['lr'] < $merged[$n]['fr']) ||
			    ($merged[$n]['lc'] < $merged[$n]['fc']) )
				continue;
		 for( $i=$merged[$n]['fr']; $i<=$merged[$n]['lr']; $i++ )
		  for( $j=$merged[$n]['fc']; $j<=$merged[$n]['lc']; $j++ ) {
			if( ($i==$merged[$n]['fr']) && ($j==$merged[$n]['fc']) ) {
				$data['merged_rows'][$i][$j] = 1+$merged[$n]['lr']-$merged[$n]['fr'];
				$data['merged_columns'][$i][$j] = 1+$merged[$n]['lc']-$merged[$n]['fc'];
			} else {
				$data['cell_type'][$i][$j] = 8;
			}
		  }
		}

		return $data;
	}

	function read_sst($sst_index=false) {

		if( ($sst_index !== false) && isset($this->sst[$sst_index]) )
			return $this->sst[$sst_index];

		$this->file_seek($this->sst_offset);
		if( ($this->file_getRecordType() != 0xfc) ||
		    (($record = $this->file_getRecord()) === false) )
			return 1;

		$count = $this->s2l(substr($record,4,4));
		if( ($sst_index !== false) && ($sst_index >= $count) )
			return 1;

		$sofs = 8;
		$sind = 0;

		if( ($sst_index !== false) && isset($this->esst['portion']) ) {
		  $i = (int)($sst_index - ($sst_index % $this->esst['portion'])) / $this->esst['portion'];
		  if( isset($this->esst['ofs'][$i]) ) {
			$this->file_seek($this->esst['ofs'][$i]);
			$record_type = $this->file_getRecordType();
			if( (($record_type == 0xfc) || ($record_type == 0x3c))
			    &&
			    (($rec = $this->file_getRecord()) !== false) ) {
				$sofs = $this->esst['rofs'][$i] - 4;
				$count -= $i * $this->esst['portion'];
				$sind = $i * $this->esst['portion'];
				$record = $rec;
			} else {
				$this->file_seek($this->sst_offset);
			}
		  }
		}

		while( $count>0 ) {
		  $index = (($sst_index === false) || ($sst_index == $sind));

		  $sz = strlen($record);
		  $str = chr(0);
		  $ln = ord($record[$sofs])|(ord($record[$sofs+1])<<8);

		  $fln = $ln;
		  $uc = ord($record[$sofs+2]) & 1;
		  $rt = 0;
		  $fsz = 0;

		  switch (ord($record[$sofs+2]) & 0x0c) {
		    // Rich-Text with Far-East
		    case 0x0c:
			$rt = ord($record[$sofs+3])|(ord($record[$sofs+4])<<8);
			$fsz = $this->s2l(substr($record,$sofs+5,4));
			if( $sofs+9+$ln*(1+$uc) > $sz )
				$ln = (int)($sz-$sofs-9)/(1+$uc);
			if( $index !== false )
				$str = chr($uc).substr($record,$sofs+9,$ln*(1+$uc));
			$sofs += $ln*(1+$uc)+9;
			break;

		    // Rich-Text
		    case 8:
			$rt = ord($record[$sofs+3])|(ord($record[$sofs+4])<<8);
			if( $sofs+5+$ln*(1+$uc) > $sz )
				$ln = (int)($sz-$sofs-5)/(1+$uc);
			if( $index !== false )
				$str = chr($uc).substr($record,$sofs+5,$ln*(1+$uc));
			$sofs += $ln*(1+$uc)+5;
			break;

		    // Far-East
		    case 4:
			$fsz = $this->s2l(substr($record,$sofs+3,4));
			if( $sofs+7+$ln*(1+$uc) > $sz )
				$ln = (int)($sz-$sofs-7)/(1+$uc);
			if( $index !== false )
				$str = chr($uc).substr($record,$sofs+7,$ln*(1+$uc));
			$sofs += $ln*(1+$uc)+7;
			break;

		    // Compressed or uncompressed unicode
		    case 0:
			if( $sofs+3+$ln*(1+$uc) > $sz )
				$ln = (int)($sz-$sofs-3)/(1+$uc);
			if( $index !== false )
				$str = chr($uc).substr($record,$sofs+3,$ln*(1+$uc));
			$sofs += $ln*(1+$uc)+3;
			break;
		  } // switch

		  $fln -= $ln;

		  if( $fln > 0 ) {

		    if( $sofs < $sz ) return 1;

		    while( $fln > 0 ) {

			$this->file_nextRecord();
			if( ($this->file_getRecordType() != 0x3c) ||
			    (($record = $this->file_getRecord()) === false) )
				return 1;

			$sz = strlen($record);
			$sofs = 0;

			$uc2 = ord($record[$sofs]) & 1;
			if( $index !== false ) {
				if( ($uc2==1) && ($uc==0) ) {
					$s = chr(1);
					for( $i=1; $i<strlen($str); $i++ )
						$s .= $str[$i].chr(0);
					$str = $s;
				}
			}

			$ln = $fln;
			if( $ln*(1+$uc2) > $sz-1 )
				$ln = (int)($sz-1)/(1+$uc2);

			if( $index !== false )
				$s = substr($record,$sofs+1,$ln*(1+$uc2));

			$sofs += $ln*(1+$uc2)+1;

			if( ($uc==1) && ($uc2==0) ) {
				if( $index !== false ) {
					$s2 = '';
					for( $i=0; $i<strlen($s); $i++ )
						$s2 .= $s[$i].chr(0);
					$s = $s2;
				}
				$uc2 = 1;
			}

			$uc = $uc2;
			$fln -= $ln;
			if( $index !== false )
				$str .= $s;
		    }
		  }

		  if( $index !== false ) {
			if( $sst_index !== false )
				return $str;
			$this->sst[$sind] = $str;
		  }

		  $count--;
		  $sofs += 4*$rt+$fsz;
		  $sind++;

		  if( ($sofs > $sz) && ($count == 0) )
			return 1;

		  if( ($sofs >= $sz) && ($count > 0) ) {
			$this->file_nextRecord();
			if( ($this->file_getRecordType() != 0x3c) ||
			    (($record = $this->file_getRecord()) === false) )
				return 1;

			$sofs -= $sz;
		  }
		} // while

		return 0;
	}

	function Explore_file($filename,$options=array()) {
	 $this->set_options($options);

	 $this->explore_from_file = true;
	 $this->file_handle = false;

	 $fsz = filesize($filename);
	 if( $fsz <= 0x200 )
		return 1;

	 $fh = @fopen ($filename,'rb');
	 if( $fh===false )
		return 1;

	 $this->last_block = (int)(($fsz-1) / 0x200) - 1;

	 $header = fread( $fh, 0x200 );
	 if( strlen($header) != 0x200 ) {
		@fclose($fh);
		return 1;
	 }

	 $file_signature = array(0xd0,0xcf,0x11,0xe0,0xa1,0xb1,0x1a,0xe1);

	 for( $i=0; $i<count($file_signature); $i++ )
		if( $file_signature[$i] != ord($header[$i]) ) {
			@fclose($fh);
			return 1;
		}

	 $root_entry_block = $this->s2l(substr($header,0x30,4));
	 $num_fat_blocks = $this->s2l(substr($header,0x2c,4));

	 $this->fat = array();
	 for( $i=0; $i<$num_fat_blocks; $i++ ) {
		$fat_block = $this->s2l(substr($header,0x4c+4*$i,4));
		if( fseek( $fh, 0x200+$fat_block*0x200 ) == -1 ) {
			@fclose($fh);
			return 1;
		}
		$fat = fread( $fh, 0x200 );
		if( strlen($fat) != 0x200 ) {
			@fclose($fh);
			return 1;
		}
		for( $j=0; $j<0x80; $j++ )
		 $this->fat[] = $this->s2l(substr($fat,$j*4,4));
	 }

	 if( count($this->fat) < $num_fat_blocks ) {
		@fclose($fh);
		return 1;
	 }

	 $chain = $this->chain($root_entry_block);
	 if( !is_array($chain) ) {
		@fclose($fh);
		return 1;
	 }

	 $this->directory = '';
	 for( $i=0; $i<count($chain); $i++ ) {
		if( fseek( $fh, 0x200+$chain[$i]*0x200 ) == -1 ) {
			@fclose($fh);
			return 1;
		}
		$dir = fread( $fh, 0x200 );
		if( strlen($dir) < 0x200 ) {
			@fclose($fh);
			return 1;
		}
		$this->directory .= $dir;
	 }

	 $this->small_fat = array();
	 $sfc = '';
	 $small_block = $this->s2l(substr($header,0x3c,4));
	 if( $small_block != 0xfeffffff )  {
		$root_entry_index = $this->stream('Root Entry');
		if( $root_entry_index < 0 ) $root_entry_index = 0;
		$sdc_start_block = $this->s2l(substr($this->directory,$root_entry_index*0x80+0x74,4));
		$small_data_chain = $this->chain($sdc_start_block);
		if( !is_array($small_data_chain) ) {
			@fclose($fh);
			return 1;
		}

		$this->last_small_block = count($small_data_chain) * 8;

		$schain = $this->chain($small_block);
		if( !is_array($schain) ) {
			@fclose($fh);
			return 1;
		}

		for( $i=0; $i<count($schain); $i++ ) {
		  if( fseek( $fh, 0x200+$schain[$i]*0x200 ) == -1 ) {
			@fclose($fh);
			return 1;
		  }

		  $small_fat = fread( $fh, 0x200 );
		  if( strlen($small_fat) < 0x200 ) {
			@fclose($fh);
			return 1;
		  }

		  for( $j=0; $j<0x80; $j++ )
		   $this->small_fat[] = $this->s2l(substr($small_fat,$j*4,4));
		}

		for( $i=0; $i<count($small_data_chain); $i++ ) {
		    if( fseek( $fh, 0x200+$small_data_chain[$i]*0x200 ) == -1 ) {
			@fclose($fh);
			return 1;
		    }
		    $sfc .= fread( $fh, 0x200 );
		}
	 }

	 $ibook = $this->stream('Workbook');
	 if( $ibook<0 ) {
		$ibook = $this->stream('Book');
		if( $ibook<0 )
			return 1;
	 }

	 $lbook = $this->s2l(substr($this->directory,$ibook*0x80+0x78,4));
	 if( $lbook == 0 ) {
		@fclose($fh);
		return 1;
	 }

	 $this->bd = '';
	 $this->book_length = $lbook;
	 if( $lbook >= 0x1000 ) {
		$this->book_fat_chain = $this->chain($this->s2l(substr($this->directory,$ibook*0x80+0x74,4)));
		if( !is_array($this->book_fat_chain) ) {
			@fclose($fh);
			return 1;
		}

		if( count($this->book_fat_chain) == 0 ) {
			@fclose($fh);
			return 1;
		}

		$this->book_start_block = $this->book_fat_chain[0];
		for( $i=1; $i<count($this->book_fat_chain); $i++ )
		  if( $this->book_start_block > $this->book_fat_chain[$i] )
		    $this->book_start_block = $this->book_fat_chain[$i];

		$this->file_handle = $fh;
	 } else {
		$chain = $this->small_chain($this->s2l(substr($this->directory,$ibook*0x80+0x74,4)));
		@fclose($fh);
		if( !is_array($chain) ) {
			return 1;
		}

		for( $i=0; $i<count($chain); $i++ )
			$this->bd .= substr($sfc,$chain[$i]*0x40,0x40);

		$this->bd = substr($this->bd,0,$lbook);
		if( strlen($this->bd) != $lbook )
			return 1;

		$this->explore_from_file = false;
		$this->memory_safe = false;
	 }

	 unset($this->fat);
	 unset($this->small_fat);
	 unset($this->directory);
	 unset($header);
	 unset($sfc);

	 $result = $this->explore_workbook($this->memory_safe);
	 if( $this->explore_from_file && !$this->memory_safe ) {
		@fclose($fh);
		$this->file_handle = false;
	 }
	 return $result;
	}

	function Explore($file_data,$options=array()) {
	 $this->set_options($options);

	 $this->explore_from_file = false;
	 $this->memory_safe = false;

	 if( strlen($file_data) <= 0x200 )
		return 1;

	 $this->last_block = (int)((strlen($file_data)-1) / 0x200) - 1;
	 $header = substr($file_data,0,0x200);
	 $fc = substr($file_data,0x200);
	 $file_signature = array(0xd0,0xcf,0x11,0xe0,0xa1,0xb1,0x1a,0xe1);

	 for( $i=0; $i<count($file_signature); $i++ )
		if( $file_signature[$i] != ord($header[$i]) )
			return 1;

	 $root_entry_block = $this->s2l(substr($header,0x30,4));
	 $num_fat_blocks = $this->s2l(substr($header,0x2c,4));

	 $this->fat = array();
	 for( $i=0; $i<$num_fat_blocks; $i++ ) {
		$fat_block = $this->s2l(substr($header,0x4c+4*$i,4));
		$fat = substr($fc,$fat_block*0x200,0x200);
		if( strlen($fat) < 0x200 ) return 1;
		for( $j=0; $j<0x80; $j++ )
		 $this->fat[] = $this->s2l(substr($fat,$j*4,4));
	 }
	 if( count($this->fat) < $num_fat_blocks )
		return 1;

	 $chain = $this->chain($root_entry_block);
	 if( !is_array($chain) )
		return 1;

	 $this->directory = '';
	 for( $i=0; $i<count($chain); $i++ )
		$this->directory .= substr($fc,$chain[$i]*0x200,0x200);

	 $this->small_fat = array();
	 $sfc = '';
	 $small_block = $this->s2l(substr($header,0x3c,4));
	 if( $small_block != 0xfeffffff )  {
		$root_entry_index = $this->stream('Root Entry');
		if( $root_entry_index < 0 ) $root_entry_index = 0;
		$sdc_start_block = $this->s2l(substr($this->directory,$root_entry_index*0x80+0x74,4));
		$small_data_chain = $this->chain($sdc_start_block);
		if( !is_array($small_data_chain) )
			return 1;

		$this->last_small_block = count($small_data_chain) * 8;

		$schain = $this->chain($small_block);
		if( !is_array($schain) )
			return 1;

		for( $i=0; $i<count($schain); $i++ ) {
		 $small_fat = substr($fc,$schain[$i]*0x200,0x200);
		 if( strlen($small_fat) < 0x200 ) return 1;
		 for( $j=0; $j<0x80; $j++ )
		  $this->small_fat[] = $this->s2l(substr($small_fat,$j*4,4));
		}

		for( $i=0; $i<count($small_data_chain); $i++ )
		 $sfc .= substr($fc,$small_data_chain[$i]*0x200,0x200);
	 }

	 $ibook = $this->stream('Workbook');
	 if( $ibook<0 ) {
		$ibook = $this->stream('Book');
		if( $ibook<0 )
			return 1;
	 }

	 $lbook = $this->s2l(substr($this->directory,$ibook*0x80+0x78,4));
	 if( $lbook == 0 )
		return 1;

	 $this->bd = '';
	 $this->book_length = $lbook;

	 if( $lbook >= 0x1000 ) {
		$chain = $this->chain($this->s2l(substr($this->directory,$ibook*0x80+0x74,4)));
		if( !is_array($chain) )
			return 1;

		for( $i=0; $i<count($chain); $i++ )
			$this->bd .= substr($fc,$chain[$i]*0x200,0x200);
	 } else {
		$chain = $this->small_chain($this->s2l(substr($this->directory,$ibook*0x80+0x74,4)));
		if( !is_array($chain) )
			return 1;

		for( $i=0; $i<count($chain); $i++ )
			$this->bd .= substr($sfc,$chain[$i]*0x40,0x40);
	 }
	 $this->bd = substr($this->bd,0,$lbook);
	 if( strlen($this->bd) != $lbook )
		return 1;

	 unset($this->fat);
	 unset($this->small_fat);
	 unset($this->directory);
	 unset($header);
	 unset($fc);
	 unset($sfc);

	 $result = $this->explore_workbook();
	 unset($this->bd);
	 return $result;
	}

	function explore_workbook() {

		$this->book_offset = 0;

		if( (($this->file_getRecordType() & 0xFF) != 0x09) ||
		    (($record = $this->file_getRecord()) === false) )
			return 1;

		if( strlen($record) < 8 ) return 1;

		$vers = $this->file_getRecordType() >> 8;
		if( ($vers!=0) && ($vers!=2) && ($vers!=4) && ($vers!=8) )
			return 2;

		if( $vers!=8 ) {
		 $biff_ver = (int)($ver+4)/2;
		} else {
		 if( strlen($record) < 8 ) return 1;
		 switch( ord($record[0])+256*ord($record[1]) ) {
			case 0x0500:
				if( ord($record[6])+256*ord($record[7]) < 1994 ) {
					$biff_ver = 5;
				} else {
					switch(ord( $record[4])+256*ord($record[5]) ) {
					 case 2412:
					 case 3218:
					 case 3321:
						$biff_ver = 5;
						break;
					 default:
						$biff_ver = 7;
						break;
					}
				}
				break;
			case 0x0600:
				$biff_ver = 8;
				break;
			default:
				return 2;
		 }
		}

		$this->biff_version = $biff_ver;
		if( $this->biff_version < 5 ) return 2;

		$this->worksheet = array();
		$this->sst = array();
		$this->esst = array();
		$this->sst_offset = false;
		$this->xf = array();
		$this->font = array();
		$this->format = array();
		$this->palette = array();
		$this->link = array();

		$this->ws_offsets = array();
		$this->date1904 = 0;
		$sheet_count = 0;

		while( ($record_type = $this->file_getRecordType()) != 0x0a ) {
		 if( $record_type === false )
			return 1;

		 if( ($record_type != 0x3c) && ($record_type != 0xfc) ) {
			if( ($record = $this->file_getRecord()) === false )
				break;
		 }

		 switch( $this->explore_mode ) {
			// read all data
			case 0:

		 switch( $record_type ) {

		  // 1904
		  case 0x0022:
			$this->date1904 = ord($record[0]) & 1;
			break;

		  // FONT
		  case 0x0031:
			if( !$this->opt['read_font'] ) break;

			$ind = count($this->font);
			$this->font[$ind]['height'] = ord($record[0])|(ord($record[1])<<8);
			$this->font[$ind]['italic'] = (boolean)(ord($record[2]) & 2);
			$this->font[$ind]['strike'] = (boolean)(ord($record[2]) & 8);
			$this->font[$ind]['pal_ind'] = (ord($record[4])|(ord($record[5])<<8));
			$this->font[$ind]['bold'] = ord($record[6])|(ord($record[7])<<8);
			$script = ord($record[8]);
			if( $script > 2 ) $script = 0;
			$this->font[$ind]['script'] = $script;
			$this->font[$ind]['underline'] = ord($record[10]);

			if( $this->biff_version < 8 ) {
			 $len = ord($record[14]);
			 $str = substr($record,15,$len);

			 if( strlen($str) != $len )
				return 1;

			 $this->font[$ind]['name'] = chr(0).$str;
			} else {
			 $len = ord($record[14]);

			 if( ord($record[15]) & 1 ) {
			  $str = substr($record,16,$len*2);

			  if( strlen($str) != $len*2 )
				return 1;

			  $this->font[$ind]['name'] = chr(1).$str;
			 } else {
			  $str = substr($record,16,$len);

			  if( strlen($str) != $len )
				return 1;

			  $this->font[$ind]['name'] = chr(0).$str;
			 }
			}

			break;

		  // PALETTE
		  case 0x0092:
			$count = ord($record[0])|(ord($record[1])<<8);
			$pal = array(
				0x000000, 0xFFFFFF, 0xFF0000, 0x00FF00,
				0x0000FF, 0xFFFF00, 0xFF00FF, 0x00FFFF
				);

			for( $i=0; $i<count($pal); $i++ ) {
				$c['html'] = dechex($pal[$i]);

				$sz = strlen($c['html']);
				for( $j=0; $j<6-$sz; $j++ ) {
					$c['html'] = '0'.$c['html'];
				}

				$c['html'] = '#'.$c['html'];

				$c['red'] = ($pal[$i] >> 16) & 0xFF;
				$c['green'] = ($pal[$i] >> 8) & 0xFF;
				$c['blue'] = $pal[$i] & 0xFF;

				$this->palette[] = $c;
			}

			for( $i=0; $i<$count; $i++ ) {
				$c['red'] = ord($record[2+$i*4]);
				$c['green'] = ord($record[3+$i*4]);
				$c['blue'] = ord($record[4+$i*4]);

				$red = dechex($c['red']);
				if( strlen($red) < 2 )
					$red = '0'.$red;
				$green = dechex($c['green']);
				if( strlen($green) < 2 )
					$green = '0'.$green;
				$blue = dechex($c['blue']);
				if( strlen($blue) < 2 )
					$blue = '0'.$blue;

				$c['html'] = '#'.$red.$green.$blue;

				$this->palette[] = $c;
			}

			break;

		  // XF
		  case 0x00e0:
			if( $this->biff_version < 8 ) {
				$used_attr = ord($record[7]);
				$bgcolor = ord($record[8]) & 0x7F;

			  if( $this->opt['read_border'] ) {
				$bord_bs = ((ord($record[10])|(ord($record[11])<<8)) >> 6) & 7;
				$bord_ts = ord($record[12]) & 7;
				$bord_ls = (ord($record[12]) >> 3) & 7;
				$bord_rs = ((ord($record[12])|(ord($record[13])<<8)) >> 6) & 7;
				$bord_bc = ord($record[11]) >> 1;
				$bord_tc = ord($record[13]) >> 1;
				$bord_lc = ord($record[14]) & 0x7f;
				$bord_rc = ((ord($record[14])|(ord($record[15])<<8)) >> 7) & 0x7f;
				$bord_dtl2rb = 0;
				$bord_dbl2rt = 0;
				$bord_ds = 0;
				$bord_dc = 0;
			  }
			} else {
				$used_attr = ord($record[9]);
				$bgcolor = ord($record[18]) & 0x7F;

			  if( $this->opt['read_border'] ) {
				$bord_ls = ord($record[10]) & 0x0f;
				$bord_rs = ord($record[10]) >> 4;
				$bord_ts = ord($record[11]) & 0x0f;
				$bord_bs = ord($record[11]) >> 4;
				$bord_lc = ord($record[12]) & 0x7f;
				$bord_rc = ((ord($record[12])|(ord($record[13])<<8)) >> 7) & 0x7f;
				$bord_tc = ord($record[14]) & 0x7f;
				$bord_bc = ((ord($record[14])|(ord($record[15])<<8)) >> 7) & 0x7f;
				$bord_dtl2rb = (ord($record[13]) >> 6) & 1;
				$bord_dbl2rt = ord($record[13]) >> 7;
				$bord_ds = ((ord($record[16])|(ord($record[17])<<8)) >> 5) & 0x0f;
				$bord_dc = ((ord($record[15])|(ord($record[16])<<8)) >> 6) & 0x7f;
			  }
			}

			if( $this->opt['read_border'] ) {
			  $bord = array();
			  if( isset($this->border_styles[$bord_ls]) )
				$bord_ls = $this->border_styles[$bord_ls];
			  if( isset($this->border_styles[$bord_rs]) )
				$bord_rs = $this->border_styles[$bord_rs];
			  if( isset($this->border_styles[$bord_ts]) )
				$bord_ts = $this->border_styles[$bord_ts];
			  if( isset($this->border_styles[$bord_bs]) )
				$bord_bs = $this->border_styles[$bord_bs];
			  $bord[] = $bord_ls; $bord[] = $bord_rs;
			  $bord[] = $bord_ts; $bord[] = $bord_bs;
			  $bord[] = $bord_lc; $bord[] = $bord_rc;
			  $bord[] = $bord_tc; $bord[] = $bord_bc;
			  $bord[] = $bord_dtl2rb; $bord[] = $bord_dbl2rt;
			  $bord[] = $bord_ds; $bord[] = $bord_dc;
			  $this->xf['border'][] = $bord;
			}

			$this->xf['font'][] = ord($record[0])|(ord($record[1])<<8);
			$this->xf['format'][] = ord($record[2])|(ord($record[3])<<8);
			$this->xf['parent'][] = (ord($record[4])|(ord($record[5])<<8)) >> 4;
			$this->xf['align'][] = ord($record[6]) & 0x7f;

			$this->xf['bgcolor'][] = $bgcolor;
			$style = (ord($record[4]) & 4) >> 2;
			$this->xf['style'][] = $style;

			if( $style ) {
				$used_attr = $used_attr ^ 0xff;
			}
			$this->xf['used_attr'][] = $used_attr;

			break;

		  // EXTSST
		  case 0x00ff:
			if( !$this->memory_safe ) break;

			$this->esst['portion'] = ord($record[0])|(ord($record[1])<<8);
			for( $i=0; $i<(strlen($record)-2) / 8; $i++ ) {
				$absofs = 0x200*$this->book_start_block+$this->s2l(substr($record,2+$i*8,4));
				$rofs = ord($record[6+$i*8])|(ord($record[7+$i*8])<<8);
				$fat_block = (($absofs-$rofs) >> 9);
				$fat_block_ind = false;
				for( $j=0; $j<count($this->book_fat_chain); $j++ ) {
				  if( $this->book_fat_chain[$j] == $fat_block ) {
				    $fat_block_ind = $j;
				    break;
				  }
				}
				if( $fat_block_ind !== false ) {
				  $this->esst['ofs'][$i] = 0x200*$fat_block_ind + (($absofs-$rofs) & 0x1FF);
				  $this->esst['rofs'][$i] = $rofs;
				}

			}
			break;

		  // SST
		  case 0x00fc:
			$this->sst_offset = $this->book_offset;
			if( !$this->memory_safe ) {
				$res = $this->read_sst();
				if( $res != 0 ) return $res;
			}
			break;

		  // FORMAT
		  case 0x041e:
		 	if( !$this->opt['read_format'] ) break;

			$ind = ord($record[0])|(ord($record[1])<<8);

			if( $this->biff_version < 8 ) {
			 $len = ord($record[2]);
			 $str = substr($record,3,$len);

			 if( strlen($str) != $len )
				return 1;

			 $this->format[$ind] = chr(0).$str;
			} else {
			 $len = ord($record[2])|(ord($record[3])<<8);

			 if( ord($record[4]) & 1 ) {
			  $str = substr($record,5,$len*2);

			  if( strlen($str) != $len*2 )
				return 1;

			  $this->format[$ind] = chr(1).$str;
			 } else {
			  $str = substr($record,5,$len);

			  if( strlen($str) != $len )
				return 1;

			  $this->format[$ind] = chr(0).$str;
			 }
			}

			break;
		 } // switch

			// read only sheets info
			case 1:

		 switch( $record_type ) {
		  // BOUNDSHEET
		  case 0x0085:
			$this->ws_offsets[$sheet_count] = $this->s2l(substr($record,0,4));
			$opts = ord($record[4])|(ord($record[5])<<8);

			$hidden = $opts & 3;
			$this->worksheet[$sheet_count]['hidden'] = (($hidden==1) || ($hidden==2));
			$this->worksheet[$sheet_count]['type'] = $opts >> 8;

			if( $this->biff_version < 8 ) {
			 $this->worksheet[$sheet_count]['title'] = chr(0).substr($record,7,ord($record[6]));
			} else {
			 $this->worksheet[$sheet_count]['title'] =
			    chr(ord($record[7]) & 1).
			    substr(
				$record,
				8,
				ord($record[6])*(1+(ord($record[7]) & 1))
			    );
			}

			$sheet_count++;
			break;

		 } // switch
			break;
		} // switch explore mode

		 $this->file_nextRecord();
		} // while

		if( $this->explore_mode != 1 ) {

		for( $i=0; $i<count($this->xf['parent']); $i++ ) {
		 if( $this->xf['style'][$i] ) 
			continue;

		 $parent = $this->xf['parent'][$i];

		 if( $this->opt['read_font'] ) {
		   // FONT
		   $j = $i;
		   $cnt = 0x1000;
		   while( ($this->xf['style'][$j]==0) && 
			!($this->xf['used_attr'][$j] & 8) ) {
			if( ($cnt--) <= 0 ) {
				$j = 0x1000;
				break;
			}

			$parent = $this->xf['parent'][$j];
			if( $parent>=count($this->xf['parent']) ) {
				$j = 0x1000;
				break;
			}

			if( isset($this->xf['parent'][$parent]) ) {
				$j = $parent;
			} else {
				$j = 0x1000;
				break;
			}
		   }

		   if( ($j < 0x1000) && ($this->xf['used_attr'][$j] & 8) ) {
			$this->xf['font'][$i] = $this->xf['font'][$j];
		   } else {
			unset($this->xf['font'][$i]);
		   }
		 }

		 if( $this->opt['read_format'] ) {
		   // FORMAT
		   $j = $i;
		   $cnt = 0x1000;
		   while( ($this->xf['style'][$j]==0) && 
			!($this->xf['used_attr'][$j] & 4) ) {
			if( ($cnt--) <= 0 ) {
				$j = 0x1000;
				break;
			}

			$parent = $this->xf['parent'][$j];
			if( $parent>=count($this->xf['parent']) ) {
				$j = 0x1000;
				break;
			}

			if( isset($this->xf['parent'][$parent]) ) {
				$j = $parent;
			} else {
				$j = 0x1000;
				break;
			}
		   }

		   if( ($j < 0x1000) && ($this->xf['used_attr'][$j] & 4) ) {
			$this->xf['format'][$i] = $this->xf['format'][$j];
		   } else {
			unset($this->xf['format'][$i]);
		   }
		 }

		 if( $this->opt['read_align'] ) {
		   // ALIGN
		   $j = $i;
		   $cnt = 0x1000;
		   while( ($this->xf['style'][$j]==0) && 
			!($this->xf['used_attr'][$j] & 0x10) ) {
			if( ($cnt--) <= 0 ) {
				$j = 0x1000;
				break;
			}

			$parent = $this->xf['parent'][$j];
			if( $parent>=count($this->xf['parent']) ) {
				$j = 0x1000;
				break;
			}

			if( isset($this->xf['parent'][$parent]) ) {
				$j = $parent;break;
			} else {
				$j = 0x1000;
				break;
			}
		   }

		   if( ($j < 0x1000) && ($this->xf['used_attr'][$j] & 0x10) ) {
			$this->xf['align'][$i] = $this->xf['align'][$j];
		   } else {
			unset($this->xf['align'][$i]);
		   }
		 }

		 if( $this->opt['read_border'] ) {
		   // BORDERS
		   $j = $i;
		   $cnt = 0x1000;
		   while( ($this->xf['style'][$j]==0) && 
			!($this->xf['used_attr'][$j] & 0x20) ) {
			if( ($cnt--) <= 0 ) {
				$j = 0x1000;
				break;
			}

			$parent = $this->xf['parent'][$j];
			if( $parent>=count($this->xf['parent']) ) {
				$j = 0x1000;
				break;
			}

			if( isset($this->xf['parent'][$parent]) ) {
				$j = $parent;
			} else {
				$j = 0x1000;
				break;
			}
		   }

		   if( ($j < 0x1000) && ($this->xf['used_attr'][$j] & 0x20) &&
		     isset($this->xf['border'][$j]) ) {
			$this->xf['border'][$i] = $this->xf['border'][$j];
		   } else {
			unset($this->xf['border'][$i]);
		   }
		 }

		 if( $this->opt['read_bgcolor'] ) {
		   // BGCOLOR
		   $j = $i;
		   $cnt = 0x1000;
		   while( ($this->xf['style'][$j]==0) && 
			!($this->xf['used_attr'][$j] & 0x40) ) {
			if( ($cnt--) <= 0 ) {
				$j = 0x1000;
				break;
			}

			$parent = $this->xf['parent'][$j];
			if( $parent>=count($this->xf['parent']) ) {
				$j = 0x1000;
				break;
			}

			if( isset($this->xf['parent'][$parent]) ) {
				$j = $parent;
			} else {
				$j = 0x1000;
				break;
			}
		   }

		   if( ($j < 0x1000) && ($this->xf['used_attr'][$j] & 0x40) ) {
			$this->xf['bgcolor'][$i] = $this->xf['bgcolor'][$j];
		   } else {
			unset($this->xf['bgcolor'][$i]);
		   }
		 }

		}

		unset($this->xf['parent']);
		unset($this->xf['style']);
		unset($this->xf['used_attr']);

		if( count($this->palette)==0 ) {
			$pal = array(
				0x000000, 0xFFFFFF, 0xFF0000, 0x00FF00,
				0x0000FF, 0xFFFF00, 0xFF00FF, 0x00FFFF,
				0x000000, 0xFFFFFF, 0xFF0000, 0x00FF00,
				0x0000FF, 0xFFFF00, 0xFF00FF, 0x00FFFF,
				0x800000, 0x008000, 0x000080, 0x808000,
				0x800080, 0x008080, 0xC0C0C0, 0x808080,
				0x9999FF, 0x993366, 0xFFFFCC, 0xCCFFFF,
				0x660066, 0xFF8080, 0x0066CC, 0xCCCCFF,
				0x000080, 0xFF00FF, 0xFFFF00, 0x00FFFF,
				0x800080, 0x800000, 0x008080, 0x0000FF,
				0x00CCFF, 0xCCFFFF, 0xCCFFCC, 0xFFFF99,
				0x99CCFF, 0xFF99CC, 0xCC99FF, 0xFFCC99,
				0x3366FF, 0x33CCCC, 0x99CC00, 0xFFCC00,
				0xFF9900, 0xFF6600, 0x666699, 0x969696,
				0x003366, 0x339966, 0x003300, 0x333300,
				0x993300, 0x993366, 0x333399, 0x333333
			);

			for( $i=0; $i<count($pal); $i++ ) {
				$c['html'] = dechex($pal[$i]);

				$sz = strlen($c['html']);
				for( $j=0; $j<6-$sz; $j++ ) {
					$c['html'] = '0'.$c['html'];
				}

				$c['html'] = '#'.$c['html'];

				$c['red'] = ($pal[$i] >> 16) & 0xFF;
				$c['green'] = ($pal[$i] >> 8) & 0xFF;
				$c['blue'] = $pal[$i] & 0xFF;

				$this->palette[] = $c;
			}
		}

		for( $i=0; $i<count($this->ws_offsets); $i++ ) {
		  if( ($this->explore_sheet === false) ||
		      ($this->explore_sheet == $i) ) {
			$pws = $this->explore_worksheet($i);
			if( is_array($pws) ) {
				$this->worksheet[$i]['last_col'] = $pws['last_col'];
				$this->worksheet[$i]['last_row'] = $pws['last_row'];
				$this->worksheet[$i]['data'] = $pws;
			} else
				return $pws;
		  } else {
				$this->worksheet[$i]['last_col'] = -1;
				$this->worksheet[$i]['last_row'] = -1;
				$this->worksheet[$i]['data'] = array('last_row'=>-1,'last_col'=>-1);
		  }
		}
		}
		return 0;
	}

}

?>