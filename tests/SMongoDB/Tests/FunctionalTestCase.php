<?php

namespace SMongoDB\Tests;

use MongoDB\Driver\Command;
use MongoDB\Driver\Manager;

abstract class FunctionalTestCase extends UnitTestCase
{
    protected $_manager;

    public function setUp()
    {
        $this->_manager = new Manager($this->getUri());
    }

    protected function execute($databaseName, $command)
    {
        $cursor = $this->_manager->executeCommand(
            $databaseName,
            new Command($command)
        );

        return $cursor->toArray();
    }

    protected function listDatabasesH()
    {
        $cmd = array('listDatabases' => 1);
        return current($this->execute('admin', $cmd));
    }

    protected function listCollectionsH($databaseName, array $filter = array())
    {
        $cmd = array('listCollections' => 1);
        $cmd += array('filter' => $filter);
        return current($this->execute($databaseName, $cmd));
    }

    protected function createCollectionH($databaseName, $collection, array $options = array())
    {
        $cmd = array('create' => $collection);
        $cmd += $options;
        return current($this->execute($databaseName, $cmd));
    }

    protected function pingH($databaseName)
    {
        return current($this->execute($databaseName, array('ping' => 1)));
    }

    protected function collectionExistsH($databaseName, $collectionName)
    {
        $filter = array('name' => $collectionName);
        $result = $this->listCollectionsH($databaseName, $filter);

        return $result !== false;
    }

    protected function dropDatabaseH($databaseName)
    {
        $cmd = array('dropDatabase' => 1);
        return current($this->execute($databaseName, $cmd));
    }

    protected function dropCollectionH($databaseName, $collectionName)
    {
        $result = array();

        if ($this->collectionExistsH($databaseName, $collectionName)) {
            $cmd = array('drop' => $collectionName);
            $result = $this->execute($databaseName, $cmd);
        }

        return $result;
    }

    protected function countH($databaseName, $collectionName)
    {
        $cmd = array('count' => $collectionName);
        return current($this->execute($databaseName, $cmd));
    }

    protected function getInsertValues()
    {
        return array(
            array('id' => 1, 'name' => 'Jan', 'sex' => 0),
            array('id' => 1, 'name' => 'Dan', 'sex' => 1),
            array('id' => 1, 'name' => 'Sun', 'sex' => 1),
            array('id' => 1, 'name' => 'Tony', 'sex' => 0)
        );
    }
}