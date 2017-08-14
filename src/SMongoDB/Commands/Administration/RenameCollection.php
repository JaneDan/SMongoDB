<?php

namespace SMongoDB\Commands\Administration;


use SMongoDB\Commands\AbstractCommand;

final class RenameCollection extends AbstractCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'renameCollection' => 'string',
            'to' => 'string',
            'dropTarget' => 'bool'
        );
    }

    protected function getCommand(): array
    {
        return $this->getOptions();
    }
}