<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        
        $this->_configAcl();
        require_once '/opt/zend/apache2/htdocs/aeolus/application/controllers/AuthPlugin.php';
        $frontController = Zend_Controller_Front::getInstance();
		$frontController->registerPlugin(new AuthPlugin());
        
    }
	    
	protected function _configAcl() 
	{
		$acl = new Zend_Acl();
		
		$roles  = array('admin', 'guest', 'field_personel');
		
		// Controller script names. You have to add all of them if credential check
		// is global to your application.
		$controllers = array('index', 'auth', 'incident', 'error', 'user');
		
		foreach ($roles as $role) {
		    $acl->addRole(new Zend_Acl_Role($role));
		}
		foreach ($controllers as $controller) {
		    $acl->add(new Zend_Acl_Resource($controller));
		}
		
		// Here comes credential definiton for admin user.
		$acl->allow('admin'); // Has access to everything.
		
		// Here comes credential definition for normal user.
		$acl->allow('guest'); // Has access to everything...
		$acl->deny('guest', 'incident'); // ... except the admin controller.
		$acl->deny('guest', 'user');
		
		// Finally I store whole ACL definition to registry for use
		// in AuthPlugin plugin.
		$registry = Zend_Registry::getInstance();
		$registry->set('acl', $acl);
	}
}

