<?php

namespace SMongoDB\Commands;

use MongoDB\Driver\Command;
use SMongoDB\Traits\ParamChecker;


abstract class AbstractCommand
{
    private $_options = array();

    abstract protected function getSupportedOptions(): array;

    abstract protected function getCommand(): array;

    public function __set($name, $value)
    {
        $this->checkParam($name, $value);
        $this->_options[$name] = $value;
    }

    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $this->__set($key, $value);
        }
    }

    public function getOptions(): array
    {
        return $this->_options;
    }

    public function createCommand()
    {
        return new Command($this->getCommand());
    }

    private function checkParam($name, $value)
    {
        $supportOptions = $this->getSupportedOptions();
        ParamChecker::checkParamName($name, $supportOptions);
        ParamChecker::checkParamValueType($name, $value, $supportOptions[$name]);
    }
}