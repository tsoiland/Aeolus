<?php
abstract class Application_Model_AbstractMapper
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
    
 	public function save($model)
 	{
 		if(is_array($model)) {
 			foreach ($model as $m) {
 				$this->save($m);
 			}
 			return;
 		}
 		
    	$data = $this->createDataArray($model);
    	
    	if (null === ($id = $model->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable("Application_Model_DbTable_$this->_dbTableName");
        }
        return $this->_dbTable;
    }
	
    public function find($id) 
    {
    	$result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        
        $row = $result->current();
        $model = $this->createAndPopulateModel($row);
        return $model;
    }
    
    public function fetchAll() 
    {
    	$resultSet = $this->getDbTable()->fetchAll();
        $models = array();
        foreach ($resultSet as $row) {
            $models[] = $this->createAndPopulateModel($row);
        }
        return $models;
    }
    public function delete($id)
    {
    	if ($id != null) {
	    	$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $id);
			$this->getDbTable()->delete($where);
    	}
    }
}
?>