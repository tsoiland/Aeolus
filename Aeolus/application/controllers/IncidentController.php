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
	        // Get the model.
	        $model = new Application_Model_Incident();
	        
	        // Put values from form in the model.
	        $values = $form->getValues();
	        $model->setValuesFromArray($values);
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
	            return $this->render('edit');
	        }
	        
	        // Get the model.
	        $mapper = new Application_Model_IncidentMapper();
	        $model = $mapper->find($id);
	        
	        // Put values from form in the model.
	        $values = $form->getValues();
	        $model->setValuesFromArray($values);
	        
	        // Save the model.
	        $mapper->save($model);
	        
	        // Flash and redirect.
	        $this->_helper->flashMessenger()->addMessage('Details Saved');
            $this->_helper->redirector->gotoUrlAndExit('incident/view/id/' . $id);
	        
		}
    	
		// Get data for form
		$mapper = new Application_Model_IncidentMapper();
		$model = $mapper->find($id);
		
		// Prepare for and enter into form.
		$model_array = Application_Model_IncidentMapper::createArrayFromModel($model);
		$this->view->form = $this->getForm();
		$this->view->form->populate($model_array);
		
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
    
	/*
	 *  Verify an incident
	 */
    public function verifyAction()
    {
    	$this->setVerification(1);
    }

    /*
     *  Unverify an incident
     */
    public function unverifyAction()
    {
    	$this->setVerification(0);
    }
    
    /* 
     *  Delete an incident
     */
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
    
    /* 
     * Show table of personnel assigned to an incident
     */
    public function viewassignedpersonnelAction()
	{
		$id = $this->_request->getParam('id');
		$mapper = new Application_Model_IncidentMapper();
        $this->view->models = $mapper->getUsersAssignedToIncident($id);
	}
	
	/*
	 *  Display a list of checkboxes for the user to assign personnel to an incident.
	 */
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
	        
	        // Loop through form result and update database
    		foreach ($_POST as $user_id => $assigned) {
				if(is_integer($user_id)) {
					$mapper = new Application_Model_IncidentMapper();
					if($assigned) {
						$mapper->assignUserToIncident($user_id, $incident_id);	
					} else {
						$mapper->unAssignUserToIncident($user_id, $incident_id);	
					}
				}
	        }
	        
	        // Flash and redirect
	        $this->_helper->flashMessenger()->addMessage('Personnel assignment saved.');
            $this->_helper->redirector->gotoUrlAndExit("incident/view/id/$incident_id");
     	}
        
        // Fetch all users
        $mapper = new Application_Model_UserMapper();
        $users = $mapper->fetchAll();
        
        // Fetch data for form
        $mapper = new Application_Model_IncidentMapper();
        $data = $mapper->getAssignUserToIncidentFormData($incident_id);
        
        // Create the form
		$form = new Application_Form_AssignPersonnel($users);
		$form->setDefaults($data);
		$this->view->form = $form;	
	}
	
	/*
	 * Imports new tweets from the #AeolusDMS twitter tag.
	 */
	public function importtwitterAction() 
    {
    	// Fetch incidents from twitter and count them.
    	$twitter = new Application_Model_TwitterMapper();
    	$incidents = $twitter->fetchAll();
    	$this->view->number_of_results = count($incidents);
    	
    	// Delete tweets that has already been imported from the $incidents
    	// array by reference and recount them.
    	$mapper = new Application_Model_IncidentMapper();
    	$twitter->eliminateDuplicates($incidents, $mapper);
    	$this->view->number_of_unique_results = count($incidents);
    	
    	// Save the new incidents in the database
    	$mapper->save($incidents);
    	
    	// Calculate number of duplicates for display.
    	$this->view->number_of_duplicates_eliminated = $this->view->number_of_results - $this->view->number_of_unique_results;
    }
    
    /*
     * Generates an rss feed of incidents.
     */
    public function rssAction()
    {
    	// Create the feed
		$feed = new Zend_Feed_Writer_Feed;
		$feed->setTitle('Aeolus Incidents');
		$feed->setLink('http://localhost:10088/aeolus/public/');
		$feed->setFeedLink('http://localhost:10088/aeolus/public/incident/rss', 'atom');
		$feed->setDescription('Incidents from the Aeolus disaster management system.');

		// Get the incidents
		$mapper = new Application_Model_IncidentMapper();
        $models = $mapper->fetchAll();
        
        // Loop through incidents and create feed entries.
        foreach( $models as $model) {
			$entry = $feed->createEntry();
			$entry->setTitle($model->getTitle());
			$entry->setLink("http://localhost:10088/aeolus/public/incident/view/id/".$model->getId());
			$entry->setDescription($model->getDescription());
			$feed->addEntry($entry);
        }
        // Generate the xml output. It will be printed in the view.	
		$this->view->out = $feed->export('rss');
		
		// We don't want anything else than the xml output for this, so don't wrap it in the layout.
		$this->_helper->layout()->disableLayout();
    }
    
    /*
     *  Construct the form for reporting incidents
     */
	private function getForm() 
	{
       	return new Application_Form_Incident();
	}

    /*
     *  Support method for verifyAction and unverifyAction.
     */
	private function setVerification($status)
    {
    	// Get incident id from url.
    	$id = $this->_request->getParam('id');
    	
    	// Fetch incident 
        $mapper = new Application_Model_IncidentMapper();
        $model = $mapper->find($id);
        
        // Update and save
        $model->setVerified($status);
        $mapper->save($model);
        
        // Flash and redirect
        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
		$redirector->gotoUrlAndExit("/incident/view/id/$id");
    }
}

