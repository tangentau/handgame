<?php

class Application_Model_AlphabetMapper
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
            $this->setDbTable('Application_Model_DbTable_Alphabet');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_Alphabet $alphabet)
    {
        $data = array(
            'name'   => $alphabet->getName(),
            'order' => $alphabet->getOrder(),
			'language_id' => $alphabet->getLanguageId(),
        );
 
        if (null === ($id = $alphabet->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_Alphabet $alphabet)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $alphabet->setId($row->id)
                  ->setName($row->name)
                  ->setLanguageId($row->language_id)
                  ->setOrder($row->order);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Alphabet();
            $entry->setId($row->id)
                  ->setName($row->name)
                  ->setLanguageId($row->language_id)
                  ->setOrder($row->order);
            $entries[] = $entry;
        }
        return $entries;
    }

}

