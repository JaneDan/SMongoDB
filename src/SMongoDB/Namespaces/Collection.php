<?php

namespace SMongoDB\Namespaces;

use MongoDB\Driver\Manager;
use SMongoDB\Commands\Administration\Create;
use SMongoDB\Commands\Administration\CreateIndexes;
use SMongoDB\Commands\Administration\DropIndexes;
use SMongoDB\Commands\Administration\ListIndexes;
use SMongoDB\Commands\Administration\RenameCollection;
use SMongoDB\Commands\Administration\Touch;
use SMongoDB\Commands\Aggregation\Aggregate;
use SMongoDB\Commands\Aggregation\Count;
use SMongoDB\Commands\Aggregation\Distinct;
use SMongoDB\Commands\Aggregation\MapReduce;
use SMongoDB\Commands\Crud\Delete;
use SMongoDB\Commands\Crud\Find;
use SMongoDB\Commands\Crud\FindAndModify;
use SMongoDB\Commands\Crud\GetMore;
use SMongoDB\Commands\Crud\Insert;
use SMongoDB\Commands\Crud\ParallelCollectionScan;
use SMongoDB\Commands\Crud\Update;

final class Collection extends AbstractNamespace
{
    private $_collectionName;

    public function __construct(
        Manager $manager, $databaseName,
        $collectionName, array $options = array())
    {
        $this->_collectionName = $collectionName;
        parent::__construct($manager, $databaseName, $options);
    }

    public function __debugInfo()
    {
        $debugInfo = array('collectionName' => $this->_collectionName);
        $debugInfo += parent::__debugInfo();

        return $debugInfo;
    }

    public function getCollectionName()
    {
        return $this->_collectionName;
    }

    public function aggregate(array $options)
    {
        $options += $this->getReadConcernOptions();

        $aggregate = new Aggregate();
        $aggregate->setCollectionName($this->_collectionName);
        $aggregate->setOptions($options);

        return current($this->execute($aggregate));
    }

    public function count(array $options = array())
    {
        $options += $this->getReadConcernOptions();

        $count = new Count();
        $count->setCollectionName($this->_collectionName);
        $count->setOptions($options);

        return current($this->execute($count));
    }

    public function distinct(array $options)
    {
        $options += $this->getReadConcernOptions();

        $distinct = new Distinct();
        $distinct->setCollectionName($this->_collectionName);
        $distinct->setOptions($options);

        return current($this->execute($distinct));
    }

    public function mapReduce(array $options)
    {
        $mapReduce = new MapReduce();
        $mapReduce->setCollectionName($this->_collectionName);
        $mapReduce->setOptions($options);

        return current($this->execute($mapReduce));
    }

    public function find(array $options = array())
    {
        $options += $this->getReadConcernOptions();

        $find = new Find();
        $find->setCollectionName($this->_collectionName);
        $find->setOptions($options);

        return $this->execute($find);
    }

    public function insert(array $options)
    {
        $options += $this->getWriteConcernOptions();

        $insert = new Insert();
        $insert->setCollectionName($this->_collectionName);
        $insert->setOptions($options);

        return current($this->execute($insert));
    }

    public function update(array $options)
    {
        $options += $this->getWriteConcernOptions();

        $update = new Update();
        $update->setCollectionName($this->_collectionName);
        $update->setOptions($options);

        return current($this->execute($update));
    }

    public function delete(array $options)
    {
        $options += $this->getWriteConcernOptions();

        $delete = new Delete();
        $delete->setCollectionName($this->_collectionName);
        $delete->setOptions($options);

        return current($this->execute($delete));
    }

    public function findAndModify(array $options)
    {
        $options += $this->getWriteConcernOptions();

        $findAndModify = new FindAndModify();
        $findAndModify->setCollectionName($this->_collectionName);
        $findAndModify->setOptions($options);

        return current($this->execute($findAndModify));
    }

    public function parallelCollectionScan(array $options)
    {
        $options += $this->getReadConcernOptions();

        $parallelCollectionScan = new ParallelCollectionScan();
        $parallelCollectionScan->setCollectionName($this->_collectionName);
        $parallelCollectionScan->setOptions($options);

        return current($this->execute($parallelCollectionScan));
    }

    public function createCollection(array $options = array())
    {
        $create = new Create();
        $create->setCollectionName($this->_collectionName);
        $create->setOptions($options);

        return current($this->execute($create));
    }

    public function createIndexes(array $options)
    {
        $createIndexes = new CreateIndexes();
        $createIndexes->setCollectionName($this->_collectionName);
        $createIndexes->setOptions($options);

        return current($this->execute($createIndexes));
    }

    public function listIndexes()
    {
        $listIndexes = new ListIndexes();
        $listIndexes->setCollectionName($this->_collectionName);

        return $this->execute($listIndexes);
    }

    public function dropIndexes(array $options)
    {
        $dropIndexes = new DropIndexes();
        $dropIndexes->setCollectionName($this->_collectionName);
        $dropIndexes->setOptions($options);

        return current($this->execute($dropIndexes));
    }

    public function touch(array $options)
    {
        $touch = new Touch();
        $touch->setCollectionName($this->_collectionName);
        $touch->setOptions($options);

        return current($this->execute($touch));
    }
}