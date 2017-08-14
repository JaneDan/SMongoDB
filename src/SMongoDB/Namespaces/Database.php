<?php

namespace SMongoDB\Namespaces;

use SMongoDB\Commands\Administration\Create;
use SMongoDB\Commands\Administration\DropCollection;
use SMongoDB\Commands\Administration\DropDatabase;
use SMongoDB\Commands\Administration\ListCollections;
use SMongoDB\Commands\Crud\GetLastError;

final class Database extends AbstractNamespace
{
    public function selectCollection($collectionName, array $options = array())
    {
        $typeMap = $this->getTypeMap();
        if (isset($typeMap)) {
            $options += array('typeMap' => $typeMap);
        }

        return new Collection($this->getManager(),
            $this->getDatabaseName(), $collectionName, $options);
    }

    public function getLastError(array $options = array())
    {
        $getLastError = new GetLastError();
        $getLastError->setOptions($options);

        return current($this->execute($getLastError));
    }

    public function dropDatabase()
    {
        return current($this->execute(new DropDatabase()));
    }

    public function listCollections(array $options = array())
    {
        $listCollections = new ListCollections();
        $listCollections->setOptions($options);

        return current($this->execute($listCollections));
    }

    public function createCollection($collectionName, array $options = array())
    {
        $create = new Create();
        $create->setCollectionName($collectionName);
        $create->setOptions($options);

        return current($this->execute($create));
    }

    public function dropCollection($collectionName)
    {
        $dropCollection = new DropCollection();
        $dropCollection->setCollectionName($collectionName);

        return current($this->execute($dropCollection));
    }
}