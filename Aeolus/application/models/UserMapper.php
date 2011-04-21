<?php
class Application_Model_UserMapper extends Application_Model_AbstractMapper
{
	protected $_dbTable;
 	protected $_dbTableName = 'Users';
 	
 	public static function createDataArray($model)
    {
    	 return array(
            'username'   => $model->getUsername(),
            'role' => $model->getRole()
        );
    }
 	
    public static function createAndPopulateModel($row) 
    {
    	$model = new Application_Model_User();
        $model->setId($row->id);
	    $model->setUsername($row->username);
	    $model->setRole($row->role);
	    $model->setClockInTime($row->clock_in_time);
	    $model->setClockOutTime($row->clock_out_time);
	    return $model;
    }

	public static function createAndPopulateModelFromArray($array)
    {
    	// Construct and populate the model. getValues() returns an array and we need an object.
        // Therefore we simply cast it. The @ supresses notices that result from this.
    	$values = (object) $array;
    	$model = Application_Model_UserMapper::createAndPopulateModel($values);
	    return $model;    
    }
}
?>