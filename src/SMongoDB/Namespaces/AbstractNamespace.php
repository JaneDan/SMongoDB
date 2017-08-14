<?php

namespace SMongoDB\Namespaces;

use MongoDB\Driver\Manager;
use SMongoDB\AbstractOption;
use SMongoDB\Commands\AbstractCommand;

abstract class AbstractNamespace extends AbstractOption
{
    private $_databaseName;
    private $_manager;

    public function __construct(Manager $manager, $databaseName, array $options = array())
    {
        $this->_manager = $manager;
        $this->_databaseName = $databaseName;

        $this->setDefaultOptions($this->getDefaultOptions());
        $this->setOptions($options);
    }

    public function __debugInfo()
    {
        return array(
            'databaseName' => $this->_databaseName,
            'manager' => $this->_manager,
            'readConcern' => $this->getReadConcern(),
            'writeConcern' => $this->getWriteConcern(),
            'readPreference' => $this->getReadPreference(),
            'typeMap' => $this->getTypeMap()
        );
    }

    public function execute(AbstractCommand $command)
    {
        $cursor = $this->_manager->executeCommand(
            $this->_databaseName,
            $command->createCommand(),
            $this->getReadPreference()
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
        return $this->getOptions()['typeMap'];
    }

    protected function getReadConcernOptions(): array
    {
        $options = array();
        $readConcern = $this->getReadConcern();
        $level = $readConcern->getLevel();

        if ($level !== null) {
            $options['readConcernLevel'] = $level;
        }

        return $options;
    }

    protected function getWriteConcernOptions(): array
    {
        $options = array();
        $writeConcern = $this->getWriteConcern();

        $w = $writeConcern->getW();
        if ($w !== null) $options['w'] = $w;

        $wtimeoutMS = $writeConcern->getWtimeout();
        if ($wtimeoutMS !== 0) $options['wtimeoutMS'] = $wtimeoutMS;

        $journal = $writeConcern->getJournal();
        if ($journal !== null) $options['journal'] = $journal;

        return $options;
    }

    protected function getSupportedOptions(): array
    {
        return array(
            'readConcern' => 'MongoDB\\Driver\\ReadConcern',
            'writeConcern' => 'MongoDB\\Driver\\writeConcern',
            'readPreference' => 'MongoDB\\Driver\\ReadPreference',
            'typeMap' => array('array', 'null')
        );
    }

    private function getReadConcern()
    {
        return $this->getOptions()['readConcern'];
    }

    private function getWriteConcern()
    {
        return $this->getOptions()['writeConcern'];
    }

    private function getReadPreference()
    {
        return $this->getOptions()['readPreference'];
    }

    private function getDefaultOptions(): array
    {
        return array(
            'readConcern' => $this->_manager->getReadConcern(),
            'writeConcern' => $this->_manager->getWriteConcern(),
            'readPreference' => $this->_manager->getReadPreference(),
            'typeMap' => null
        );
    }
}