<?php

class Application_Model_Incident
{
	protected $title;
	protected $description;
	protected $id;
	protected $latitude;
	protected $longitude;
	protected $verified;
	protected $twitterId;
	protected $sensitive_description;
	protected $creation_time;
	protected $verify_time;
	protected $first_assignment_time;
	protected $close_time;
	protected $status = 0;
	protected $STATUSES = array(0 => 'Open', 1 => 'Closed');

	public function setValuesFromArray($array)
	{
		foreach($array as $key => $value) {
			if($key == 'status')
				$this->setStatus($value);
			else
				$this->$key = $value;
		}
	}
    
	public function getTitle() 
	{
		return $this->title;
	}
	public function setTitle($value) 
	{
		$this->title = $value;
	}
	public function getDescription() 
	{
		return $this->description;
	}
	public function setDescription($value) 
	{
		$this->description = $value;
	}
	public function getId() 
	{
		return $this->id;
	}
	public function setId($value) 
	{
		$this->id = $value;
	}
	public function getLatitude() 
	{
		return $this->latitude;
	}
	public function setLatitude($value) 
	{
		$this->latitude = $value;
	}
	public function getLongitude() 
	{
		return $this->longitude;
	}
	public function setLongitude($value) 
	{
		$this->longitude = $value;
	}
	public function getVerified() 
	{
		return $this->verified;
	}
	public function setVerified($value) 
	{
		$oldvalue = $this->verified;
		$this->verified = $value;
		
		// If the verification status changed, we want to update the verification date, but 
		// this method isn't just called when the status changes. It is also called when a model
		// is getting populated from the db. In the later case $oldvalue won't be empty, so we use 
		// that as a check.
		if($oldvalue === '0' || $oldvalue === '1') {
			if(!$oldvalue && $value) {
				// Changed from false to true.
				$this->setVerifyTime(time());
			} else if($oldvalue && !$value) {
				// Changed from true to false.
				$this->setVerifyTime(0);
			}
		} 
	}
	public function setTwitterId($value)
	{
		$this->twitterId = $value;
	}
	public function getTwitterId()
	{
		return $this->twitterId;
	}
	public function setSensitiveDescription($value)
	{
		$this->sensitive_description = $value;
	}
	public function getSensitiveDescription()
	{
		return ($this->sensitive_description) ? $this->sensitive_description : 'None';
	}
	public function setCreationTime($value)
	{
		$this->creation_time = $value;
	}
	public function getCreationTime()
	{
		return $this->creation_time;
	}
	public function getCreationTimeDisplay()
	{
		return $this->displayTime($this->creation_time);
	}
	public function setVerifyTime($value)
	{
		$this->verify_time = $value;
	}
	public function getVerifyTime()
	{
		return $this->verify_time;
	}
	public function getVerifyTimeDisplay()
	{
		return $this->displayTime($this->verify_time);
	}
	public function setFirstAssignmentTime($value)
	{
		$this->first_assignment_time = $value;
	}
	public function getFirstAssignmentTime()
	{	
		return $this->first_assignment_time;
	}
	public function getFirstAssignmentTimeDisplay()
	{	
		return $this->displayTime($this->first_assignment_time);
	}
	public function setCloseTime($value)
	{
		$this->close_time = $value;
	}
	public function getCloseTime()
	{
		return $this->close_time;
	}
	public function getCloseTimeDisplay()
	{
		return $this->displayTime($this->close_time);
	}
	public function setStatus($value)
	{
		$oldvalue = $this->status;
		$this->status = $value;
		
		// Did the status change?
		if($oldvalue === '0' || $oldvalue === '1') {
			if($oldvalue == 1 && $value != 1)
				$this->setCloseTime(0);
			else if($oldvalue != 1 && $value == 1)
				$this->setCloseTime(time());
		}
	}
	public function getStatusId()
	{
		return $this->status;
	}
	public function getStatusDisplay()
	{
		return $this->STATUSES[$this->status];
	}
	
	private function displayTime($time) {
		if($time) {
			return date('g:i:s a d.m.Y', $time);
		} else {
			return 'None';
		}
	}
}
