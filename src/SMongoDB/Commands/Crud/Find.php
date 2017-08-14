<?php

namespace SMongoDB\Commands\Crud;

use SMongoDB\Commands\AbstractCollectionCommand;

final class Find extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'filter' => 'array',
            'sort' => 'array',
            'projection' => 'array',
            'hint' => array('array', 'string'),
            'skip' => 'integer',
            'limit' => 'integer',
            'batchSize' => 'integer',
            'singleBatch' => 'bool',
            'comment' => 'string',
            'maxScan' => 'integer',
            'maxTimeMS' => 'integer',
            'readConcern' => 'array',
            'max' => 'array',
            'min' => 'array',
            'returnKey' => 'bool',
            'showRecordId' => 'bool',
            'snapshot' => 'bool',
            'tailable' => 'bool',
            'oplogReplay' => 'bool',
            'noCursorTimeout' => 'bool',
            'awaitData' => 'bool',
            'allowPartialResults' => 'bool',
            'collation' => 'array'
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('find' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}