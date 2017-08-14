<?php

namespace SMongoDB\Tests\Commands\Administration;

use SMongoDB\Commands\Administration\Create;
use SMongoDB\Exceptions\InvalidArgumentException;
use SMongoDB\Exceptions\UnexpectedValueException;
use SMongoDB\Tests\UnitTestCase;

class CreateUnitTest extends UnitTestCase
{
    private static $_sCreate;

    public static function setUpBeforeClass()
    {
        self::$_sCreate = new Create();
    }

    /**
     * @expectedException UnexpectedValueException
     * @dataProvider providerUnsupportedOptions
     * @param array $options
     */
    public function testUnsupportedOptions($options)
    {
        self::$_sCreate->setOptions($options);
    }

    public function providerUnsupportedOptions()
    {
        $options = array();

        foreach ($this->getUnsupportedOptions() as $option) {
            $options[][] = array($option => $option);
        }

        return $options;
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider providerSupportedOptionsWithInvalidType
     * @param array $options
     */
    public function testSupportOptionsWithInvalidType(array $options)
    {
        self::$_sCreate->setOptions($options);
    }

    public function providerSupportedOptionsWithInvalidType()
    {
        $options = array();

        foreach (self::getSupportedOptions() as $option => $type) {
            $options[][] = array($option => $this->getDifferentTypeValue($type));
        }

        return $options;
    }

    private static function getSupportedOptions(): array
    {
        return array(
            'capped' => 'bool',
            'autoIndexId' => 'bool',
            'size' => 'integer',
            'max' => 'integer',
            'flags' => 'integer',
            'storageEngine' => 'array',
            'validator' => 'array',
            'validationLevel' => 'string',
            'validationAction' => 'string',
            'indexOptionDefaults' => 'array',
            'viewOn' => 'string',
            'pipeline' => 'array',
            'collation' => 'array',
        );
    }
}