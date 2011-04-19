<?php
class Application_Model_UserMapper extends Application_Model_AbstractMapper
{
	protected $_dbTable;
 	protected $_dbTableName = 'Users';
 	
 	protected function _createDataArray($model)
    {
    	 return array(
            'username'   => $model->getUsername(),
            'role' => $model->getRole()
        );
    }
 	
    protected function _createAndPopulateModel($row) 
    {
    	$model = new Application_Model_User();
        $model->setId($row->id);
	    $model->setUsername($row->username);
	    $model->setRole($row->role);
	    $model->setClockInTime($row->clock_in_time);
	    $model->setClockOutTime($row->clock_out_time);
	    return $model;
    }
}
?>