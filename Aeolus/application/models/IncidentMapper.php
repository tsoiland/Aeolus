<?php
class Application_Model_IncidentMapper
{
	protected $_dbTable;
 
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Incident');
        }
        return $this->_dbTable;
    }
    public function save(Application_Model_Incident $model) {
    	$data = array(
            'title'   => $model->getTitle(),
            'description' => $model->getDescription(),
    		'latitude' => $model->getLatitude(),
    		'longitude' => $model->getLongitude(),
    		'verified' => $model->getVerified()
        );
        
        if (null === ($id = $model->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    public function find($id) {
    	$result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $model = new Application_Model_Incident();
        $row = $result->current();
        $model->setId($row->id);
        $model->setTitle($row->title);
        $model->setDescription($row->description);
        $model->setLatitude($row->latitude);
        $model->setLongitude($row->longitude);
        $model->setVerified($row->verified);
        return $model;
    }
    public function fetchAll() {
    	$resultSet = $this->getDbTable()->fetchAll();
        $models = array();
        foreach ($resultSet as $row) {
            $model = new Application_Model_Incident();
            $model->setId($row->id);
            $model->setTitle($row->title);
            $model->setDescription($row->description);
	        $model->setLatitude($row->latitude);
	        $model->setLongitude($row->longitude);
	        $model->setVerified($row->verified);
            $models[] = $model;
        }
        return $models;
    }
}
?>