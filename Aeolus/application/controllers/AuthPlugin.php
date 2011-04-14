<?php
class AuthPlugin extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $loginController = 'auth';
        $loginAction     = '';
        $auth = Zend_Auth::getInstance();
        
        $registry = Zend_Registry::getInstance();
		$acl = $registry->get('acl');
		
        if (!$auth->hasIdentity()) {
     		$isAllowed = $acl->isAllowed('guest',
		                         $request->getControllerName(),
		                         $request->getActionName());
        } else {
        	$identity = $auth->getIdentity();
        	$isAllowed = $acl->isAllowed($identity->role,
		                         $request->getControllerName(),
		                         $request->getActionName());
        }
        
		
		if (!$isAllowed) {
			$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
			$redirector->gotoUrlAndExit('/auth');
		}

    }
}
