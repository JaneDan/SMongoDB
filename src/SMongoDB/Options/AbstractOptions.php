<?php

namespace SMongoDB\Options;

use SMongoDB\Exceptions\UnexpectedValueException;

abstract class AbstractOptions
{
    private $_options;

    abstract protected function getValidKeys(): array;

    public function getOptions()
    {
        return isset($this->_options) ? $this->_options : array();
    }

    public function setOptions(array $options)
    {
        $this->checkOptionKeys($options);
        $this->_options = $options;
    }

    private function checkOptionKeys(array $options)
    {
        $validKeys = $this->getValidKeys();
        $invalidKeys = array_diff(array_keys($options), $validKeys);

        if (count($invalidKeys) > 0) {
            sort($validKeys);
            sort($invalidKeys);
            throw new UnexpectedValueException(
                sprintf($this->getFormat($invalidKeys),
                    implode('", "', $invalidKeys),
                    implode('", "', $validKeys))
            );
        }
    }

    private function getFormat($invalidKeys)
    {
        return (count($invalidKeys) > 1
                ? '"%s" are not valid parameters.'
                : '"%s" is not a valid parameter.')
            . ' Allowed parameters are "%s"';
    }
}