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
        if ($this->getRequest()->isPost()) {
	        $form = $this->getForm();
	        
        	// If validation failed, redisplay form. Also the isValid() method is needed to repopulate $form with posted values.
	        if (!$form->isValid($_POST)) {
	            $this->view->form = $form;
	            return $this->render('form');
	        }
	        
	        // Construct and populate the model. getValues() returns an array and we need an object.
	        // Therefore we simply cast it. The @ supresses notices that result from this.
	        $values = (object) $form->getValues();
	        $model = @Application_Model_UserMapper::createAndPopulateModel($values);
	        
	        // Save the model.
	        $mapper = new Application_Model_UserMapper();
	        $mapper->save($model);
	        
	        $this->_helper->flashMessenger()->addMessage('Details Saved');
            $this->_helper->redirector->gotoUrlAndExit('user/index');
     	}
        
        $this->view->form = $this->getForm();
    }

    public function editAction()
    {
        // Get incident id from url.
    	$id = $this->_request->getParam('id');
    	
		if ($this->getRequest()->isPost()) {
	        $form = $this->getForm();
	        
        	// If validation failed, redisplay form. Also the isValid() method is needed to repopulate $form with posted values.
	        if (!$form->isValid($_POST)) {
	            $this->view->form = $form;
	            return $this->render('form');
	        }
	        
	        $values = $form->getValues();
	        $values['id'] = $id;
	        $model = Application_Model_UserMapper::createAndPopulateModelFromArray($values);

	        // Save the model.
	        $mapper = new Application_Model_UserMapper();
	        $mapper->save($model);
	        
	        $this->_helper->flashMessenger()->addMessage('Details Saved');
            $this->_helper->redirector->gotoUrlAndExit('user/view/id/' . $id);
	        
		}
		
    	
		$mapper = new Application_Model_UserMapper();
		$model = $mapper->find($id);
		$data_array = Application_Model_UserMapper::createDataArray($model);
		
		$this->view->form = $this->getForm();
		$this->view->form->populate($data_array);
        $this->view->jsInitParameters = "'edit'";
    }

	public function viewAction()
    {
        // Get incident id from url.
    	$id = $this->_request->getParam('id');
    	
    	// Fetch incident 
        $mapper = new Application_Model_UserMapper();
        $this->view->model = $mapper->find($id);
    }
	
    public function myhomeAction() 
    {
    	// Get incidents
    	$mapper = new Application_Model_IncidentMapper();
    	$id = $this->getLoggedInUser()->getId();
        $this->view->models = $mapper->fetchUsersIncidents($id);
        $this->view->user = $this->getLoggedInUser();
        
    }
    public function clockinAction() 
    {
    	$user = $this->getLoggedInUser();
    	$user->clockIn();
    	$mapper = new Application_Model_UserMapper();
    	$mapper->save($user);
    		
    	$this->_helper->flashMessenger()->addMessage('You were successfully clocked in.');
        $this->_helper->redirector->gotoUrlAndExit('user/myhome');
    }
    public function clockoutAction() 
    {
    	$user = $this->getLoggedInUser();
    	$user->clockOut();
    	$mapper = new Application_Model_UserMapper();
    	$mapper->save($user);
    	
    	$this->_helper->flashMessenger()->addMessage('You were successfully clocked out.');
    	$this->_helper->redirector->gotoUrlAndExit('user/myhome');
    }
    public function deleteAction() 
    {
    	$id = $this->_request->getParam('id');
    	
    	$mapper = new Application_Model_UserMapper();
    	if($mapper->find($id)) {
	    	$mapper->delete($id);
	    	
	    	$this->_helper->flashMessenger()->addMessage("The user id $id is no more.");
    	} else {
    		$this->_helper->flashMessenger()->addMessage("The user id $id couldn't be found.");
    	}
    	$this->_helper->redirector->gotoUrlAndExit('user');
    }
	private function getForm() 
	{
       	return new Application_Form_User();
	}
	
	private function getLoggedInUser()
	{
		$auth = Zend_Auth::getInstance();
        $user = $auth->getStorage()->read();
        $mapper = new Application_Model_UserMapper();
        return $mapper->find($user->id);
	}
}

