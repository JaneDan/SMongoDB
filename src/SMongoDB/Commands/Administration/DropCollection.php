<?php

namespace SMongoDB\Commands\Administration;

use SMongoDB\Commands\AbstractCollectionCommand;

final class DropCollection extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array();
    }

    protected function getCommand(): array
    {
        return array('drop' => $this->_collectionName);
    }
}