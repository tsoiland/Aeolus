<?php

class Application_Form_AssignPersonnel extends Zend_Form
{
	private $_users;
	public function __construct($users)
	{
		$this->_users = $users;
		parent::__construct();
	}
    public function init()
    {
    	$this->setMethod('post');
    	foreach($this->_users as $user) {
       		$this->addElement('checkbox', $user->getId(), array('label' => $user->getUsername()));
        }
       	$this->addElement('submit', 'assign', array('label' => 'Update assignment'));
    }

}

