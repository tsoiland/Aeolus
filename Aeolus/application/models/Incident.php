<?php

class Application_Model_Incident
{
	protected $_title;
	protected $_description;
	protected $_id;
	protected $_latitude;
	protected $_longitude;
	protected $_verified;
	
	public function __set($name, $value) {
		
	}
	public function __get($name) {
		
	}
	public function getTitle() {
		return $this->_title;
	}
	public function setTitle($value) {
		$this->_title = $value;
	}
	public function getDescription() {
		return $this->_description;
	}
	public function setDescription($value) {
		$this->_description = $value;
	}
	public function getId() {
		return $this->_id;
	}
	public function setId($value) {
		$this->_id = $value;
	}
	public function getLatitude() {
		return $this->_latitude;
	}
	public function setLatitude($value) {
		$this->_latitude = $value;
	}
	public function getLongitude() {
		return $this->_longitude;
	}
	public function setLongitude($value) {
		$this->_longitude = $value;
	}
	public function getVerified() {
		return $this->_verified;
	}
	public function setVerified($value) {
		$this->_verified = $value;
	}
}
