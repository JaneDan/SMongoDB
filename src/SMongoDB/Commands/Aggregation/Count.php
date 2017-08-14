<?php

namespace SMongoDB\Commands\Aggregation;

use SMongoDB\Commands\AbstractCollectionCommand;

class Count extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'query' => 'array',
            'limit' => 'integer',
            'skip' => 'integer',
            'hint' => array('string', 'array'),
            'readConcern' => 'array'
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('count' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}