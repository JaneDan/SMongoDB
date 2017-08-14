<?php

namespace SMongoDB\Tests;

use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\WriteConcern;
use SMongoDB\Client;
use SMongoDB\Exceptions\InvalidArgumentException;

final class ClientUnitTest extends UnitTestCase
{
    public function testConstructorDefaultUri()
    {
        $client = new Client();
        $this->assertEquals('mongodb://127.0.0.1:27017/', $client->getUri());
    }

    public function testConstructorUri()
    {
        $client = new Client($this->getUri());
        $this->assertEquals($this->getUri(), $client->getUri());
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider providerInvalidDriverOptions
     * @param array $driverOptions
     */
    public function testConstructorDriverOptionsType(array $driverOptions)
    {
        new Client($this->getUri(), array(), $driverOptions);
    }

    public function providerInvalidDriverOptions()
    {
        $driverOptions = array();

        foreach ($this->getInvalidArrayValues() as $value) {
            $driverOptions[][] = array('typeMap' => $value);
        }

        return $driverOptions;
    }

    public function testSelectDatabaseInheritOptions()
    {
        list($uriOptions, $driverOptions) = $this->getInheritOptions();

        $client = new Client($this->getUri(), $uriOptions, $driverOptions);
        $database = $client->selectDatabase($this->getDatabaseName());

        $this->assertOptions($database->__debugInfo());
    }

    public function testSelectDatabasePassesOptions()
    {
        $options = $this->getPassesOptions();

        $client = new Client($this->getUri());
        $database = $client->selectDatabase($this->getDatabaseName(), $options);
        $debugInfo = $database->__debugInfo();

        $this->assertOptions($debugInfo);
    }

    public function testSelectCollectionInheritOptions()
    {
        list($uriOptions, $driverOptions) = $this->getInheritOptions();

        $client = new Client($this->getUri(), $uriOptions, $driverOptions);
        $database = $client->selectCollection($this->getDatabaseName(), $this->getCollectionName());

        $this->assertOptions($database->__debugInfo());
    }

    private function getInheritOptions()
    {
        $uriOptions = array(
            'readConcernLevel' => ReadConcern::LOCAL,
            'w' => WriteConcern::MAJORITY,
            'readPreference' => 'secondary'
        );

        $driverOptions = array('typeMap' => array('root' => 'array'));

        return array($uriOptions, $driverOptions);
    }

    private function getPassesOptions()
    {
        return array(
            'readConcern' => new ReadConcern(ReadConcern::LOCAL),
            'writeConcern' => new WriteConcern(WriteConcern::MAJORITY),
            'readPreference' => new ReadPreference(ReadPreference::RP_SECONDARY),
            'typeMap' => array('root' => 'array')
        );
    }

    private function assertOptions($debugInfo)
    {
        if (isset($debugInfo['collectionName'])) {
            $this->assertEquals($this->getCollectionName(), $debugInfo['collectionName']);
        }
        $this->assertEquals($this->getDatabaseName(), $debugInfo['databaseName']);
        $this->assertInstanceOf('MongoDB\Driver\Manager', $debugInfo['manager']);
        $this->assertInstanceOf('MongoDB\Driver\ReadConcern', $debugInfo['readConcern']);
        $this->assertEquals(ReadConcern::LOCAL, $debugInfo['readConcern']->getLevel());
        $this->assertInstanceOf('MongoDB\Driver\WriteConcern', $debugInfo['writeConcern']);
        $this->assertEquals(WriteConcern::MAJORITY, $debugInfo['writeConcern']->getW());
        $this->assertInstanceOf('MongoDB\Driver\ReadPreference', $debugInfo['readPreference']);
        $this->assertEquals(ReadPreference::RP_SECONDARY, $debugInfo['readPreference']->getMode());
        $this->assertInternalType('array', $debugInfo['typeMap']);
        $this->assertEquals(array('root' => 'array'), $debugInfo['typeMap']);
    }
}