<?php

namespace SMongoDB\Commands\Diagnostic;

use SMongoDB\Commands\AbstractCommand;

final class ListDatabases extends AbstractCommand
{
    protected function getSupportedOptions(): array
    {
        return array();
    }

    protected function getCommand(): array
    {
        $cmd = array('listDatabases' => 1);
        $cmd += $this->getOptions();

        return $cmd;
    }
}