<?php

class IncidentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /*
     * 	List all incidents
     */
    public function indexAction()
    {
    	$mapper = new Application_Model_IncidentMapper();
        $this->view->models = $mapper->fetchAll();
    }
    /*
     * 	List all incidents on map
     */
    public function indexmapAction()
    {
    	$mapper = new Application_Model_IncidentMapper();
        $this->view->models = $mapper->fetchAll();
        
        print '<script type="text/javascript">
        	function addMarkers() {';
        foreach($this->view->models as $model) { ?>
        	addMarker("<?php print $model->getTitle() ?>" ,
			        	<?php print $model->getLatitude() ?>,
			        	<?php print $model->getLongitude() ?>);    
    	<?php }
    	print '}</script>';
    	
    	$this->view->jsInitParameters = "'index'";
    }
    /*
     *  Show form for reporting incidents
     */
    public function addAction()
    {
       	$this->view->form = $this->getForm();
       	$this->view->jsInitParameters = "'add'";
    }
    
    /*
     *  Handle postback from form in addAction()
     */
    public function addpostAction() {
    	// If this request is not actually a POST then go back to the form.
    	if (!$this->getRequest()->isPost()) {
            return $this->_forward('add');
        }
        
        $form = $this->getForm();
    	
        // If validation failed, redisplay form. Also the isValid() method is needed to repopulate $form with posted values.
        if (!$form->isValid($_POST)) {
            $this->view->form = $form;
            return $this->render('form');
        }
        
        // Construct and populate the model.
        $model = new Application_Model_Incident();
        $values = $form->getValues();
        $model->setTitle($values['title']);
        $model->setDescription($values['description']);
        $model->setLatitude($values['latitude']);
        $model->setLongitude($values['longitude']);
        
        // Save the model.
        $mapper = new Application_Model_IncidentMapper();
        $mapper->save($model);
        
        $this->_helper->redirector('addconfirm');
    }
    
    /*
     *  Simply display confirmation. (See view)
     */
	public function addconfirmAction() {
		
	}
	
	/*
	 *  View details about a particular incident
	 */
    public function viewAction()
    {
    	// Get incident id from url.
    	$id = $this->_request->getParam('id');
    	
    	// Fetch incident 
        $mapper = new Application_Model_IncidentMapper();
        $this->view->model = $mapper->find($id);
    }
    
    public function verifyAction()
    {
    	// Get incident id from url.
    	$id = $this->_request->getParam('id');
    	
    	// Fetch incident 
        $mapper = new Application_Model_IncidentMapper();
        $model = $mapper->find($id);
        
        $model->setVerified(TRUE);
        $mapper->save($model);
        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
		$redirector->gotoUrlAndExit("/incident/view/id/$id");
    }

    /*
     *  Construct the form for reporting incidents
     */
	private function getForm() {
		$form = new Zend_Form;
        $form->setAction('addpost')
        	->setMethod('post');
       	$form->addElement('text', 'title', array('label' => 'Title'));
       	$form->addElement('textarea', 'description', array('label' => 'Description'));
       	$form->addElement('hidden', 'longitude');
       	$form->addElement('hidden', 'latitude');
       	$form->addElement('submit', 'login', array('label' => 'Report'));
       	return $form;
	}
}

