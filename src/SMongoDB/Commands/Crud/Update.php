<?php

namespace SMongoDB\Commands\Crud;

use SMongoDB\Commands\AbstractCollectionCommand;

final class Update extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'updates' => 'array',
            'ordered' => 'bool',
            'writeConcern' => 'array',
            'bypassDocumentValidation' => 'bool'
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('update' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}