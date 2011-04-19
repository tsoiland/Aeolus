<?php
class Application_Model_IncidentMapper extends Application_Model_AbstractMapper
{
	protected $_dbTable;
 	protected $_dbTableName = 'Incidents';
 	
    protected function _createDataArray($model)
    {
    	 return array(
            'title'   => $model->getTitle(),
            'description' => $model->getDescription(),
    		'latitude' => $model->getLatitude(),
    		'longitude' => $model->getLongitude(),
    		'verified' => $model->getVerified()
        );
    }
 	protected function _createAndPopulateModel($row) 
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
}
?>