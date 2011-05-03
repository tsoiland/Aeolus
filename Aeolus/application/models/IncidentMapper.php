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
    		'longitude' => $model->getLongitude()
        );
        $verified = $model->getVerified();
        if (!empty($verified)) {
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
		$model->setVerified($row->verified);
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
				WHERE ui.user_id =1
				LIMIT 0 , 30";
    	$rows = $this->getDbTable()->getAdapter()->fetchAll($sql);
    	foreach($rows as $row) {
    		$models[] = $this->createAndPopulateModelFromArray($row);
    	}
    	return $models;
    }
    
}
?>