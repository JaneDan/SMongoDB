<?php

namespace SMongoDB\Commands\Administration;

use SMongoDB\Commands\AbstractCommand;

final class DropDatabase extends AbstractCommand
{
    protected function getSupportedOptions(): array
    {
        return array();
    }

    protected function getCommand(): array
    {
        return array('dropDatabase' => 1);
    }
}