<?php

namespace SMongoDB\Commands\Crud;

use SMongoDB\Commands\AbstractCommand;

final class GetMore extends AbstractCommand
{
    private $_cursorId;

    public function __construct($cursorId)
    {
        $this->_cursorId = $cursorId;
    }

    protected function getSupportedOptions(): array
    {
        return array(
            'collection' => 'string',
            'batchSize' => 'int',
            'maxTimeMS' => 'int'
        );
    }

    protected function getCommand(): array
    {
        $cmd = array('getMore' => $this->_cursorId);
        $cmd += $this->getOptions();

        return $cmd;
    }
}