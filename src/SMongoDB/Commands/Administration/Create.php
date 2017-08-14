<?php

namespace SMongoDB\Commands\Administration;

use SMongoDB\Commands\AbstractCollectionCommand;

final class Create extends AbstractCollectionCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'capped' => 'bool',
            'autoIndexId' => 'bool',
            'size' => 'integer',
            'max' => 'integer',
            'flags' => 'integer',
            'storageEngine' => 'array',
            'validator' => 'array',
            'validationLevel' => 'string',
            'validationAction' => 'string',
            'indexOptionDefaults' => 'array',
            'viewOn' => 'string',
            'pipeline' => 'array',
            'collation' => 'array',
        );
    }

    public function getCommand(): array
    {
        $cmd = array('create' => $this->_collectionName);
        $cmd += $this->getOptions();

        return $cmd;
    }
}