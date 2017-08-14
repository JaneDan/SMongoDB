<?php

namespace SMongoDB\Commands\Aggregation;

use SMongoDB\Commands\AbstractCollectionCommand;

final class Distinct extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'key' => 'string',
            'query' => 'array',
            'readConcern' => 'array',
            'collation' => 'array'
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('distinct' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}