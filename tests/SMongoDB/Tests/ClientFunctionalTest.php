<?php

namespace SMongoDB\Tests;

use SMongoDB\Client;

final class ClientFunctionalTest extends FunctionalTestCase
{
    private $_client;

    public function setUp()
    {
        parent::setUp();

        $this->_client = new Client();
    }

    public function testRenameCollection()
    {
        $databaseName = $this->getDatabaseName();
        $collectionName = $this->getCollectionName();

        $this->createCollectionH($databaseName, $collectionName);

        $this->assertTrue($this->collectionExistsH($databaseName, $collectionName));
        $this->assertFalse($this->collectionExistsH($databaseName, 'rename'));

        $options = array(
            'renameCollection' => $databaseName . '.' . $collectionName,
            'to' => $databaseName . '.rename'
        );
        $result = $this->_client->renameCollection($options);

        $this->assertFalse($this->collectionExistsH($databaseName, $collectionName));
        $this->assertTrue($this->collectionExistsH($databaseName, 'rename'));
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
    }

    public function testDropDatabases()
    {
        $databaseName = $this->getDatabaseName();

        $pingResult = $this->pingH($databaseName);
        $this->assertEquals(1, $pingResult->ok);

        $result = $this->_client->dropDatabases($databaseName);

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
        $this->assertEquals($databaseName, $result->dropped);
    }

    public function testListDatabases()
    {
        $actualResult = $this->listDatabasesH();
        $result = $this->_client->listDatabases();

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($actualResult, $result);
    }
}