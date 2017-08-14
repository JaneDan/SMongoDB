<?php

namespace SMongoDB\Commands\Crud;

use SMongoDB\Commands\AbstractCollectionCommand;

final class ParallelCollectionScan extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'numCursors' => 'integer',
            'readConcern' => 'array',
            'maxTimeMS' => 'integer'
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('parallelCollectionScan' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}