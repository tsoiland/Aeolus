<?php

class IncidentController extends Zend_Controller_Action
{
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
        
        // Print javascript to add markers to the map.
        print '<script type="text/javascript">function addMarkers() {';
        foreach($this->view->models as $model) { 
        	$title = $model->getTitle();
        	$latitude = ($model->getLatitude()) ? $model->getLatitude(): 'null';
        	$longitude = ($model->getLongitude()) ? $model->getLongitude(): 'null';
        	print "addMarker('$title',$latitude, $longitude);\n" ;   
    	}
    	print '}</script>';
    	
    	$this->view->jsInitParameters = "'index'";
    }
    
    /*
     *  Show form for reporting incidents
     */
	public function addAction()
    {
    	// If request is a POST, handle it. Otherwise, just show the form.
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
	        $model = @Application_Model_IncidentMapper::createAndPopulateModel($values);
	        $model->setVerified(false);
	        
	        // Save the model.
	        $mapper = new Application_Model_IncidentMapper();
	        $mapper->save($model);
	        
	        $this->_helper->flashMessenger()->addMessage('Details Saved');
            $this->_helper->redirector->gotoUrlAndExit('incident/index');
     	}
        
        $this->view->form = $this->getForm();
        
        // Tell the javascript initialization method to show the fresh map without markers.
        $this->view->jsInitParameters = "'add'";
    }
    
    /*
     *  Show form to edit action and handle submit.
     */
	public function editAction() 
	{
		// Get incident id from url.
    	$id = $this->_request->getParam('id');
    	
		// If request is a POST, handle it. Otherwise, just show the form.
		if ($this->getRequest()->isPost()) {
	        $form = $this->getForm();
	        
        	// If validation failed, redisplay form. Also the isValid() method is needed to repopulate $form with posted values.
	        if (!$form->isValid($_POST)) {
	            $this->view->form = $form;
	            return $this->render('form');
	        }
	        
	        // Construct and populate the model.
	        $values = $form->getValues();
	        $values['id'] = $id;
	        $model = Application_Model_IncidentMapper::createAndPopulateModelFromArray($values);

	        // Save the model.
	        $mapper = new Application_Model_IncidentMapper();
	        $mapper->save($model);
	        
	        $this->_helper->flashMessenger()->addMessage('Details Saved');
            $this->_helper->redirector->gotoUrlAndExit('incident/view/id/' . $id);
	        
		}
    	
		// Get data for form
		$mapper = new Application_Model_IncidentMapper();
		$model = $mapper->find($id);
		
		// Prepare for and enter into form.
		$data_array = Application_Model_IncidentMapper::createDataArray($model);
		$this->view->form = $this->getForm();
		$this->view->form->populate($data_array);
		
		// Print javascript to add markers to the map.
        $title = $model->getTitle();
        $latitude = ($model->getLatitude()) ? $model->getLatitude(): 'null';
        $longitude = ($model->getLongitude()) ? $model->getLongitude(): 'null';
        print "'<script type='text/javascript'>
        		function addMarkerForEdit() {
        			addMarker('$title',$latitude, $longitude, true);\n
    			}
    		   </script>";
        // Tell the javascript initialization method to show the edit map with the movable marker.
        $this->view->jsInitParameters = "'edit'";
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
        $model = $mapper->find($id);
        $this->view->model = $model;
        
        // BEWARE - here be javascript hack
		print '<script type="text/javascript">
        	function addMarkerForView() {'; ?>
        	addMarker("<?php print $model->getTitle() ?>" ,
			        	<?php print $model->getLatitude() ?>,
			        	<?php print $model->getLongitude() ?>),
			        	false;    
    	<?php 
    	print '}</script>';
        $this->view->jsInitParameters = "'view'";/**/
    }
    

    public function verifyAction()
    {
    	$this->setVerification(TRUE);
    }

    public function unverifyAction()
    {
    	
    	$this->setVerification(0);
    }
    
    
    public function deleteAction() 
    {
    	$id = $this->_request->getParam('id');
    	
    	$mapper = new Application_Model_IncidentMapper();
    	if($mapper->find($id)) {
	    	$mapper->delete($id);
	    	
	    	$this->_helper->flashMessenger()->addMessage("The incident id $id is no more.");
    	} else {
    		$this->_helper->flashMessenger()->addMessage("The incident id $id couldn't be found.");
    	}
    	$this->_helper->redirector->gotoUrlAndExit('incident');
    }
	
	public function assignpersonnelAction()
	{
		 $incident_id = $this->_request->getParam('id');
    	
		 if ($this->getRequest()->isPost()) {
	        $form = $this->getForm();
	        
        	// If validation failed, redisplay form. Also the isValid() method is needed to repopulate $form with posted values.
	        if (!$form->isValid($_POST)) {
	            $this->view->form = $form;
	            return $this->render('form');
	        }
	        
    		$mapper = new Application_Model_IncidentMapper();
	        foreach ($_POST as $user_id => $assigned) {
				if(is_integer($user_id)) {
					if($assigned) {
						$mapper->assignUserToIncident($user_id, $incident_id);	
					} else {
						$mapper->unAssignUserToIncident($user_id, $incident_id);	
					}
				}
	        }
	        
	        $this->_helper->flashMessenger()->addMessage('Personnel assignment saved.');
            $this->_helper->redirector->gotoUrlAndExit('incident/index');
     	}
        
        $mapper = new Application_Model_UserMapper();
        $users = $mapper->fetchAll();
        
        $mapper = new Application_Model_IncidentMapper();
        
        $data = $mapper->getAssignUserToIncidentFormData($incident_id);
        
		$form = new Application_Form_AssignPersonnel($users);
		$form->setDefaults($data);
		$this->view->form = $form;	
	}
	public function importtwitterAction() 
    {
    	$twitter = new Application_Model_TwitterMapper();
    	$incidents = $twitter->fetchAll();
    	$this->view->number_of_results = count($incidents);
    	
    	$mapper = new Application_Model_IncidentMapper();
    	$twitter->eliminateDuplicates($incidents, $mapper);
    	$this->view->number_of_unique_results = count($incidents);
    	
    	$this->view->number_of_duplicates_eliminated = $this->view->number_of_results - $this->view->number_of_unique_results;
    	$mapper->save($incidents);
    }
    public function rssAction()
    {
		$feed = new Zend_Feed_Writer_Feed;
		$feed->setTitle('Aeolus Incidents');
		$feed->setLink('http://localhost:10088/aeolus/public/');
		$feed->setFeedLink('http://localhost:10088/aeolus/public/incident/rss', 'atom');
		$feed->setDescription('Incidents from the Aeolus disaster management system.');

		$mapper = new Application_Model_IncidentMapper();
        $models = $mapper->fetchAll();
        
        foreach( $models as $model) {
			$entry = $feed->createEntry();
			$entry->setTitle($model->getTitle());
			$entry->setLink("http://localhost:10088/aeolus/public/incident/view/id/".$model->getId());
			$entry->setDescription($model->getDescription());
			$feed->addEntry($entry);
        }	
		$this->view->out = $feed->export('rss');
		
		$this->_helper->layout()->disableLayout();
    }
    
    /*
     *  Construct the form for reporting incidents
     */
	private function getForm() 
	{
       	return new Application_Form_Incident();
	}

    
	private function setVerification($status)
    {
    	// Get incident id from url.
    	$id = $this->_request->getParam('id');
    	
    	// Fetch incident 
        $mapper = new Application_Model_IncidentMapper();
        $model = $mapper->find($id);
        $model->setVerified($status);
        
        $mapper->save($model);
        
        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
		$redirector->gotoUrlAndExit("/incident/view/id/$id");
    }
}

