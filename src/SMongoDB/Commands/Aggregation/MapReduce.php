<?php

namespace SMongoDB\Commands\Aggregation;

use SMongoDB\Commands\AbstractCollectionCommand;

final class MapReduce extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'map' => 'string',
            'reduce' => 'string',
            'finalize' => 'string',
            'out' => array('string', 'array'),
            'query' => 'array',
            'sort' => 'array',
            'limit' => 'integer',
            'scope' => 'array',
            'jsMode' => 'bool',
            'verbose' => 'bool',
            'bypassDocumentValidation' => 'bool',
            'collation' => 'array'
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('mapReduce' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}