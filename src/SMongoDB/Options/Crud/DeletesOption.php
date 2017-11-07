<?php

namespace SMongoDB\Options\Crud;

use SMongoDB\AbstractOption;

final class DeletesOption extends AbstractOption
{
    public function getOptions(): array
    {
        return array(
            'deletes' => array(parent::getOptions())
        );
    }

    protected function getSupportedOptions(): array
    {
        return array(
            'q' => 'array',
            'limit' => 'integer',
            'collation' => 'array'
        );
    }
}