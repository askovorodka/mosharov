<?php

class db {
	var $link;
	var $db;
	var $host, $user, $pass;
	var $result;

	function db($db=DB_NAME, $host=DB_HOST, $user=DB_USER, $pass=DB_PASS) {
		$this->db = $db; $this->host = $host; $this->user = $user; $this->pass = $pass;
		if($this->link = mysql_connect($host,$user,$pass)) {
			mysql_query("SET NAMES cp1251");
			mysql_query("SET SESSION group_concat_max_len = 1058576");
			return mysql_select_db($db, $this->link);
		}
		else $this->error();
	}

	function transaction_start() {
		$this->result = mysql_query("START TRANSACTION", $this->link);
		if (!$this->result) $this->error();
		else return $this->result;
	}

	function transaction_commit() {
		$this->result = mysql_query("COMMIT", $this->link);
		if (!$this->result) $this->error();
		else return $this->result;
	}
	
	function transaction_rollback() {
		$this->result = mysql_query("ROLLBACK", $this->link);
		if (!$this->result) $this->error();
		else return $this->result;
	}
	
	function query($sql,$show='0') {	
		if(!$this->link) $this->error();
		if ($show != '0') echo "<p>$sql</p>\n";
		$this->result = mysql_query($sql, $this->link);
		$_SESSION['db_connections']++;
		if (!$this->result) $this->error();
		else return $this->result;
	}

	function get_all($sql,$show='0') {
		if(!$this->link) $this->error();
		if ($show != '0') echo "<p>$sql</p>\n";
		$this->result = mysql_query($sql);
		$this->content = array();
		if (!$this->result) $this->error();
		while ($this->arr = mysql_fetch_assoc($this->result)) {
			$this->content[] = $this->arr;
		}
		$_SESSION['db_connections']++;
		return $this->content;
	}
	
	function get_single($sql,$show='0') {
		if(!$this->link) $this->error();
		if ($show != '0') echo "<p>$sql</p>\n";
		$this->result = mysql_query($sql);
		$this->content = array();
		if (!$this->result) $this->error();
		$this->content = mysql_fetch_assoc($this->result);
		$_SESSION['db_connections']++;
		return $this->content;
	}

	function error() {
		die("<center><font color=red>Query failed!</font></center> MySQL answer: ".mysql_error($this->link)."<br><br><center><a href=javascript:history.back()>Back</a></center>");
	}
	
	function db_close() {
		mysql_close($this->link);
	}
	
	
/* -------------------DBTREE FUNCTIONS -----------------*/
	
function query_single($q,$assoc=false) {
  $r=$this->query($q);
  if(!$r) return false;
  if(!mysql_num_rows($r))
  {
    mysql_free_result($r);
    return false;
  }
  if($assoc)
  {
    $f=mysql_fetch_assoc($r);
    mysql_free_result($r);
    return $f;
  }
  else
  {
    $f=mysql_fetch_row($r);
    mysql_free_result($r);
    if(count($f)>1)
      return $f;
    else
      return $f{0};
  }
}

	function affected_rows() {
		return mysql_affected_rows($this->link);
	}

	function num_rows($q) {
		return mysql_num_rows($q);
	}

	function fetch_array($q, $result_type=MYSQL_ASSOC) {
		return mysql_fetch_array($q, $result_type);
	}

	function fetch_object($q) {
		return mysql_fetch_object($q);
	}

	function data_seek($q, $n) {
		return mysql_data_seek($q, $n);
	}

	function free_result($q) {
		return mysql_free_result($q);
	}

	function insert_id() {
		return mysql_insert_id($this->link);
	}

	function error_die($msg='') {
		die(((empty($msg))?'':$msg.': ').$this->error());
	}

	function sql2var($sql) {
		if((empty($sql)) || (!($query = $this->query($sql)))) return false;
		if($this->num_rows($query) < 1) return false;
		return $this->result2var($query);
	}

	function result2var($q) {
		if(!($Data = $this->fetch_array($q))) return false;
		$this->free_result($q);
		foreach($Data as $k=>$v) $GLOBALS[$k] = $v;
		return true;
	}

	function sql2array($sql, $keyField='') {
		if((empty($sql)) || (!($query = $this->query($sql)))) return false;
		if($this->num_rows($query) < 1) return false;
		return $this->result2array($query, $keyField);
	}

	function result2array($q, $keyField='') {
		$Result = array();
		while($Data = $this->fetch_array($q))
			if(empty($keyField)) $Result[] = $Data;
			else $Result[$Data[$keyField]] = $Data;
		$this->free_result($q);
		return $Result;
	}

	function list_tables() {
		return mysql_list_tables($this->db, $this->link);
	}

	function list_fields($table_name) {
		return mysql_list_fields($this->db, $table_name, $this->link);
	}
}
?>