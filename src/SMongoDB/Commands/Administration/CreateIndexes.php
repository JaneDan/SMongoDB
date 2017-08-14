<?php

namespace SMongoDB\Commands\Administration;

use SMongoDB\Commands\AbstractCollectionCommand;

final class CreateIndexes extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array('indexes' => 'array');
    }

    protected function getCommand(): array
    {
        $cmd = array('createIndexes' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}