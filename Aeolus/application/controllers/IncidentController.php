<?php

class IncidentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$mapper = new Application_Model_IncidentMapper();
        $this->view->models = $mapper->fetchAll();
    }

    public function addAction()
    {
        // action body
    }

    public function viewAction()
    {
    	$id = $this->_request->getParam('id');
        $mapper = new Application_Model_IncidentMapper();
        $this->view->model = $mapper->find($id);
    }


}

