<?php

namespace SMongoDB\Tests\Namespaces;

use SMongoDB\Namespaces\Database;
use SMongoDB\Tests\FunctionalTestCase;

final class DatabaseFunctionalTest extends FunctionalTestCase
{
    private $_database;
    private $_databaseName;
    private $_collectionName;

    public function setUp()
    {
        parent::setUp();

        $this->_databaseName = $this->getDatabaseName();
        $this->_collectionName = $this->getCollectionName();
        $this->_database = new Database($this->_manager, $this->_databaseName);
        $this->drop();
    }

    public function tearDown()
    {
        if (!$this->hasFailed()) {
            $this->drop();
        }

        parent::tearDown();
    }

    public function testSelectConnection()
    {
        $collections = $this->_database->selectCollection($this->_collectionName);

        $cDebugInfo = $collections->__debugInfo();
        $dDebugInfo = $this->_database->__debugInfo();
        $this->assertEquals($this->_collectionName, $cDebugInfo['collectionName']);
        unset($cDebugInfo['collectionName']);
        $this->assertEquals($dDebugInfo, $cDebugInfo);
    }

    public function testGetLastError()
    {
        $result = $this->_database->getLastError();

        $this->assertEquals(1, $result->ok);
    }

    public function testDropDatabase()
    {
        $result = $this->_database->dropDatabase();

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
    }

    public function testListCollections()
    {
        $this->createCollection();

        $result = $this->_database->listCollections();

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->_collectionName, $result->name);
        $this->assertEquals($this->getNameSpace(), $result->idIndex->ns);
    }

    public function testCreateCollection()
    {
        $result = $this->createCollection();

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
    }

    public function testDropCollection()
    {
        $this->createCollection();

        $result = $this->_database->dropCollection($this->_collectionName);

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
        $this->assertEquals($this->getNameSpace(), $result->ns);
    }

    private function getNameSpace()
    {
        return $this->_databaseName . '.' . $this->_collectionName;
    }

    private function createCollection()
    {
        return $this->_database->createCollection($this->_collectionName);
    }

    private function drop()
    {
        $this->dropDatabaseH($this->_databaseName);
    }
}