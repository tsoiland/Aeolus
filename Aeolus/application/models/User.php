<?php

class Application_Model_User
{
	protected $_id;
	protected $_username;
	protected $_role;
	protected $_clock_in_time;
	protected $_clock_out_time;
	protected $_password;
	protected $_salt;
	protected $_realname;

	public function getId() 
	{
		return $this->_id;
	}
	public function setId($value) 
	{
		$this->_id = $value;
	}
	public function getUsername() 
	{
		return $this->_username;
	}
	public function setUsername($value) 
	{
		$this->_username = $value;
	}
	public function getRole() 
	{
		return $this->_role;
	}
	public function setRole($value) 
	{
		$this->_role = $value;
	}
	public function getClockInTime()
	{
		return $this->_clock_in_time;
	}
	public function setClockInTime($value) 
	{
		$this->_clock_in_time = $value;
	}
	public function getClockOutTime()
	{
		return $this->_clock_out_time;
	}
	public function setClockOutTime($value) 
	{
		$this->_clock_out_time = $value;
	}
	public function clockIn() 
	{
		$this->_clock_in_time = time();
	}
	
	public function clockOut() 
	{
		$this->_clock_out_time = time();
	}
	
	public function isClockedIn() 
	{
		if ($this->_clock_out_time < $this->_clock_in_time)	{
			return true;
		}
			
		return false;	
	}
	
	public function getClockedInDuration() 
	{
		return (time() - $this->_clock_in_time)/3600;
	}
	
	public function getExhaustionStatus() 
	{
		if ($this->isClockedIn()) {
			return $this->getClockedInDuration();
		}
		return 'Not clocked in';
	}
	public function getSalt() 
	{
		return $this->_salt;
	}
	public function setSalt($value)
	{
		$this->_salt = $value;
	}  
	public function setPassword($value) 
	{
		$config_params = Zend_Registry::get('config_module');
		$salt = $config_params['dfg']['salt'];
		$this->_password = sha1($value.$salt);
	}
	public function getHashedPassword()
	{
		return $this->_password;
	}
	public function getRealName()
	{
		return $this->_realname;
	}
	public function setRealName($value) {
		$this->_realname = $value;
	}
}
