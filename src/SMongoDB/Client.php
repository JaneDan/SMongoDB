<?php

namespace SMongoDB;

use MongoDB\Driver\Manager;
use SMongoDB\Commands\Administration\RenameCollection;
use SMongoDB\Commands\Diagnostic\ListDatabases;
use SMongoDB\Exceptions\InvalidArgumentException;
use SMongoDB\Namespaces\Collection;
use SMongoDB\Namespaces\Database;

final class Client
{
    private $_manager;
    private $_uri;
    private $_typeMap;

    public function __construct(
        string $uri = 'mongodb://127.0.0.1:27017/',
        array $uriOptions = array(),
        array $driverOptions = array())
    {
        $this->_uri = $uri;
        $this->_typeMap = self::getTypeMapFromOptions($driverOptions);
        $this->_manager = new Manager($uri, $uriOptions, $driverOptions);
    }

    public function __get($name)
    {
        return $this->selectDatabase($name);
    }

    public function selectDatabase($databaseName, array $options = array())
    {
        if (isset($this->_typeMap)) {
            $options += array('typeMap' => $this->_typeMap);
        }

        return new Database($this->_manager, $databaseName, $options);
    }

    public function selectCollection($databaseName, $collectionName, array $options = array())
    {
        if (isset($this->_typeMap)) {
            $options += array('typeMap' => $this->_typeMap);
        }

        return new Collection($this->_manager, $databaseName, $collectionName, $options);
    }

    public function renameCollection(array $options)
    {
        $database = $this->selectDatabase('admin');

        $renameCollection = new RenameCollection();
        $renameCollection->setOptions($options);

        return current($database->execute($renameCollection));
    }

    public function dropDatabases($databaseName)
    {
        $database = $this->selectDatabase($databaseName);
        return $database->dropDatabase();
    }

    public function listDatabases(array $options = array())
    {
        $database = $this->selectDatabase('admin');

        $listDatabases = new ListDatabases();
        $listDatabases->setOptions($options);

        return current($database->execute($listDatabases));
    }

    public function getManager(): Manager
    {
        return $this->_manager;
    }

    public function getUri()
    {
        return $this->_uri;
    }

    private static function getTypeMapFromOptions(&$driverOptions)
    {
        $typeMap = null;

        if (isset($driverOptions['typeMap'])) {
            self::checkTypeMapArgumentType($driverOptions['typeMap']);
            $typeMap = $driverOptions['typeMap'];
            unset($driverOptions['typeMap']);
        }

        return $typeMap;
    }

    private static function checkTypeMapArgumentType(&$typeMap)
    {
        if (!is_array($typeMap)) {
            throw InvalidArgumentException::InvalidType(
                '"typeMap" driver option',
                $typeMap,
                'array'
            );
        }
    }
}