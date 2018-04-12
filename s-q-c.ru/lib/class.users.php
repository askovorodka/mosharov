<?php 

/*
 * Класс для работы с пользователем
 */
class Users extends db
{
	private $email=null;
	private $password=null;
	private $name = null;
	private $lastname = null;
	private $phone1=null;
	private $phone2=null;
	private $address=null;
	private $city=null;
	private $street=null;
	private $house=null;
	private $post_index=null;
	private $id=null;
	private $rst=null;
	
	
	function __construct()
	{
		parent::db();
	}
	
	function setEmail($val)
	{
		$this->email = $val;
	}
	
	function setPassword($val)
	{
		$this->password = sha1($val);
	}

	function setName($val)
	{
		$this->name = $val;
	}
	
	function setLastname($val)
	{
		$this->lastname = $val;
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
	
	function setCity($val)
	{
		$this->city = $val;
	}
	
	function setStreet($val)
	{
		$this->street = $val;
	}
	
	function setHouse($val)
	{
		$this->house = $val;
	}
	
	function setPostIndex($val)
	{
		$this->post_index = $val;
	}
	
	/**
	 * Регистрация пользователя
	 */
	function register()
	{
		
		parent::query("insert into fw_users (login,mail,name,lastname,phone_1,phone_2,address,city,street,house,post_index,password, status)
		values('{$this->email}','{$this->email}','{$this->name}','{$this->lastname}','{$this->phone1}','{$this->phone2}',
		'{$this->address}','{$this->city}','{$this->street}','{$this->house}','{$this->post_index}','{$this->password}', '1')");
		
		$user_id = mysql_insert_id();
		
		$user = $this->get_user($user_id);
		
		setcookie('fw_login_shop',$user['login']."|".sha1($user['password']),time()+LOGIN_LIFETIME,'/','');
		
		$_SESSION['shopuser'] = $user;
		
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
		return Common::check_auth('user');
	}

	function is_auth_shopuser()
	{
		return Common::check_auth_shop();
	}


	function get_login()
	{
		//echo "select * from fw_users where login='{$this->email}' and password='". $this->password ."'";
		$this->rst = parent::get_single("select * from fw_users where login='{$this->email}' and password='". $this->password ."'");
		if (!empty($this->rst['id']))
		{
			setcookie('fw_login_cookie',$this->rst['login']."|".sha1($this->rst['password']),time()+LOGIN_LIFETIME,'/','');
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

	/*public function save_password($userId, $password){
		parent::query("update fw_users set password='{$password}' where id='{$userId}' ");
	}

	public function save_data($userId, $name, $phone_1, $address, $delivery, $info)
	{
		parent::query("update fw_users set `name`='{$name}', `phone_1`='{$phone_1}', `address`='{$address}', `delivery`='{$delivery}', `info`='{$info}' where id='{$userId}' ");
	}*/


}

?>