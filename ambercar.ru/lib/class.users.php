<?php 

/*
 * Класс для работы с пользователем
 */
class Users extends db
{
	private $email=null;
	private $password=null;
	private $name = null;
	private $phone1=null;
	private $phone2=null;
	private $address=null;
	private $id=null;
	private $rst=null;
	private $tel = null;
	protected $errors = array();
	
	
	function __construct()
	{
		parent::db();
	}
	
	
	public function get_errors()
	{
		return $this->errors;
	} 
	
	function setEmail($val, $with_reg=true)
	{
		$this->email = $val;
		if (!preg_match("~^([a-z0-9_\-\.])+@([a-z0-9_\-\.])+\.([a-z0-9])+$~i", $this->email))
			$this->errors[] = "error_email";
		elseif ($with_reg)
		{ 
			if ($this->get_user_by_email($this->email))
				$this->errors[] = "error_regemail";
		}
	}
	
	function setPassword($val)
	{
		$this->password = sha1($val);
	}

	function setName($val)
	{
		$this->name = $val;
		if (trim($this->name) == "")
			$this->errors[] = "error_username";
	}

	function setTel($val)
	{
		$this->tel = $val;
		$this->tel = preg_replace("/\D/", "", $this->tel);
		if (strlen($this->tel) < 10)
			$this->errors[] = "error_phone";
	}
	
	function setPhone1($val)
	{
		$this->phone1 = $val;
	}
	
	function setPhone2($val)
	{
		$this->phone2 = $val;
	}
	
	function setAddress($val)
	{
		$this->address = $val;
	}
	
	
	/**
	 * Регистрация пользователя
	 */
	function register()
	{
		
		parent::query("insert into fw_users (login,mail,name,tel,address,password, status)
		values('{$this->email}','{$this->email}','{$this->name}','{$this->tel}',
		'{$this->address}','{$this->password}', '1')");
		
		$user_id = mysql_insert_id();
		
		$user = $this->get_user($user_id);
		
		setcookie('shop_login_cookie',$user['mail']."|".sha1($user['password']),time()+LOGIN_LIFETIME,'/','');
		
		$_SESSION['shop_user'] = $user;
		
		return $user;
		
	}


	function get_user($id)
	{
		$this->rst = parent::get_single("select * from fw_users where id=" . $id);
		if ($this->rst)
			return $this->rst;
		else
			return null;
	}
	
	
	function is_auth_user()
	{
		//return Common::check_auth('user');
		return Common::check_user('user');
	}
	
	
	function get_login()
	{
		//echo "select * from fw_users where login='{$this->email}' and password='". $this->password ."'";
		$this->rst = parent::get_single("select * from fw_users where login='{$this->email}' and password='". $this->password ."'");
		if (!empty($this->rst['id']))
		{
			setcookie('shop_login_cookie',$this->rst['login']."|".sha1($this->rst['password']),time()+LOGIN_LIFETIME,'/','');
			$_SESSION['fw_user'] = $this->rst;
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	function get_user_by_email($email)
	{
		$this->rst = parent::get_single("select * from fw_users where mail='{$email}' limit 1");
		if (!empty($this->rst['id']))
			return $this->rst;
		else
			return null;
	}
	
	
}

?>