<?php
class ReportController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$generator = new Application_Model_ReportGenerator();
		$this->view->report = $generator->createReport();
	}
	public function closedincidentsAction()
	{
    	$mapper = new Application_Model_IncidentMapper();
        $this->view->models = $mapper->fetchAll('status = 1');
	}
	
}