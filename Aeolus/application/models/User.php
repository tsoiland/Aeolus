<?php

class Application_Model_User
{
	protected $id;
	protected $username;
	protected $role;
	protected $clock_in_time;
	protected $clock_out_time;
	protected $password;
	protected $salt;
	protected $realname;
	protected $phone_nr;
	protected $location;

	public function __construct()
	{
		$config_params = Zend_Registry::get('config_module');
		$this->salt = $config_params['dfg']['salt'];
	}
	public function setValuesFromArray($array)
	{
		foreach($array as $key => $value) {
			if($key == 'password')
				$this->setPassword($value);
			else
				$this->$key = $value;
		}
	}
    
	public function getId() 
	{
		return $this->id;
	}
	public function setId($value) 
	{
		$this->id = $value;
	}
	public function getUsername() 
	{
		return $this->username;
	}
	public function setUsername($value) 
	{
		$this->username = $value;
	}
	public function getRole() 
	{
		return $this->role;
	}
	public function setRole($value) 
	{
		$this->role = $value;
	}
	public function getClockInTime()
	{
		return $this->clock_in_time;
	}
	public function setClockInTime($value) 
	{
		$this->clock_in_time = $value;
	}
	public function getClockOutTime()
	{
		return $this->clock_out_time;
	}
	public function setClockOutTime($value) 
	{
		$this->clock_out_time = $value;
	}
	public function clockIn() 
	{
		$this->clock_in_time = time();
	}
	
	public function clockOut() 
	{
		$this->clock_out_time = time();
	}
	
	public function isClockedIn() 
	{
		if ($this->clock_out_time < $this->clock_in_time)	{
			return true;
		}
			
		return false;	
	}
	
	public function getClockedInDuration() 
	{
		return (time() - $this->clock_in_time)/3600;
	}
	
	public function getExhaustionStatus() 
	{
		if ($this->isClockedIn()) {
			return "Clocked in for " . $this->getClockedInDuration() . " hours";
		}
		return 'Not clocked in';
	}
	public function getSalt() 
	{
		return $this->salt;
	}
	public function setSalt($value)
	{
		$this->salt = $value;
	}  
	public function setPassword($value) 
	{
		$this->password = sha1($value.$this->salt);
	}
	public function getHashedPassword()
	{
		return $this->password;
	}
	public function getRealName()
	{
		return $this->realname;
	}
	public function setRealName($value) {
		$this->realname = $value;
	}
	public function getPhoneNr()
	{
		return $this->phone_nr;	
	}
	public function setPhoneNr($value)
	{
		$this->phone_nr = $value;
	}
	public function getLocation()
	{
		return $this->location;	
	}
	public function setLocation($value)
	{
		$this->location = $value;
	}
}
