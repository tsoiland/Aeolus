<?php 
class Application_Model_ReportGenerator
{
	public function createReport()
	{
		$this->report = new Application_Model_Report();
		
		$mapper = new Application_Model_IncidentMapper();
		$closedIncidents = $mapper->fetchAll('status = 1');
		
		
		$this->calculateNumberOfOpenIncidents();
		$this->calculateNumberOfClosedIncidents($closedIncidents); 
		$this->calculateAverageMinMax($closedIncidents);
		$this->calculateDurationStandardDeviation($closedIncidents, $this->report->average_duration);
		$this->calculateIncidentsPrPersonnel();
		return $this->report;
	}
	private function calculateNumberOfOpenIncidents() 
	{
		$mapper = new Application_Model_IncidentMapper();
		$models = $mapper->fetchAll('status != 1');
		$this->report->number_of_open_incidents = count($models);
	}
	
	private function calculateNumberOfClosedIncidents($incidents) 
	{
		$this->report->number_of_closed_incidents = count($incidents);
	}
	
	private function calculateAverageMinMax($incidents) 
	{
		$max = 0;
		$min = 3153600000;
		$sum = 0;
		//print "<pre>".print_r($incidents,1)."</pre>";
		foreach($incidents as $incident) {
			$duration = $incident->getCloseTime() - $incident->getCreationTime();
			$sum += $duration;
			
			if($duration > $max)
				$max = $duration;
			if($duration < $min)
				$min = $duration;
			
		}
		$this->report->maximum_duration = $max/3600;
		$this->report->minimum_duration = $min/3600;
		$this->report->average_duration = $sum / count($incidents)/3600;
	}
	
	public function calculateDurationStandardDeviation($incidents, $averageDuration) 
	{
		$sum = 0;
		foreach($incidents as $incident) {
			$duration = $incident->getCloseTime() - $incident->getCreationTime();
			$sum += pow($duration - $averageDuration * 3600, 2);
			
		}
		$this->report->duration_sd = sqrt($sum / count($incidents))/3600;
	}
	
	private function calculateIncidentsPrPersonnel()
	{
		$sql = "SELECT assignment_count, count(assignment_count) as personnel_count 
				FROM 
					(SELECT count(*) as assignment_count 
					 FROM `user_incident` 
					 GROUP BY user_id
					) as assignments 
				GROUP BY assignment_count";
		$mapper = new Application_Model_IncidentMapper();
		$rows = $mapper->getDbTable()->getAdapter()->fetchAll($sql);
    	$this->report->incidents_pr_personnel = $rows;
	}
}