<?php

namespace SMongoDB\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use stdClass;

abstract class UnitTestCase extends TestCase
{
    protected function getInvalidArrayValues()
    {
        return array(123, 3.14, 'string', true, new stdClass());
    }

    protected function getUnsupportedOptions()
    {
        return array('unsupported1', 'unsupported2');
    }

    protected function getTypeValues()
    {
        return array(
            'array' => array(),
            'string' => 'string',
            'integer' => 1,
            'object' => new stdClass()
        );
    }

    protected function getDifferentTypeValue($type)
    {
        $baseTypes = $this->getTypeValues();
        $type = is_array($type) ? $type : array($type);
        $key = current(array_diff(array_keys($baseTypes), $type));

        return $baseTypes[$key];
    }

    protected function getUri()
    {
        return getenv('MONGODB_URI') ?: 'mongodb://127.0.0.1:27017';
    }

    protected function getDatabaseName()
    {
        return getenv('MONGODB_DATABASE') ?: 'test';
    }

    protected function getIndexName()
    {
        return 'testIndex';
    }

    protected function getCollectionName()
    {
        $class = new ReflectionClass($this);

        return sprintf(
            '%s_%s',
            $class->getShortName(),
            hash('crc32b', $this->getName())
        );
    }
}