<?php

namespace SMongoDB\Namespaces;

use MongoDB\Driver\Manager;
use SMongoDB\Commands\AbstractCommand;
use SMongoDB\Traits\OptionChecker;

abstract class AbstractNamespace
{
    private $_databaseName;
    private $_manager;
    private $_readConcern;
    private $_writeConcern;
    private $_readPreference;
    private $_typeMap;

    public function __construct(Manager $manager, $databaseName, array $options = array())
    {
        $this->_manager = $manager;
        $this->_databaseName = $databaseName;
        $this->setReadConcern($options);
        $this->setReadPreference($options);
        $this->setWriteConcern($options);
        $this->setTypeMap($options);
    }

    public function __debugInfo()
    {
        return array(
            'databaseName' => $this->_databaseName,
            'manager' => $this->_manager,
            'readConcern' => $this->_readConcern,
            'writeConcern' => $this->_writeConcern,
            'readPreference' => $this->_readPreference,
            'typeMap' => $this->_typeMap
        );
    }

    public function execute(AbstractCommand $command)
    {
        $cursor = $this->_manager->executeCommand(
            $this->_databaseName,
            $command->createCommand(),
            $this->_readPreference
        );

        if (isset($this->_typeMap)) {
            $cursor->setTypeMap($this->_typeMap);
        }

        return $cursor->toArray();
    }

    public function getDatabaseName()
    {
        return $this->_databaseName;
    }

    public function getManager()
    {
        return $this->_manager;
    }

    public function getTypeMap()
    {
        return $this->_typeMap;
    }

    protected function getReadConcernOptions(): array
    {
        $options = array();
        $level = $this->_readConcern->getLevel();

        if ($level !== null) {
            $options['readConcernLevel'] = $level;
        }

        return $options;
    }

    protected function getWriteConcernOptions(): array
    {
        $options = array();

        $w = $this->_writeConcern->getW();
        if ($w !== null) $options['w'] = $w;

        $wtimeoutMS = $this->_writeConcern->getWtimeout();
        if ($wtimeoutMS !== 0) $options['wtimeoutMS'] = $wtimeoutMS;

        $journal = $this->_writeConcern->getJournal();
        if ($journal !== null) $options['journal'] = $journal;

        return $options;
    }

    protected function getSupportOptions(): array
    {
        return array(
            'readConcern' => 'MongoDB\\Driver\\ReadConcern',
            'writeConcern' => 'MongoDB\\Driver\\writeConcern',
            'readPreference' => 'MongoDB\\Driver\\ReadPreference',
            'typeMap' => 'array'
        );
    }

    private function setReadConcern(array $options)
    {
        if (isset($options['readConcern'])) {
            $this->checkOption('readConcern', $options['readConcern']);
            $this->_readConcern = $options['readConcern'];
        } else {
            $this->_readConcern = $this->_manager->getReadConcern();
        }
    }

    private function setWriteConcern(array $options)
    {
        if (isset($options['writeConcern'])) {
            $this->checkOption('writeConcern', $options['writeConcern']);
            $this->_writeConcern = $options['writeConcern'];
        } else {
            $this->_writeConcern = $this->_manager->getWriteConcern();
        }
    }

    private function setReadPreference(array $options)
    {
        if (isset($options['readPreference'])) {
            $this->checkOption('readPreference', $options['readPreference']);
            $this->_readPreference = $options['readPreference'];
        } else {
            $this->_readPreference = $this->_manager->getReadPreference();
        }
    }

    private function setTypeMap(array $options)
    {
        if (isset($options['typeMap'])) {
            $this->checkOption('typeMap', $options['typeMap']);
            $this->_typeMap = $options['typeMap'];
        }
    }

    private function checkOption($name, $value)
    {
        $supportOptions = $this->getSupportOptions();
        OptionChecker::checkOptionName($name, $supportOptions);
        OptionChecker::checkOptionValueType($name, $value, $supportOptions[$name]);
    }
}