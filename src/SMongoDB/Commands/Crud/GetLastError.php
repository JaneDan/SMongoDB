<?php

namespace SMongoDB\Commands\Crud;

use SMongoDB\Commands\AbstractCommand;

final class GetLastError extends AbstractCommand
{
    protected function getSupportedOptions(): array
    {
        return array(
            'j' => 'bool',
            'w' => array('integer', 'string'),
            'wtimeout' => 'integer'
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('getLastError' => 1);
        $cmd += $this->getOptions();

        return $cmd;
    }
}