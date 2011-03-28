<?php

class Application_Model_Incident
{
	protected $_title;
	protected $_description;
	protected $_id;
	
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
}
