<?php
class Application_Model_IncidentMapper extends Application_Model_AbstractMapper
{
	protected $_dbTable;
 	protected $_dbTableName = 'Incidents';
 	
 	/*
 	 * Methods from AbstractMapper
 	 */
 	public function createModelFromTableRow($row)
 	{	
 		$model = new Application_Model_Incident();
        $model->setId($row->id);
		$model->setTitle($row->title);
		$model->setDescription($row->description);
		$model->setLatitude($row->latitude);
		$model->setLongitude($row->longitude);
		$model->setVerified($row->verified);
		$model->setTwitterId($row->twitter_id);
		$model->setSensitiveDescription($row->sensitive_description);
		$model->setVerifyTime($row->verify_time);
		$model->setFirstAssignmentTime($row->first_assignment_time);
		$model->setCloseTime($row->close_time);
		$model->setStatus($row->status);
		
		return $model;
 	}
	public function createArrayFromModel($model)
	{
		$array =  array(
            'title'   => $model->getTitle(),
            'description' => $model->getDescription(),
    		'latitude' => $model->getLatitude(),
    		'longitude' => $model->getLongitude(),
    		'twitter_id' => $model->getTwitterId(),
    	 	'sensitive_description' => $model->getSensitiveDescription(),
    	 	'verify_time' => $model->getVerifyTime(),
    	 	'first_assignment_time' => $model->getFirstAssignmentTime(),
			'close_time' => $model->getCloseTime(),
			'status' => $model->getStatusId(),
			'verified' => $model->getVerified(),
        );
        
        return $array;
	}
	
	/*
	 * Custom sql queries
	 */
    public function fetchUsersIncidents($id) 
    {
    	$sql = "SELECT * 
				FROM incidents i
				LEFT JOIN user_incident ui ON ui.incident_id = i.id
				WHERE ui.user_id =$id
				LIMIT 0 , 30";
    	$rows = $this->getDbTable()->getAdapter()->fetchAll($sql);
    	$models = array();
    	foreach($rows as $row) {
    		$models[] = $this->find($row['id']);
    	}
    	return $models;
    }
    
	public function assignUserToIncident($user_id, $incident_id) 
    {
    	$sql = "INSERT INTO user_incident VALUES ($user_id, $incident_id)";
    	$db = $this->getDbTable()->getAdapter();
    	
    	try {
    		$db->query($sql);
    		
    		// If the incident doesn't have a time from before, this is the first
    		// time and we set current time and save.
    		$model = $this->find($incident_id);
    		
    		if($model->getFirstAssignmentTime() == 0) {
	    		$model->setFirstAssignmentTime(time());
	    		$this->save($model);
    		}
    	} catch (Exception $e) {
    	}
    }

	public function unAssignUserToIncident($user_id, $incident_id) 
    {
    	$sql = "DELETE FROM user_incident WHERE user_id = $user_id AND incident_id = $incident_id";
    	$db = $this->getDbTable()->getAdapter();
    	
    	
    	$db->query($sql);
    }
    
	public function getAssignUserToIncidentFormData($incident_id) 
    {
    	$sql = "SELECT * FROM user_incident WHERE incident_id = '$incident_id'";
    	$rows = $this->getDbTable()->getAdapter()->fetchAll($sql);
    	
    	$data = array();
    	foreach($rows as $row) {
    		$data[$row['user_id']] = 1;
    	}
    	return $data;
    }
    public function getUsersAssignedToIncident($incident_id) 
    {
    	$sql = "SELECT * FROM users u
    		LEFT JOIN user_incident ui ON ui.user_id = u.id
    		WHERE ui.incident_id = '$incident_id'";
    	$rows = $this->getDbTable()->getAdapter()->fetchAll($sql);
    	
    	$models = array();
    	$usermapper = new Application_Model_UserMapper();
    	foreach($rows as $row) {
    		$models[] = $usermapper->find($row['id']);
    	}
    	return $models;
    }
    public function twitterIdExists($id)
    {
    	$sql = "SELECT * FROM incidents WHERE twitter_id = '$id'";
    	$rows = $this->getDbTable()->getAdapter()->fetchAll($sql);
    	
    	return !empty($rows);
    }
    public function fetchPublicIncidents() 
    {
    	$sql = "SELECT * FROM incidents WHERE verified = 1";
    	$rows = $this->getDbTable()->getAdapter()->fetchAll($sql);
    	
    	$models = array();
    	foreach($rows as $row) {
    		$models[] = $this->find($row['id']);
    	}
    	return $models;
    }
}
?>