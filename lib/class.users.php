<?php 

class Users extends db
{
	private $email=null;
	private $password=null;
	private $name = null;
	private $phone1=null;
	private $phone2=null;
	private $address=null;
	
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
		return parent::query("insert into fw_users (login,mail,name,phone_1,phone_2,address,password)
		values('{$this->email}','{$this->email}','{$this->name}','{$this->phone1}','{$this->phone2}',
		'{$this->address}','{$this->password}')");
	}
	
}

?>