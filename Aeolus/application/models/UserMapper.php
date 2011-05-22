<?php
class Application_Model_UserMapper extends Application_Model_AbstractMapper
{
	protected $_dbTable;
 	protected $_dbTableName = 'Users';
 	/*
 	 * Methods from AbstractMapper
 	 */
 	public function createModelFromTableRow($row)
 	{
 		$model = new Application_Model_User();
        $model->setId($row->id);
	    $model->setUsername($row->username);
	    $model->setRealName($row->realname);
	    $model->setPassword($row->password);
	    $model->setSalt($row->salt);
	    $model->setRole($row->role);
	    $model->setPhoneNr($row->phone_nr);
	    $model->setLocation($row->location);
	    $model->setClockInTime($row->clock_in_time);
	    $model->setClockOutTime($row->clock_out_time);	
	    return $model;
 	}
	public function createArrayFromModel($model)
	{
 		$array = array(
            'username'   => $model->getUsername(),
    	 	'realname' => $model->getRealName(),
            'role' => $model->getRole(),
            'phone_nr' => $model->getPhoneNr(),
            'location' => $model->getLocation(),
 			'password' => $model->getHashedPassword(),
 			'salt' => $model->getSalt(),
 			'clock_in_time' => $model->getClockInTime(),
 			'clock_out_time' => $model->getClockOutTime()
        );
        
        return $array;
	}
}
?>