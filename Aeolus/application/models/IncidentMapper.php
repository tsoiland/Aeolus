<?php
class Application_Model_IncidentMapper extends Application_Model_AbstractMapper
{
	protected $_dbTable;
 	protected $_dbTableName = 'Incidents';
 	
    public static function createDataArray($model)
    {
    	 $data =  array(
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
        );
        $verified = $model->getVerified();

        if ($verified == 0 || $verified == 1) {
        	$data['verified'] = $model->getVerified();	
        }
        
        return $data;
    }
 	public static function createAndPopulateModel($row) 
    {
    	$model = new Application_Model_Incident();
        $model->setId($row->id);
		$model->setTitle($row->title);
		$model->setDescription($row->description);
		$model->setLatitude($row->latitude);
		$model->setLongitude($row->longitude);
		if($row->verified == 0 || $row->verified == 1)
			$model->setVerified($row->verified);
		if($row->twitter_id)
			$model->setTwitterId($row->twitter_id);
		$model->setSensitiveDescription($row->sensitive_description);
		if(!empty($row->verify_time))
			//$model->setVerifyTime($row->verify_time);
		if($row->first_assignment_time)
			$model->setFirstAssignmentTime($row->first_assignment_time);
		if($row->close_time)
			$model->setCloseTime($row->close_time);
		$model->setStatus($row->status);
		die("s<pre>".print_r($row,1)."</pre>");
	    return $model;
    }

	public static function createAndPopulateModelFromArray($array)
    {
    	// Construct and populate the model. getValues() returns an array and we need an object.
        // Therefore we simply cast it. The @ supresses notices that result from this.
    	$values = (object) $array;
    	$model = Application_Model_IncidentMapper::createAndPopulateModel($values);
	    return $model;    
    }
    
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
    		$models[] = $this->createAndPopulateModelFromArray($row);
    	}
    	return $models;
    }
    
	public function assignUserToIncident($user_id, $incident_id) 
    {
    	$sql = "INSERT INTO user_incident VALUES ($user_id, $incident_id)";
    	$db = $this->getDbTable()->getAdapter();
    	
    	try {
    		$db->query($sql);
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
    	foreach($rows as $row) {
    		$models[] = Application_Model_UserMapper::createAndPopulateModelFromArray($row);
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
    		$models[] = $this->createAndPopulateModelFromArray($row);
    	}
    	return $models;
    }
    
}
?>