<?php

class UserController extends Zend_Controller_Action
{
	/*
	 *  Lists all users.
	 */
    public function indexAction()
    {
        $mapper = new Application_Model_UserMapper();
        $this->view->models = $mapper->fetchAll();
    }

    /*
     *  Shows, and handles postback for, add user form.
     */
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
	
    /*
     *  Shows and handles postback for edit user form.
     */
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
		
		// Fetch data for form
		$mapper = new Application_Model_UserMapper();
		$model = $mapper->find($id);
		$data_array = Application_Model_UserMapper::createDataArray($model);
		
		// Create, populate and remove password from, form
		$this->view->form = $this->getForm();
		unset($data_array['password']);
		$this->view->form->populate($data_array);
		
		// Signal to javascript component about which map to display
        $this->view->jsInitParameters = "'edit'";
    }

    /*
     *  Displays one incident.
     */
	public function viewAction()
    {
        // Get incident id from url.
    	$id = $this->_request->getParam('id');
    	
    	// Fetch incident 
        $mapper = new Application_Model_UserMapper();
        $this->view->model = $mapper->find($id);
    }
	
    /*
     *  Displays a users personal screen.
     */
    public function myhomeAction() 
    {
    	// Get incidents
    	$mapper = new Application_Model_IncidentMapper();
    	$id = $this->getLoggedInUser()->getId();
        $this->view->models = $mapper->fetchUsersIncidents($id);
        $this->view->user = $this->getLoggedInUser();
        
    }
    
    /*
     *  Clock currently logged in user in.
     */
    public function clockinAction() 
    {
    	// Get the user
    	$user = $this->getLoggedInUser();
    	
    	// Update and save
    	$user->clockIn();
    	$mapper = new Application_Model_UserMapper();
    	$mapper->save($user);

    	// Flash and redirect
    	$this->_helper->flashMessenger()->addMessage('You were successfully clocked in.');
        $this->_helper->redirector->gotoUrlAndExit('user/myhome');
    }
    
    /*
     *  Clock currently logged in user out.
     */
    public function clockoutAction() 
    {
    	// Get the user
    	$user = $this->getLoggedInUser();
    	
    	// Update and save
    	$user->clockOut();
    	$mapper = new Application_Model_UserMapper();
    	$mapper->save($user);
    	
    	// Flash and redirect
    	$this->_helper->flashMessenger()->addMessage('You were successfully clocked out.');
    	$this->_helper->redirector->gotoUrlAndExit('user/myhome');
    }
    
    /*
     *  Delete a user.
     */
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
    
    /*
     *  Creation method for user form.
     */
	private function getForm() 
	{
       	return new Application_Form_User();
	}
	
	/*
	 *  Returns the logged in user.
	 */
	private function getLoggedInUser()
	{
		$auth = Zend_Auth::getInstance();
        $user = $auth->getStorage()->read();
        $mapper = new Application_Model_UserMapper();
        return $mapper->find($user->id);
	}
}

