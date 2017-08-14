<?php

namespace SMongoDB\Commands\Aggregation;

use SMongoDB\Commands\AbstractCollectionCommand;

final class Aggregate extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'pipeline' => 'array',
            'explain' => 'bool',
            'allowDiskUse' => 'bool',
            'cursor' => 'array',
            'maxTimeMS' => 'int',
            'bypassDocumentValidation' => 'bool',
            'readConcern' => 'array',
            'collation' => 'array',
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('aggregate' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}