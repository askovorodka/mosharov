<?php
//вспомогательный класс
class Session extends db {

	var $db;
	function Session($db)
	{
		$this->db = &$db;
	}

	function setSession()
	{
		session_start();
		$session_id = session_id();
		
		$session = $this->db->get_single("select id, date from fw_session where id = '{$session_id}'");
		if ($session)
		{
			$this->db->query("update fw_session set date = now() where id = '{$session_id}'");
		}
		else 
		{
			$this->db->query("insert into fw_session (id, date) values ('{$session_id}', now() )");
		}
		
		$this->db->query("DELETE FROM fw_session WHERE date < NOW() - INTERVAL '15' MINUTE");
		
	}
	
	
	function getOnLine()
	{
		$result = $this->db->get_single("select count(*) as count from fw_session");
		if ($result && $result['count'] > 0)
		{
			return $result['count'];
		}
		else 
		{
			return 0;
		}
	}

}
?>