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
		
		Zend_Registry::set('config_module', $this->getOptions());
        
    }
	    
	protected function _configAcl() 
	{
		$acl = new Zend_Acl();
		
		$roles  = array('admin', 'guest', 'field_personnel', 'public_officials');
		
		// Controller script names. You have to add all of them if credential check
		// is global to your application.
		$controllers = array('index', 'auth', 'incident', 'error', 'user', 'report');
		
		foreach ($roles as $role) {
		    $acl->addRole(new Zend_Acl_Role($role));
		}
		foreach ($controllers as $controller) {
		    $acl->add(new Zend_Acl_Resource($controller));
		}
		
		$acl->allow('admin'); 
		//$acl->deny('admin', 'user');
		
		$acl->deny('guest');
		$acl->allow('guest', 'index');
		$acl->allow('guest', 'auth');
		$acl->allow('guest', 'incident', 'rss');
		
		$acl->deny('public_officials');
		$acl->allow('public_officials', 'index');
		$acl->allow('public_officials', 'auth');
		$acl->allow('public_officials', 'incident');
		
		$acl->deny('field_personnel');
		$acl->allow('field_personnel', 'index');
		$acl->allow('field_personnel', 'auth');
		$acl->allow('field_personnel', 'incident', 'index');
		$acl->allow('field_personnel', 'index');
		
		
		// Finally I store whole ACL definition to registry for use
		// in AuthPlugin plugin.
		$registry = Zend_Registry::getInstance();
		$registry->set('acl', $acl);
	}
}

