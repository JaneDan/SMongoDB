<?php

namespace SMongoDB\Commands\Administration;

use SMongoDB\Commands\AbstractCollectionCommand;

final class ListIndexes extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array();
    }

    protected function getCommand(): array
    {
        $cmd = array('listIndexes' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}