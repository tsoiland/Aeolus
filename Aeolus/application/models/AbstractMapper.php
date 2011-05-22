<?php
abstract class Application_Model_AbstractMapper
{
	protected $_dbTable;
 
	public abstract function createModelFromTableRow($row);
	public abstract function createArrayFromModel($model);
	
	public function __construct()
	{
		$dbTableClassName = "Application_Model_DbTable_$this->_dbTableName";
		$this->_dbTable = new $dbTableClassName();
	}
    public function getDbTable()
    {
        return $this->_dbTable;
    }
    
    /*
     * Save one, or an array of, models.
     */
 	public function save($model)
 	{
 		// If the model is in fact an array of models, loop through them and call this method for each of them.
 		if(is_array($model)) {
 			foreach ($model as $m) {
 				$this->save($m);
 			}
 			return;
 		}
 		
    	$data = $this->createArrayFromModel($model);
    	
    	if (null === ($id = $model->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
	
    /*
     * Get one model from the db, based on id.
     */
    public function find($id) 
    {
    	$result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        
        $row = $result->current();
        $model = $this->createModelFromTableRow($row);
        return $model;
    }
    
    /*
     *  Get all models.
     */
    public function fetchAll($sql = null) 
    {
    	$resultSet = $this->getDbTable()->fetchAll($sql);
        $models = array();
        foreach ($resultSet as $row) {
            $models[] = $this->createModelFromTableRow($row);
        }
        return $models;
    }
    
    /*
     *  Delete a model based on id.
     */
    public function delete($id)
    {
    	if ($id != null) {
	    	$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $id);
			$this->getDbTable()->delete($where);
    	}
    }
}
?>