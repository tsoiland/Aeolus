<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $mapper = new Application_Model_UserMapper();
        $this->view->models = $mapper->fetchAll();
    }

    public function addAction()
    {
        $this->view->form = $this->getForm();
    }

    public function editAction()
    {
        // action body
    }

	private function getForm() 
	{
       	return new Application_Form_User();
	}
}

