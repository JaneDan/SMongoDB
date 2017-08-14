<?php

namespace SMongoDB\Commands\Crud;

use SMongoDB\Commands\AbstractCommand;

final class ResetError extends AbstractCommand
{
    protected function getSupportedOptions(): array
    {
        return array();
    }

    protected function getCommand(): array
    {
        $cmd = array('resetError' => 1);
        $cmd += $this->getOptions();

        return $cmd;
    }
}