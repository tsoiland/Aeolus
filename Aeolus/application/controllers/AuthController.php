<?php

class AuthController extends Zend_Controller_Action
{
	/*
	 * 	Shows, and handles post from, login form.
	 */
    public function indexAction()
    {
        $form = new Application_Form_Login();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if ($this->_process($form->getValues())) {
                    // Login successful
			        $this->_helper->flashMessenger()->addMessage('You were successfully logged in.');
			        $this->_helper->redirector->gotoUrlAndExit('index');
                } else {
                	// Login failed
                	$this->_helper->flashMessenger()->addMessage('You could not be authenticated. Please try again.');
                	$this->_helper->redirector->gotoUrlAndExit('auth');
                }       
            }
        }
        $this->view->form = $form;
    }
    
    /*
	 * 	Does the authentication dirty work for the indexAction() method
	 */
    protected function _process($values)
    {
        // Get our authentication adapter and check credentials
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['username']); 
        $adapter->setCredential($values['password']);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }
        return false;
    }
    
    /*
	 * 	
	 */
    protected function _getAuthAdapter() {
        
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        
        $authAdapter->setTableName('users')
            ->setIdentityColumn('username')
            ->setCredentialColumn('password')
            ->setCredentialTreatment('SHA1(CONCAT(?,salt))');
        
        return $authAdapter;
    }
    
    /*
	 * 	Log the user out of the system.
	 */
    public function logoutAction()
    {
    	// Delete credentials
        Zend_Auth::getInstance()->clearIdentity();
        
        // Redirect to home page
        $this->_helper->flashMessenger()->addMessage('You are now logged out.');
        $this->_helper->redirector->gotoUrlAndExit('index');
    }
}

