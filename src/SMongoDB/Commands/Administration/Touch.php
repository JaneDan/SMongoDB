<?php

namespace SMongoDB\Commands\Administration;

use SMongoDB\Commands\AbstractCollectionCommand;

final class Touch extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'data' => 'bool',
            'index' => 'bool'
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('touch' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}