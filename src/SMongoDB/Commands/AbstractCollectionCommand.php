<?php

namespace SMongoDB\Commands;

abstract class AbstractCollectionCommand extends AbstractCommand
{
    protected $_collectionName;

    public function setCollectionName(string $collectionName)
    {
        $this->_collectionName = $collectionName;
    }
}