<?php

class IndexController extends Zend_Controller_Action
{
	/*
	 *  Shows a list of incidents available to the public.
	 */
	public function indexAction()
    {
        $mapper = new Application_Model_IncidentMapper();
        $this->view->models = $mapper->fetchPublicIncidents();
    }
    
    /*
     *  Landing page used for redirects that only needs to show flash message.
     */
	public function emptyAction()
    {
    }
}
