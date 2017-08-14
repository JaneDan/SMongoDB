<?php

namespace SMongoDB;

use SMongoDB\Traits\OptionChecker;

abstract class AbstractOption
{
    private $_options = array();

    abstract protected function getSupportedOptions(): array;

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

    protected function setDefaultOptions(array $options)
    {
        $this->setOptions($options);
    }

    private function checkOption($name, $value)
    {
        $supportOptions = $this->getSupportedOptions();
        OptionChecker::checkOptionName($name, $supportOptions);
        OptionChecker::checkOptionValueType($name, $value, $supportOptions[$name]);
    }
}