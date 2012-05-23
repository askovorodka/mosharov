
<?php
//вспомогательный класс
class Session extends db {

	var $db;
	var $session_id;
	function Session($db)
	{
		$this->db = &$db;
	}

	function setSession()
	{
		session_start();
		$session_id = session_id();
		
		$this->session_id = $session_id;
		
		$session = $this->db->get_single("select session_id, date from fw_session2 where session_id = '{$session_id}'");
		if ($session)
		{
			$this->db->query("update fw_session2 set date = now() where session_id = '{$session_id}'");
		}
		else 
		{
			$this->db->query("replace into fw_session2 (session_id, date) values ('{$session_id}', now() )");
		}
		
		$this->db->query("DELETE FROM fw_session2 WHERE date < NOW() - INTERVAL '5' MINUTE");
		
	}
	
	
	function getOnLine()
	{
		$result = $this->db->get_single("select count(*) as count from fw_session2");
		if ($result && $result['count'] > 0)
		{
			return $result['count'];
		}
		else 
		{
			return 0;
		}
	}

	function getSessionID()
	{
		return $this->session_id;
	}
	
}

?>