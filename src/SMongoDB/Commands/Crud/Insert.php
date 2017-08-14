<?php

namespace SMongoDB\Commands\Crud;

use SMongoDB\Commands\AbstractCollectionCommand;

final class Insert extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'documents' => 'array',
            'ordered' => 'bool',
            'writeConcern' => 'array',
            'bypassDocumentValidation' => 'bool'
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('insert' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}