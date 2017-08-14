<?php

namespace SMongoDB\Commands;

use MongoDB\Driver\Command;
use SMongoDB\AbstractOption;

abstract class AbstractCommand extends AbstractOption
{
    abstract protected function getCommand(): array;

    public function createCommand()
    {
        return new Command($this->getCommand());
    }
}