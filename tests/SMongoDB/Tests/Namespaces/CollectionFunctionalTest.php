<?php

namespace SMongoDB\Tests\Namespaces;

use SMongoDB\Namespaces\Collection;
use SMongoDB\Tests\FunctionalTestCase;

final class CollectionFunctionalTest extends FunctionalTestCase
{
    private $_collection;

    public function setUp()
    {
        parent::setUp();

        $this->_collection = new Collection(
            $this->_manager,
            $this->getDatabaseName(),
            $this->getCollectionName()
        );
        $this->drop();
    }

    public function tearDown()
    {
        if (!$this->hasFailed()) {
            $this->drop();
        }

        parent::tearDown();
    }

    public function testAggregate()
    {
        list($actualInsertCount, $_) = $this->insert();

        $options = array('pipeline' => array(
            array('$project' => array('name' => 1)),
            array('$unwind' => '$name'),
            array('$group' => array(
                '_id' => '$name',
                'count' => array('$sum' => 1))
            )
        ));
        $result = $this->_collection->aggregate($options);

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
        $this->assertCount($actualInsertCount, $result->result);
    }

    public function testCount()
    {
        list($actualInsertCount, $_) = $this->insert();

        $databaseName = $this->_collection->getDatabaseName();
        $collectionName = $this->_collection->getCollectionName();
        $result = $this->_collection->count();

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($actualInsertCount, $result->n);
        $this->assertEquals(
            $this->countH($databaseName, $collectionName),
            $result);
    }

    public function testDistinct()
    {
        list($actualInsertCount, $_) = $this->insert();

        $options = array(
            'key' => 'name'
        );
        $result = $this->_collection->distinct($options);

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
        $this->assertCount($actualInsertCount, $result->values);
    }

    public function testMapReduce()
    {
        list($actualInsertCount, $_) = $this->insert();

        $mapFunction = 'function(){emit(this.sex,this.name)}';
        $reduceFunction = 'function(key,values){return {sex:key,names:values}}';
        $options = array(
            'map' => $mapFunction,
            'reduce' => $reduceFunction,
            'out' => 'cTest1'
        );
        $result = $this->_collection->mapReduce($options);

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
        $this->assertEquals('cTest1', $result->result);
        $this->assertEquals($actualInsertCount, $result->counts->input);
    }

    public function testFind()
    {
        list($actualInsertCount, $_) = $this->insert();

        $result = $this->_collection->find();

        $this->assertInternalType('array', $result);
        $this->assertCount($actualInsertCount, $result);
    }

    public function testInsert()
    {
        list($actualInsertCount, $result) = $this->insert();

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
        $this->assertEquals($actualInsertCount, $result->n);
    }

    public function testUpdate()
    {
        $this->insert();

        $options = array('updates' => array(
            array(
                'q' => array('name' => 'Jan'),
                'u' => array('name' => 'update')
            )
        ));
        $result = $this->_collection->update($options);

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
        $this->assertEquals(1, $result->nModified);
    }

    public function testDelete()
    {
        $this->insert();

        $options = array('deletes' => array(
            array('q' => array('name' => 'Jan'), 'limit' => 1)
        ));
        $result = $this->_collection->delete($options);

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
        $this->assertEquals(1, $result->n);
    }

    public function testFindAndModify()
    {
        $this->insert();

        $options = array(
            'query' => array('name' => 'Jan'),
            'update' => array('name' => 'update'),
            'new' => true
        );
        $result = $this->_collection->findAndModify($options);

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
        $this->assertEquals('update', $result->value->name);
    }

    public function testParallelCollectionScan()
    {
        $this->insert();

        $options = array('numCursors' => 1);
        $result = $this->_collection->parallelCollectionScan($options);

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
    }

    public function testCreateCollection()
    {
        $result = $this->_collection->createCollection();

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
    }

    public function testCreateIndexes()
    {
        $this->insert();

        $options = array('indexes' => array(
            array(
                'key' => array('name' => 1),
                'name' => $this->getIndexName(),
                'unique' => true
            )
        ));
        $result = $this->_collection->createIndexes($options);

        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
    }

    public function testListIndexes()
    {
        $this->testCreateIndexes();

        $result = $this->_collection->listIndexes();

        $this->assertInternalType('array', $result);
        $this->assertGreaterThan(0, count($result));
        $this->assertTrue($this->indexExists($this->getIndexName(), $result));
    }

    public function testDropIndexes()
    {
        $this->testCreateIndexes();

        $options = array('index' => $this->getIndexName());
        $result = $this->_collection->dropIndexes($options);

        $actualResult = $this->_collection->listIndexes();
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals(1, $result->ok);
        $this->assertFalse($this->indexExists($this->getIndexName(), $actualResult));
    }

    public function testTouch()
    {
        $this->markTestSkipped(
            'The MMAPv1 storage engine supports touch.'
            . "\n"
            . 'The WiredTiger storage engine does not support touch.'
        );

        $this->testCreateIndexes();

        $options = array('data' => true, 'index' => false);
        $result = $this->_collection->touch($options);

        $this->assertTrue(true);
    }

    private function insert()
    {
        $documents = $this->getInsertValues();
        $options = array('documents' => $documents);
        $result = $this->_collection->insert($options);

        return array(count($documents), $result);
    }

    private function drop()
    {
        $this->dropCollectionH(
            $this->_collection->getDatabaseName(),
            $this->_collection->getCollectionName()
        );
    }

    private function indexExists($indexName, $result)
    {
        $exists = false;

        foreach ($result as $item) {
            if (strcmp($indexName, $item->name) == 0) {
                $exists = true;
                break;
            }
        }

        return $exists;
    }
}