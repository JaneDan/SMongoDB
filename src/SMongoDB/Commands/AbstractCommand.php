<?php

namespace SMongoDB\Commands;

use MongoDB\Driver\Command;
use SMongoDB\Traits\OptionChecker;


abstract class AbstractCommand
{
    private $_options = array();

    abstract protected function getSupportedOptions(): array;

    abstract protected function getCommand(): array;

    public function __set($name, $value)
    {
        $this->checkOption($name, $value);
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

    private function checkOption($name, $value)
    {
        $supportOptions = $this->getSupportedOptions();
        OptionChecker::checkOptionName($name, $supportOptions);
        OptionChecker::checkOptionValueType($name, $value, $supportOptions[$name]);
    }
}