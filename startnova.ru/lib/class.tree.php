<?php
class CDBTree {
	
	var $db;
	var $table;
	var $id;

	var $left = 'param_left';
	var $right = 'param_right';
	var $level = 'param_level';

	var $qryParams = '';
	var $qryFields = '';
	var $qryTables = '';
	var $qryWhere = '';
	var $qryGroupBy = '';
	var $qryHaving = '';
	var $qryOrderBy = '';
	var $qryLimit = '';
	var $sqlNeedReset = true;
	var $sql;

	function CDBTree(&$DB, $tableName, $itemId, $fieldNames=array()) {
		if(empty($tableName)) trigger_error("phpDbTree: Unknown table", E_USER_ERROR);
		if(empty($itemId)) trigger_error("phpDbTree: Unknown ID column", E_USER_ERROR);
		$this->db = $DB;
		$this->table = $tableName;
		$this->id = $itemId;
		if(is_array($fieldNames) && sizeof($fieldNames)) 
			foreach($fieldNames as $k => $v)
				$this->$k = $v;
	}

	function getElementInfo($ID) { return $this->getNodeInfo($ID); }
	function getNodeInfo($ID) {
		$this->sql = "SELECT ".$this->left.",".$this->right.",".$this->level." FROM ".$this->table." WHERE ".$this->id."='".$ID."'";
		if(($query=$this->db->query($this->sql)) && ($this->db->num_rows($query) == 1) && ($Data = $this->db->fetch_array($query)))
			return array((int)$Data[$this->left], (int)$Data[$this->right], (int)$Data[$this->level]); 
		else trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);
	}

	function clear($data=array()) {

		// clearing table
		if((!$this->db->query('TRUNCATE '.$this->table)) && (!$this->db->query('DELETE FROM '.$this->table))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		// preparing data to be inserted
		if(sizeof($data)) {
			$fld_names = implode(',', array_keys($data)).',';
			if(sizeof($data)) $fld_values = '\''.implode('\',\'', array_values($data)).'\',';
		}
		$fld_names .= $this->left.','.$this->right.','.$this->level;
		$fld_values .= '1,2,0';

		// inserting new record
		$this->sql = 'INSERT INTO '.$this->table.'('.$fld_names.') VALUES('.$fld_values.')';
		if(!($this->db->query($this->sql))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		return $this->db->insert_id();
	}

	function update($ID, $data) {
		$sql_set = '';
		foreach($data as $k=>$v) $sql_set .= ','.$k.'=\''.addslashes($v).'\'';
		return $this->db->query('UPDATE '.$this->table.' SET '.substr($sql_set,1).' WHERE '.$this->id.'=\''.$ID.'\'');
	}


	function insert($ID, $data) {
		
		if(!(list($leftId, $rightId, $level) = $this->getNodeInfo($ID))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		// preparing data to be inserted
		if(sizeof($data)) {
			$fld_names = implode(',', array_keys($data)).',';
			$fld_values = '\''.implode('\',\'', array_values($data)).'\',';
		}
		$fld_names .= $this->left.','.$this->right.','.$this->level;
		$fld_values .= ($rightId).','.($rightId+1).','.($level+1);
		
		// creating a place for the record being inserted
		if($ID) {
			$this->sql = 'UPDATE '.$this->table.' SET '
				. $this->left.'=IF('.$this->left.'>'.$rightId.','.$this->left.'+2,'.$this->left.'),'
				. $this->right.'=IF('.$this->right.'>='.$rightId.','.$this->right.'+2,'.$this->right.')'
				. 'WHERE '.$this->right.'>='.$rightId;
			if(!($this->db->query($this->sql))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);
		}
		//echo $this->sql . '<br><br>';
		// inserting new record
		$this->sql = 'INSERT INTO '.$this->table.'('.$fld_names.') VALUES('.$fld_values.')';
		if(!($this->db->query($this->sql))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		//echo $this->sql . '<br><br>';
		
		return $this->db->insert_id();
	}


	function insertNear($ID, $data) {
		if(!(list($leftId, $rightId, $level) = $this->getNodeInfo($ID)))
			trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		// preparing data to be inserted
		if(sizeof($data)) {
			$fld_names = implode(',', array_keys($data)).',';
			$fld_values = '\''.implode('\',\'', array_values($data)).'\',';
		}
		$fld_names .= $this->left.','.$this->right.','.$this->level;
		$fld_values .= ($rightId+1).','.($rightId+2).','.($level);

		// creating a place for the record being inserted
		if($ID) {
			$this->sql = 'UPDATE '.$this->table.' SET '
			.$this->left.'=IF('.$this->left.'>'.$rightId.','.$this->left.'+2,'.$this->left.'),'
			.$this->right.'=IF('.$this->right.'>'.$rightId.','.$this->right.'+2,'.$this->right.')'
                               . 'WHERE '.$this->right.'>'.$rightId;
			if(!($this->db->query($this->sql))) trigger_error("phpDbTree error:".$this->db->error(), E_USER_ERROR);
		}

		// inserting new record
		$this->sql = 'INSERT INTO '.$this->table.'('.$fld_names.') VALUES('.$fld_values.')';
		if(!($this->db->query($this->sql))) trigger_error("phpDbTree error:".$this->db->error(), E_USER_ERROR);

		return $this->db->insert_id();
	}


	function delete($ID) {
		if(!(list($leftId, $rightId, $level) = $this->getNodeInfo($ID))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		// Deleting record
		$this->sql = 'DELETE FROM '.$this->table.' WHERE '.$this->id.'=\''.$ID.'\'';
		if(!$this->db->query($this->sql)) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		// Clearing blank spaces in a tree
		$this->sql = 'UPDATE '.$this->table.' SET '
			. $this->left.'=IF('.$this->left.' BETWEEN '.$leftId.' AND '.$rightId.','.$this->left.'-1,'.$this->left.'),'
			. $this->right.'=IF('.$this->right.' BETWEEN '.$leftId.' AND '.$rightId.','.$this->right.'-1,'.$this->right.'),'
			. $this->level.'=IF('.$this->left.' BETWEEN '.$leftId.' AND '.$rightId.','.$this->level.'-1,'.$this->level.'),'
			. $this->left.'=IF('.$this->left.'>'.$rightId.','.$this->left.'-2,'.$this->left.'),'
			. $this->right.'=IF('.$this->right.'>'.$rightId.','.$this->right.'-2,'.$this->right.') '
			. 'WHERE '.$this->right.'>'.$leftId
		;
		if(!$this->db->query($this->sql)) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		return true;
	}


	function deleteAll($ID) {
		if(!(list($leftId, $rightId, $level) = $this->getNodeInfo($ID))) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		// Deleteing record(s)
		$this->sql = 'DELETE FROM '.$this->table.' WHERE '.$this->left.' BETWEEN '.$leftId.' AND '.$rightId;
		if(!$this->db->query($this->sql)) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		// Clearing blank spaces in a tree
		$deltaId = ($rightId - $leftId)+1;
		$this->sql = 'UPDATE '.$this->table.' SET '
			. $this->left.'=IF('.$this->left.'>'.$leftId.','.$this->left.'-'.$deltaId.','.$this->left.'),'
			. $this->right.'=IF('.$this->right.'>'.$leftId.','.$this->right.'-'.$deltaId.','.$this->right.') '
			. 'WHERE '.$this->right.'>'.$rightId
		;
		if(!$this->db->query($this->sql)) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		return true;
	}

	function enumChildrenAll($ID) { return $this->enumChildren($ID, 1, 0); }
	function enumChildren($ID, $start_level=1, $end_level=1) {
		if($start_level < 0) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		// We could use sprintf() here, but it'd be too slow
		$whereSql1 = ' AND '.$this->table.'.'.$this->level;
		$whereSql2 = '_'.$this->table.'.'.$this->level.'+';

		if(!$end_level) $whereSql = $whereSql1.'>='.$whereSql2.(int)$start_level;
		else {
			$whereSql = ($end_level <= $start_level) 
				? $whereSql1.'='.$whereSql2.(int)$start_level
				: ' AND '.$this->table.'.'.$this->level.' BETWEEN _'.$this->table.'.'.$this->level.'+'.(int)$start_level
					.' AND _'.$this->table.'.'.$this->level.'+'.(int)$end_level;
		}

		$this->sql = $this->sqlComposeSelect(array(
			'', // Params
			'', // Fields
			$this->table.' _'.$this->table.', '.$this->table, // Tables
			'_'.$this->table.'.'.$this->id.'=\''.$ID.'\''
				.' AND '.$this->table.'.'.$this->left.' BETWEEN _'.$this->table.'.'.$this->left.' AND _'.$this->table.'.'.$this->right
				.$whereSql
		));

		return $this->db->query($this->sql);
	}


	function enumPath($ID, $showRoot=false) {
		$this->sql = $this->sqlComposeSelect(array(
			'', // Params
			'', // Fields
			$this->table.' _'.$this->table.', '.$this->table, // Tables
			'_'.$this->table.'.'.$this->id.'=\''.$ID.'\''
				.' AND _'.$this->table.'.'.$this->left.' BETWEEN '.$this->table.'.'.$this->left.' AND '.$this->table.'.'.$this->right
				.(($showRoot) ? '' : ' AND '.$this->table.'.'.$this->level.'>0'), // Where
			'', // GroupBy
			'', // Having
			$this->table.'.'.$this->left // OrderBy
		));

		return $this->db->query($this->sql);
	}


	function getParent($ID, $level=1) {
		if($level < 1) trigger_error("phpDbTree error: ".$this->db->error(), E_USER_ERROR);

		$this->sql = $this->sqlComposeSelect(array(
			'', // Params
			'', // Fields
			$this->table.' _'.$this->table.', '.$this->table, // Tables
			'_'.$this->table.'.'.$this->id.'=\''.$ID.'\''
				.' AND _'.$this->table.'.'.$this->left.' BETWEEN '.$this->table.'.'.$this->left.' AND '.$this->table.'.'.$this->right
				.' AND '.$this->table.'.'.$this->level.'=_'.$this->table.'.'.$this->level.'-'.(int)$level // Where
		));

		return $this->db->get_single($this->sql);
	}


	function sqlReset() {
		$this->qryParams = ''; $this->qryFields = ''; $this->qryTables = ''; 
		$this->qryWhere = ''; $this->qryGroupBy = ''; $this->qryHaving = ''; 
		$this->qryOrderBy = ''; $this->qryLimit = '';
		return true;
	}


	function sqlSetReset($resetMode) { $this->sqlNeedReset = ($resetMode) ? true : false; }


	function sqlParams($param='') { return (empty($param)) ? $this->qryParams : $this->qryParams = $param; }
	function sqlFields($param='') { return (empty($param)) ? $this->qryFields : $this->qryFields = $param; }
	function sqlSelect($param='') { return $this->sqlFields($param); }
	function sqlTables($param='') { return (empty($param)) ? $this->qryTables : $this->qryTables = $param; }
	function sqlFrom($param='') { return $this->sqlTables($param); }
	function sqlWhere($param='') { return (empty($param)) ? $this->qryWhere : $this->qryWhere = $param; }
	function sqlGroupBy($param='') { return (empty($param)) ? $this->qryGroupBy : $this->qryGroupBy = $param; }
	function sqlHaving($param='') { return (empty($param)) ? $this->qryHaving : $this->qryHaving = $param; }
	function sqlOrderBy($param='') { return (empty($param)) ? $this->qryOrderBy : $this->qryOrderBy = $param; }
	function sqlLimit($param='') { return (empty($param)) ? $this->qryLimit : $this->qryLimit = $param; }


	function sqlComposeSelect($arSql) {
		$joinTypes = array('join'=>1, 'cross'=>1, 'inner'=>1, 'straight'=>1, 'left'=>1, 'natural'=>1, 'right'=>1);

		$this->sql = 'SELECT '.$arSql[0].' ';
		if(!empty($this->qryParams)) $this->sql .= $this->sqlParams.' ';

		if(empty($arSql[1]) && empty($this->qryFields)) $this->sql .= $this->table.'.'.$this->id;
		else {
			if(!empty($arSql[1])) $this->sql .= $arSql[1];
			if(!empty($this->qryFields)) $this->sql .= ((empty($arSql[1])) ? '' : ',') . $this->qryFields;
		}
		$this->sql .= ' FROM ';
		$isJoin = ($tblAr=explode(' ',trim($this->qryTables))) && (@$joinTypes[strtolower($tblAr[0])]);
		if(empty($arSql[2]) && empty($this->qryTables)) $this->sql .= $this->table;
		else {
			if(!empty($arSql[2])) $this->sql .= $arSql[2];
			if(!empty($this->qryTables)) {
				if(!empty($arSql[2])) $this->sql .= (($isJoin)?' ':',');
				elseif($isJoin) $this->sql .= $this->table.' ';
				$this->sql .= $this->qryTables;
			}
		}
		if((!empty($arSql[3])) || (!empty($this->qryWhere))) {
			$this->sql .= ' WHERE ' . $arSql[3] . ' ';
			if(!empty($this->qryWhere)) $this->sql .= (empty($arSql[3])) ? $this->qryWhere : 'AND('.$this->qryWhere.')';
		}
		if((!empty($arSql[4])) || (!empty($this->qryGroupBy))) {
			$this->sql .= ' GROUP BY ' . $arSql[4] . ' ';
			if(!empty($this->qryGroupBy)) $this->sql .= (empty($arSql[4])) ? $this->qryGroupBy : ','.$this->qryGroupBy;
		}
		if((!empty($arSql[5])) || (!empty($this->qryHaving))) {
			$this->sql .= ' HAVING ' . $arSql[5] . ' ';
			if(!empty($this->qryHaving)) $this->sql .= (empty($arSql[5])) ? $this->qryHaving : 'AND('.$this->qryHaving.')';
		}
		if((!empty($arSql[6])) || (!empty($this->qryOrderBy))) {
			$this->sql .= ' ORDER BY ' . $arSql[6] . ' ';
			if(!empty($this->qryOrderBy)) $this->sql .= (empty($arSql[6])) ? $this->qryOrderBy : ','.$this->qryOrderBy;
		}
		if(!empty($arSql[7])) $this->sql .= ' LIMIT '.$arSql[7];
		elseif(!empty($this->qryLimit)) $this->sql .= ' LIMIT '.$this->qryLimit;

		if($this->sqlNeedReset) $this->sqlReset();

		return $this->sql;
	}



		function moveByStep($ID, $direction="down") {

			$direction = ($direction == "up")?"up":"down";

			$node = $this->db->sql2array('SELECT '.$this->left.', '.$this->right.', '.$this->level.' FROM '.$this->table.' WHERE '.$this->id.' = '.$ID);

			$this->sql = 'SELECT '.$this->id.', '.$this->left.', '.$this->right.', '.$this->level.' FROM '.$this->table.' WHERE '.$this->level.' = '.$node[0][$this->level].' AND ';
			if ($direction == "up") {
				$this->sql .= $this->right.' = '.($node[0][$this->left]-1);
			} else {
				$this->sql .= $this->left.' = '.($node[0][$this->right]+1);
			}

			mysql_query("START TRANSACTION;");
			$res = $this->db->query($this->sql);

			if ($res) mysql_query("COMMIT");
			else {
				mysql_query("ROLLBACK");
				return false;
			}

			if ($this->db->num_rows($res)!=1) {
 
				return false;
			}
			$node2 = $this->db->result2array($res);

			mysql_query("START TRANSACTION;");
			$res = $this->db->query('SELECT '.$this->id.' FROM '.$this->table.' WHERE '.$this->left.' BETWEEN '.$node[0][$this->left].' AND '.$node[0][$this->right]);

			if ($res) mysql_query("COMMIT");
			else {
				mysql_query("ROLLBACK");
				return false;
			}

			$first_group_amount = 0;
			if ($this->db->num_rows($res) < 1) {
				$first_nodes = $this->id.' = '.$ID;
				$first_group_amount = 1;
			} else {
				$first_nodes = $this->id.' IN (';
				$div = "";
					while ($row = $this->db->fetch_array($res)) {
						$first_nodes .= $div.$row[$this->id];
						$first_group_amount++;
						$div = ", ";
				   }
				$first_nodes .= ")";
			}


			mysql_query("START TRANSACTION;");
			$res = $this->db->query('SELECT '.$this->id.' FROM '.$this->table.' WHERE '.$this->left.' BETWEEN '.$node2[0][$this->left].' AND '.$node2[0][$this->right]);

			if ($res) mysql_query("COMMIT");
			else {
				mysql_query("ROLLBACK");
				return false;
			}
			$second_group_amount = 0;
			if ($this->db->num_rows($res) < 1) {
				$second_nodes = $this->id.' = '.$node2[0][$this->id];
				$second_group_amount = 1;
			} else {
				$second_nodes = $this->id.' IN (';
				$div = "";
				while ($row = $this->db->fetch_array($res)) {
				$second_nodes .= $div.$row[$this->id];
				$second_group_amount++;
				$div = ", ";
				}
				$second_nodes .= ")";
			}


			$sql = 'UPDATE '.$this->table.' SET ';
			if ($direction == "up") {
				$f_sql = $this->left.' = '.$this->left.' - '.($second_group_amount*2).', '.$this->right.' = '.$this->right.' - '.($second_group_amount*2);
			} else {
				$f_sql = $this->left.' = '.$this->left.' + '.($second_group_amount*2).', '.$this->right.' = '.$this->right.' + '.($second_group_amount*2);
			}
			if ($direction == "up") {
				$s_sql = $this->left.' = '.$this->left.' + '.($first_group_amount*2).', '.$this->right.' = '.$this->right.' + '.($first_group_amount*2);
			} else {
				 $s_sql = $this->left.' = '.$this->left.' - '.($first_group_amount*2).', '.$this->right.' = '.$this->right.' - '.($first_group_amount*2);
			}
			mysql_query("START TRANSACTION;");
			$ress=$this->db->query($sql.$f_sql." WHERE ".$first_nodes);
			if ($res) mysql_query("COMMIT");
			else {
				mysql_query("ROLLBACK");
				return false;
			}
			mysql_query("START TRANSACTION;");
			$ress=$this->db->query($sql.$s_sql." WHERE ".$second_nodes);
			if ($res) mysql_query("COMMIT");
			else {
				mysql_query("ROLLBACK");
				return false;
			}
		return true;
}  



//--------------------------------------------------INTERVAL FUNCTIONS--------------------------------------------

function _interval_move($i,&$a,&$b,&$c,&$f,&$t,$d) {

  if($t<$b[$i][0])
  { //left from an existing interval
    $this->interval_add($a,$f,$t,$d);
    $c[]=array($f+$d,$t+$d,-$d,__LINE__,$i);
    $f=$t+1;
    return;
  }
  if($b[$i][0]<=$f&&$t<=$b[$i][1])
  { //inside an existing interval
    $d1=$b[$i][2];
    $this->interval_add($a,$f+$d1,$t+$d1,$d);
    $c[]=array($f,$t,-$d1,__LINE__,$i);
    $c[]=array($f+$d,$t+$d,$d1-$d,__LINE__,$i);
    $f=$t+1;
    return;
  }
  if($f<=$b[$i][0]&&$b[$i][0]<=$t&&$t<=$b[$i][1])
  { // intervals are intersected on the left from an existing one
    if($f<$b[$i][0])
    {
      $this->interval_add($a,$f,$b[$i][0]-1,$d);
      $c[]=array($f+$d,$b[$i][0]-1+$d,-$d,__LINE__,$i);
      $f=$b[$i][0];
    }
    $d1=$b[$i][2];
    $this->interval_add($a,$f+$d1,$t+$d1,$d);
    $c[]=array($f,$t,-$d1,__LINE__,$i);
    $c[]=array($f+$d,$t+$d,$d1-$d,__LINE__,$i);
    $f=$t+1;
    return;
  }
  if($f<=$b[$i][0]&&$b[$i][1]<=$t)
  { //an existing interval is inside of the interval being moved
    if($f<$b[$i][0])
    {
      $this->interval_add($a,$f,$b[$i][0]-1,$d);
      $c[]=array($f+$d,$b[$i][0]-1+$d,-$d,__LINE__,$i);
      $f=$b[$i][0];
    }
    $this->interval_add($a,$f+$b[$i][2],$b[$i][1]+$b[$i][2],$d);
    $c[]=array($f,$b[$i][1],-$b[$i][2],__LINE__,$i);
    $c[]=array($f+$d,$b[$i][1]+$d,$b[$i][2]-$d,__LINE__,$i);
    $f=$b[$i][1]+1;
    return;
  }
  if($b[$i][0]<=$f&&$f<=$b[$i][1]&&$b[$i][1]<=$t)
  { //intervals are intersected on the right from an existing one
    $d1=$b[$i][2];
    $this->interval_add($a,$f+$d1,$b[$i][1]+$d1,$d);
    $c[]=array($f,$b[$i][1],-$b[$i][2],__LINE__,$i);
    $c[]=array($f+$d,$b[$i][1]+$d,$d1-$d,__LINE__,$i);
    $f=$b[$i][1]+1;
    return;
  }
}

function interval_add(&$a,$f,$t,$d) { 

  if(!is_array($a)) return false;
  if(!$d||$f>$t) return true;

  $ch_from=$this->interval_search($a,$f);
  if($ch_from===false||$ch_from<0)
    $ch_from=0;
  $ch_to=0;
  for($i=$ch_from;$i<count($a)&&$f<=$t;++$i)
  {
    $ch_to=$i;
    if($t<$a[$i][0])
    {
      array_splice($a,$i,0,array(array($f,$t,$d)));
      $f=$t+1;
      $i++;
      break;
    }
    if($a[$i][0]<=$f&&$t<=$a[$i][1])
    { //add - inside an existing interval
      if($a[$i][0]<$f)
      {
        array_splice($a,$i,0,array(array($a[$i][0],$f-1,$a[$i][2])));
        $i++;
      }
      if($t<$a[$i][1])
        array_splice($a,$i+1,0,array(array($t+1,$a[$i][1],$a[$i][2])));
      $a[$i][0]=$f;
      $a[$i][1]=$t;
      $a[$i][2]+=$d;
      $f=$t+1;
      $i++;
      break;
    }
    if($f<=$a[$i][0]&&$a[$i][0]<=$t&&$t<=$a[$i][1])
    { // intervals are intersected on the left from an existing one
      if($f<$a[$i][0])
      {
        array_splice($a,$i,0,array(array($f,$a[$i][0]-1,$d)));
        $i++;
      }
      if($t<$a[$i][1])
        array_splice($a,$i+1,0,array(array($t+1,$a[$i][1],$a[$i][2])));
      $a[$i][1]=$t;
      $a[$i][2]+=$d;
      $f=$t+1;
      $i++;
      break;
    }
    if($f<=$a[$i][0]&&$a[$i][1]<=$t)
    { //an existing interval is inside of the interval being added
      if($f<$a[$i][0])
      {
        array_splice($a,$i,0,array(array($f,$a[$i][0]-1,$d)));
        $i++;
      }
      $a[$i][2]+=$d;
      $f=$a[$i][1]+1; //A part of added interval left from an existing one
                      //leave for next cycle iteration - it can intersect with
                      //another interval
      continue;
    }
    if($a[$i][0]<=$f&&$f<=$a[$i][1]&&$a[$i][1]<=$t)
    {
      if($a[$i][0]<$f)
      {
        array_splice($a,$i,0,array(array($a[$i][0],$f-1,$a[$i][2])));
        $i++;
      }
      $a[$i][0]=$f;
      $a[$i][2]+=$d;
      $f=$a[$i][1]+1; //A part of added interval left from an existing one
                      //leave for next cycle iteration - it can intersect with
                      //another interval
      continue;
    }
    $ch_from=$i;
  }
  //Add an unadded part of the interval, if available
  if($f<=$t)
  {
    $a[]=array($f,$t,$d);
    $ch_to=count($a);
  }

  //Optimize intervals:
  //  - remove interval, if it is not changed
  for($i=max($ch_from-1,0);$i<min(count($a),$ch_to+1);$i++)
  {
    if(!$a[$i][2])
    {
      array_splice($a,$i,1);
      $i--;
      continue;
    }
    if($i&&$a[$i-1][2]==$a[$i][2]&&$a[$i-1][1]==$a[$i][0]-1)
    {
      $a[$i-1][1]=$a[$i][1];
      array_splice($a,$i,1);
      $i--;
      continue;
    }
  }
  return true;
}

function interval_move(&$a,&$b,$f,$t,$l)
{
  if(!$l||$f==$t) return;

//debug_info('f='.$f.',t='.$t.',l='.$l);

  if($f<$t)
  {
    if($l<0)
    {
      $l=-$l;
      $f=$f-$l+1;
    }

    if($f+$l>$t)
    {
      trigger_error('Can not move interval into its self');
      return;
    }
    $i1_f=$f;
    $i1_t=$f+$l-1;
    $i1_d=$t-$i1_t;

    $i2_f=$f+$l;
    $i2_t=$t;
    $i2_d=-$l;
  }
  else
  {
    if($l<0)
    {
      $l=-$l;
      $f=$f-$l+1;
    }

    $i1_f=$t;
    $i1_t=$f-1;
    $i1_d=$l;

    $i2_f=$f;
    $i2_t=$f+$l-1;
    $i2_d=$t-$f;
  }


  $i=$this->interval_search($b,$i1_f);
  if($i===false||$i<0)
    $i=0;
  $c=array();
  for($i=$i;$i<count($b)&&($i1_f<=$i1_t||$i2_f<=$i2_t);$i++)
  {
    if($i1_f<=$i1_t)
      $this->_interval_move($i,&$a,&$b,&$c,&$i1_f,&$i1_t,$i1_d);
    if($i2_f<=$i2_t)
      $this->_interval_move($i,&$a,&$b,&$c,&$i2_f,&$i2_t,$i2_d);
  }
  //Add an unadded part of the interval, if there is
  if($i1_f<=$i1_t)
  {
    $this->interval_add($a,$i1_f,$i1_t,$i1_d);
    $c[]=array($i1_f+$i1_d,$i1_t+$i1_d,-$i1_d,__LINE__);
  }
  if($i2_f<=$i2_t)
  {
    $this->interval_add($a,$i2_f,$i2_t,$i2_d);
    $c[]=array($i2_f+$i2_d,$i2_t+$i2_d,-$i2_d,__LINE__);
  }
  for($i=0;$i<count($c);$i++)
    $this->interval_add($b,$c[$i][0],$c[$i][1],$c[$i][2]);
}

function interval_search($a,$pos)
{
  if(!is_array($a)) return false;

  $i_count=count($a);
  if(!$i_count) return 0;
  if($a[0][0]>$pos) return -1;
  if($pos>$a[$i_count-1][1]) return count($a);

  $l=0;
  $r=count($a)-1;
  while($l<$r)
  {
    $c=$l+(($r-$l)>>1);
    if($a[$c][0]<=$pos&&$pos<=$a[$c][1]) return $c;
    if($a[$c][0]<$pos)
      $l=$c+1;
    else
      $r=$c-1;
  }
  return $r;
}

function interval_update(&$a,$b,$f,$t,$d)
{
  if(!$d||$f>$t) return;

  $i=$this->interval_search($b,$f);
  if($i===false||$i<0)
    $i=0;
  for($i=$i;$i<count($b)&&$f<=$t;$i++)
  {
    if($t<$b[$i][0])
    { //left from an existing interval
      $this->interval_add($a,$f,$t,$d);
      $f=$t+1;
      break;
    }
    if($b[$i][0]<=$f&&$t<=$b[$i][1])
    { //inside an existing interval
      $d1=$b[$i][2];
      $this->interval_add($a,$f+$d1,$t+$d1,$d);
      $f=$t+1;
      break;
    }
    if($f<=$b[$i][0]&&$b[$i][0]<=$t&&$t<=$b[$i][1])
    { // intervals are intersected on the left from an existing one
      if($f<$b[$i][0])
      {
        $this->interval_add($a,$f,$b[$i][0]-1,$d);
        $f=$b[$i][0];
      }
      $d1=$b[$i][2];
      $this->interval_add($a,$f+$d1,$t+$d1,$d);
      $f=$t+1;
      break;
    }
    if($f<=$b[$i][0]&&$b[$i][1]<=$t)
    { //an existing interval is inside of the interval being updated
      if($f<$b[$i][0])
      {
        $this->interval_add($a,$f,$b[$i][0]-1,$d);
        $f=$b[$i][0];
      }
      $this->interval_add($a,$f+$b[$i][2],$b[$i][1]+$b[$i][2],$d);
      $f=$b[$i][1]+1;
      continue;
    }
    if($b[$i][0]<=$f&&$f<=$b[$i][1]&&$b[$i][1]<=$t)
    { //intervals are intersected on the right from an existing one
      $d1=$b[$i][2];
      $this->interval_add($a,$f+$d1,$b[$i][1]+$d1,$d);
      $f=$b[$i][1]+1;
      continue;
    }
  }
  //Add an unadded part of the interval, if there is
  if($f<=$t)
    $this->interval_add($a,$f,$t,$d);
}

function interval_value($a,$pos)
{
  $p=$this->interval_search($a,$pos);
  if($p===false||$p<0||$p>=count($a)) return 0;
  if($a[$p][0]<=$pos&&$pos<=$a[$p][1]) return $a[$p][2];
  return 0;
}


//----------------------------------------------------------------------------------------------------------------


function tree_interval_sql($a,$field_check,$field_update)
{
  $r=$field_update.'=';
  for($i=0;$i<count($a);$i++)
  {
    if($a{$i}{2}>=0)
      $d='+'.$a{$i}{2};
    else
      $d=$a[$i][2];
    $r.='if('.$field_check.' between '.$a[$i][0]." and ".$a[$i][1].", ".$field_update.$d.",";
  }
  $r.=$field_update.str_repeat(')',count($a));
  return $r;
}


function tree_move($a,$level)
{
  if(empty($a)) return true;
  $q='';
  if(count($level))
    $q.=$this->tree_interval_sql($level,'param_left','param_level').',';
  $s=$this->tree_interval_sql($a,'param_left','param_left');
  $q.=$s.','.str_replace('param_left','param_right',$s);
  $r=true;
  $r=$r&&$this->db->query("
    update
      ".$this->table."
    set
      $q
    where
      param_left<=".$a[count($a)-1][1]." and
      param_right>=".$a[0][0]."
    ");
  if(!$r) return false;
  return true;
}


function move($data,$is_ignore=false)
//$data: array(array('from'=>$id_from,'to' => $id_to,'left' => null|true|false)[,...])
//    left=null - by default: true or false, where is nearer
//$is_ignore - whether to ignore bad move positions and to move good positions
//  true - ignore all items that should be moved into it's child
//  false - return an error if there is a an item that should be moved into it's child
// Return values:
// -1 - internal error
//  0 - ok
//  false - ok, some items have been ignored
//  1 - $data or it's elemets are not arrays
//  2 - $id_from is empty or is not numeric
//  3 - $id_to is empty or is not numeric
//  4 - $id_from==$id_to || $id_to is a child of $id_from; can be ignored
//  5 - $id_from not exists; can be ignored
//  6 - $id_to not exists; can be ignored
//  7 - can not move to root sibling; can be ignored
//  8 - there is no left/right sibling node; can be ignored
//  9 - neither 'left' nor 'to' fields specified.
// 10 - can not move root node. can be ignored
{
  if(!is_array($data))
  {
    trigger_error('mysql_tree_move: $data is not an array');
    return 1;
  }

  $r=$this->db->query("begin");
  if(!$r) return -1;

  $a=array();
  $b=array();
  // Left and right values on the same intervals should be
  // changed by the same differences.

  $level=array(); //intervals for levels

  $has_ignores=false;
  $cache=array();

  for($i=0;$i<count($data);$i++)
  {
    if(empty($data[$i])||!is_array($data[$i]))
    {
      trigger_error("mysql_tree_move: Element is not an array at position ".$i);
      $this->db->query("rollback");
      return 1;
    }
    if(empty($data[$i]['from'])||!is_numeric($data[$i]['from']))
    {
      trigger_error("mysql_tree_move: 'from' not specified or is invalid at position ".$i);
      $this->db->query("rollback");
      return 2;
    }
    $id_from=$data[$i]['from'];

    if(isset($data[$i]['right']))
      $data[$i]['left']=!$data[$i]['right'];

    if(isset($data[$i]['left']))
      $is_left=$data[$i]['left'];
    else
      $is_left=null;

    if(isset($data[$i]['sibling']))
      $is_sibling=$data[$i]['sibling'];
    else
      $is_sibling=false;

    if(empty($cache[$id_from]))
    {
      $r_from=$this->db->query_single("select param_left,param_right,param_level from ".$this->table." where id=".$id_from,true);
      if(!$r_from)
      {
        $has_ignores=true;
        if($is_ignore) continue;
        $this->db->query("rollback");
        return 5;
      }
      $cache[$id_from]=$r_from;
    }
    else
      $r_from=$cache[$id_from];

    if(!$r_from['param_level'])
    {
      $has_ignores=true;
      if($is_ignore) continue;
      $this->db->query("rollback");
      return 10;
    }

    $r_from['param_left_new']=$r_from['param_left']+$this->interval_value($a,$r_from['param_left']);
    $r_from['param_right_new']=$r_from['param_right']+$this->interval_value($a,$r_from['param_right']);
    $r_from['param_level_new']=$r_from['param_level']+$this->interval_value($level,$r_from['param_left']);

    if($is_sibling)
    {
      if(empty($data[$i]['to']))
      {
        if(!isset($is_left))
        {
          trigger_error("mysql_tree_move: neither 'left' nor 'to' fields specified.");
          $this->db->query("rollback");
          return 9;
        }
        if($is_left)
        {
          $r=$this->db->query_single("select * from ".$this->table." where param_right=".($r_from['param_left_new']-1+$this->interval_value($b,$r_from['param_left_new']-1)),true);
          if(!$r||$r['param_level']+$this->interval_value($level,$r['param_left'])!=$r_from['param_level_new'])
          {
            $has_ignores=true;
            if($is_ignore) continue;
            $this->db->query("rollback");
            return 8;
          }
          $cache[$r['id']]=$r;
          $id_to=$r['id'];
        }
        else
        {
          $r=$this->db->query_single("select * from ".$this->table." where param_left=".($r_from['param_right_new']+1+$this->interval_value($b,$r_from['param_right_new']+1)),true);
          if(!$r||$r['param_level']+$this->interval_value($level,$r['param_left'])!=$r_from['param_level_new'])
          {
            $has_ignores=true;
            if($is_ignore) continue;
            $this->db->query("rollback");
            return 8;
          }
          $cache[$r['id']]=$r;
          $id_to=$r['id'];
        }
      }
      else
      {
        if(!is_numeric($data[$i]['to']))
        {
          trigger_error("mysql_tree_move: 'to' is invalid at position ".$i);
          $this->db->query("rollback");
          return 3;
        }
        $id_to=$data[$i]['to'];
      }
    }
    else
    {
      if(empty($data[$i]['to']))
      {
        $r=$this->db->query_single("
          select
            *
          from
            ".$this->table."
          where
            param_left<".$r_from['param_left']."
            param_right>".$r_from['param_right']."
          order by
            param_right
          limit
            1
        ",true);
        if(!$r)
        {
          $has_ignores=true;
          if($is_ignore) continue;
          $this->db->query("rollback");
          return 10;
        }
        $cache[$r['id']]=$r;
        $id_to=$r['id'];
      }
      else
      {
        if(!is_numeric($data[$i]['to']))
        {
          trigger_error("mysql_tree_move: 'to' not specified or is invalid at position ".$i);
          $this->db->query("rollback");
          return 3;
        }
        $id_to=$data[$i]['to'];
      }
    }

    if($id_from==$id_to)
    {
      $has_ignores=true;
      if($is_ignore) continue;
      $this->db->query("rollback");
      return 4;
    }

    if(empty($cache[$id_to]))
    {
      $r_to=$this->db->query_single("select param_left,param_right,param_level from ".$this->table." where id=".$id_to,true);
      if(!$r_to)
      {
        $has_ignores=true;
        if($is_ignore) continue;
        $this->db->query("rollback");
        return 6;
      }
      $cache[$id_to]=$r_to;
    }
    else
      $r_to=$cache[$id_to];

    $r_to['param_left_new']=$r_to['param_left']+$this->interval_value($a,$r_to['param_left']);
    $r_to['param_right_new']=$r_to['param_right']+$this->interval_value($a,$r_to['param_right']);
    $r_to['param_level_new']=$r_to['param_level']+$this->interval_value($level,$r_to['param_left']);

    if($r_from['param_left_new']==$r_to['param_left_new']||$r_from['param_right_new']==$r_to['param_right_new'])
    {
      trigger_error("mysql_tree_move: Tree is invalid in ".$table);
      $this->db->query("rollback");
      return -1;
    }
    if($r_to['param_left_new']>=$r_from['param_left_new']&&$r_to['param_left_new']<=$r_from['param_right_new'])
    {
      $has_ignores=true;
      if($is_ignore) continue;
      $this->db->query("rollback");
      return 4;
    }

    $i_size=$r_from['param_right_new']-$r_from['param_left_new']+1;

    if(!isset($is_left))
      $is_left=
         min(
           abs($r_from['param_left_new']-$r_to['param_left_new']),
           abs($r_from['param_right_new']-$r_to['param_left_new']))<
         min(
           abs($r_from['param_left_new']-$r_to['param_right_new']),
           abs($r_from['param_right_new']-$r_to['param_right_new']));

    if($is_sibling)
    { //insert as sibling
      if(!$r_to['param_level'])
      {
        $has_ignores=true;
        if($is_ignore) continue;
        $this->db->query("rollback");
        return 7;
      }
      $this->interval_update(
        $level,$b,
        $r_from['param_left_new'],
        $r_from['param_right_new'],
        $r_to['param_level_new']-$r_from['param_level_new']);
      if($is_left)
      {
        if($r_from['param_left_new']<$r_to['param_left_new'])
          $this->interval_move($a,$b,$r_from['param_right_new'],$r_to['param_left_new']-1,-$i_size);
        else
          $this->interval_move($a,$b,$r_from['param_right_new'],$r_to['param_left_new'],-$i_size);
      }
      else
      {
        if($r_from['param_right_new']<$r_to['param_right_new'])
          $this->interval_move($a,$b,$r_from['param_left_new'],$r_to['param_right_new'],$i_size);
        else
          $this->interval_move($a,$b,$r_from['param_left_new'],$r_to['param_right_new']+1,$i_size);
      }
    }
    else
    { //insert as child
      $this->interval_update(
        $level,$b,
        $r_from['param_left_new'],
        $r_from['param_right_new'],
        $r_to['param_level_new']-$r_from['param_level_new']+1);
      if($is_left)
      {
        if($r_from['param_left_new']<$r_to['param_left_new'])
          $this->interval_move($a,$b,$r_from['param_left_new'],$r_to['param_left_new'],$i_size);
        else
          $this->interval_move($a,$b,$r_from['param_left_new'],$r_to['param_left_new']+1,$i_size);
      }
      else
      {
        if($r_from['param_right_new']<$r_to['param_right_new'])
          $this->interval_move($a,$b,$r_from['param_right_new'],$r_to['param_right_new']-1,-$i_size);
        else
          $this->interval_move($a,$b,$r_from['param_right_new'],$r_to['param_right_new'],-$i_size);
      }
    }
    if(count($a)>50)
    {
      if(!$this->tree_move($a,$level))
      {
        $this->db->query("rollback");
        return -1;
      }
      $a=array();
      $b=array();
      $level=array();
      $cache=array();
    }
  }
  if(!$this->tree_move($a,$level))
  {
    $this->db->query("rollback");
    return -1;
  }
  if(!$this->db->query("commit")) return -1;
  if($has_ignores) return false;
  return 0;
}


}
?>