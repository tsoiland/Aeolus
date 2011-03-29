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
       	$this->view->form = $this->getForm();
    }
    
    public function addpostAction() {
    	if (!$this->getRequest()->isPost()) {
            return $this->_forward('add');
        }
        $form = $this->getForm();
     	
        $values = $form->getValues();
        
        $model = new Application_Model_Incident();
        $model->setTitle($values['title']);
        $model->setDescription($values['description']);
        $mapper = new Application_Model_IncidentMapper();
        $mapper->save($model);
        
        $this->_helper->redirector('addconfirm');
    }
    
	public function addconfirmAction() {
		
	}
	
    public function viewAction()
    {
    	$id = $this->_request->getParam('id');
        $mapper = new Application_Model_IncidentMapper();
        $this->view->model = $mapper->find($id);
    }

	private function getForm() {
		$form = new Zend_Form;
        $form->setAction('addpost')
        	->setMethod('post');
       	$form->addElement('text', 'title', array('label' => 'Title'));
       	$form->addElement('textarea', 'description', array('label' => 'Description'));
       	$form->addElement('submit', 'login', array('label' => 'Report'));
       	return $form;
	}
}

