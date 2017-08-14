<?php

namespace SMongoDB\Commands\Administration;

use SMongoDB\Commands\AbstractCollectionCommand;

final class DropIndexes extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array('index' => 'string');
    }

    protected function getCommand(): array
    {
        $cmd = array('dropIndexes' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}