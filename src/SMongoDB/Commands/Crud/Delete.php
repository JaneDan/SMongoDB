<?php

namespace SMongoDB\Commands\Crud;

use SMongoDB\Commands\AbstractCollectionCommand;

final class Delete extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'deletes' => 'array',
            'ordered' => 'bool',
            'writeConcern' => 'array'
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('delete' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}