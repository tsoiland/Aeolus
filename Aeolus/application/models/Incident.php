<?php

class Application_Model_Incident
{
	protected $_title;
	protected $_description;
	protected $_id;
	protected $_latitude;
	protected $_longitude;
	protected $_verified;
	protected $_twitterId;
	protected $_sensitiveDescription;
	protected $_verify_time;
	protected $_first_assignment_time;
	protected $_close_time;
	protected $_status;
	protected $_STATUSES = array(0 => 'Open', 1 => 'Closed');
	
	public function __set($name, $value) 
	{
		
	}
	public function __get($name) 
	{
		
	}
	public function getTitle() 
	{
		return $this->_title;
	}
	public function setTitle($value) 
	{
		$this->_title = $value;
	}
	public function getDescription() 
	{
		return $this->_description;
	}
	public function setDescription($value) 
	{
		$this->_description = $value;
	}
	public function getId() 
	{
		return $this->_id;
	}
	public function setId($value) 
	{
		$this->_id = $value;
	}
	public function getLatitude() 
	{
		return $this->_latitude;
	}
	public function setLatitude($value) 
	{
		$this->_latitude = $value;
	}
	public function getLongitude() 
	{
		return $this->_longitude;
	}
	public function setLongitude($value) 
	{
		$this->_longitude = $value;
	}
	public function getVerified() 
	{
		return $this->_verified;
	}
	public function setVerified($value) 
	{
		$this->_verified = $value;
		if($value) 
			$this->setVerifyTime(time());
		else if($value == null)
			print "value is null";
		else
			$this->setVerifyTime(0);
		//die(print_r($this,1));
	}
	public function setTwitterId($value)
	{
		$this->_twitterId = $value;
	}
	public function getTwitterId()
	{
		return $this->_twitterId;
	}
	public function setSensitiveDescription($value)
	{
		$this->_sensitiveDescription = $value;
	}
	public function getSensitiveDescription()
	{
		return ($this->_sensitiveDescription) ? $this->_sensitiveDescription : 'None';
	}
	public function setVerifyTime($value)
	{
		$this->_verify_time = $value;
	}
	public function getVerifyTime()
	{
		return $this->_verify_time;
	}
	public function getVerifyTimeDisplay()
	{
		return $this->displayTime($this->_verify_time);
	}
	public function setFirstAssignmentTime($value)
	{
		$this->_first_assignment_time = $value;
	}
	public function getFirstAssignmentTime()
	{	
		return $this->_first_assignment_time;
	}
	public function getFirstAssignmentTimeDisplay()
	{	
		return $this->displayTime($this->_first_assignment_time);
	}
	public function setCloseTime($value)
	{
		$this->_close_time = $value;
	}
	public function getCloseTime()
	{
		return $this->_close_time;
	}
	public function getCloseTimeDisplay()
	{
		return $this->displayTime($this->_close_time);
	}
	public function setStatus($value)
	{
		$this->_status = $value;
	}
	public function getStatusId()
	{
		return $this->_status;
	}
	public function getStatusDisplay()
	{
		return $this->_STATUSES[$this->_status];
	}
	
	private function displayTime($time) {
		if($time) {
			return date('g:h:s a d.m.Y', $time);
		} else {
			return 'None';
		}
	}
}
