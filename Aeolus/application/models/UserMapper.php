<?php
class Application_Model_UserMapper extends Application_Model_AbstractMapper
{
	protected $_dbTable;
 	protected $_dbTableName = 'Users';
 	
 	public static function createDataArray($model)
    {
    	 $data = array(
            'username'   => $model->getUsername(),
            'role' => $model->getRole()
        );
    	
    	$clock_in_time = $model->getClockInTime();
        if (!empty($clock_in_time)) {
        	$data['clock_in_time'] = $clock_in_time;
        }
        
    	$clock_out_time = $model->getClockOutTime();
        if (!empty($clock_out_time)) {
        	$data['clock_out_time'] = $clock_out_time;
        }
        
        return $data;
    }
 	
    public static function createAndPopulateModel($row) 
    {
    	$model = new Application_Model_User();
        $model->setId($row->id);
	    $model->setUsername($row->username);
	    $model->setRole($row->role);
	    if(!empty($row->clock_in_time))
	    	$model->setClockInTime($row->clock_in_time);
	    if(!empty($row->clock_out_time))
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