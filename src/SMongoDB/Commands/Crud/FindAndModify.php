<?php

namespace SMongoDB\Commands\Crud;

use SMongoDB\Commands\AbstractCollectionCommand;

final class FindAndModify extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'query' => 'array',
            'sort' => 'array',
            'remove' => 'bool',
            'update' => 'array',
            'new' => 'bool',
            'fields' => 'array',
            'upsert' => 'bool',
            'bypassDocumentValidation' => 'bool',
            'writeConcern' => 'array',
            'collation' => 'array'
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('findAndModify' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}