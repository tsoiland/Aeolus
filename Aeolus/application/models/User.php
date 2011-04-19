<?php

class Application_Model_User
{
	protected $_id;
	protected $_username;
	protected $_role;
	protected $_clock_in_time;
	protected $_clock_out_time;

	public function getId() {
		return $this->_id;
	}
	public function setId($value) {
		$this->_id = $value;
	}
	public function getUsername() {
		return $this->_username;
	}
	public function setUsername($value) {
		$this->_username = $value;
	}
	public function getRole() {
		return $this->_role;
	}
	public function setRole($value) {
		$this->_role = $value;
	}
	public function setClockInTime($value) {
		$this->_clock_in_time = $value;
	}
	public function setClockOutTime($value) {
		$this->_clock_out_time = $value;
	}
}

