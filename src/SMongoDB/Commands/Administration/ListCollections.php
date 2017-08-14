<?php

namespace SMongoDB\Commands\Administration;

use SMongoDB\Commands\AbstractCollectionCommand;

final class ListCollections extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array('filter' => 'array');
    }

    protected function getCommand(): array
    {
        $cmd = array('listCollections' => 1);
        $cmd += $this->getOptions();

        return $cmd;
    }
}