<?php
class AuthPlugin extends Zend_Controller_Plugin_Abstract
{
	/*
	 *  This method is called on every request, and is used to check the users identification and authentication.
	 */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
    	// Get Zend_Auth
        $auth = Zend_Auth::getInstance();
        
        // Get Zend_Acl
        $registry = Zend_Registry::getInstance();
		$acl = $registry->get('acl');
		
		// Determine what role the user has
        if (!$auth->hasIdentity()) {
     		$role = 'guest';
        } else {
        	$identity = $auth->getIdentity();
        	$role = $identity->role;
        }
        
        // Check permission for this user for this page
        $isAllowed = $acl->isAllowed($role,
		                         $request->getControllerName(),
		                         $request->getActionName());
		
		// If the user does not have permission, redirect and show flash message
		if (!$isAllowed) {
			$flash = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
			$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
			
			if($auth->hasIdentity()) {
	        	$flash->addMessage('You do not have permission to access this page.');
	        	$redirector->gotoUrlAndExit('index/empty');
			} else {
				$flash->addMessage('You need to be logged in to access this page.');
				$redirector->gotoUrlAndExit('auth');
			}			
		}
    }
}
