<?php

namespace SMongoDB\Tests\Commands\Aggregation;

use SMongoDB\Commands\Aggregation\Count;
use SMongoDB\Exceptions\InvalidArgumentException;
use SMongoDB\Exceptions\UnexpectedValueException;
use SMongoDB\Tests\UnitTestCase;

final class CountUnitTest extends UnitTestCase
{
    private static $_sCount;

    public static function setUpBeforeClass()
    {
        self::$_sCount = new Count();
    }

    /**
     * @expectedException UnexpectedValueException
     * @dataProvider providerUnsupportedOptions
     * @param array $options
     */
    public function testUnsupportedOptions($options)
    {
        self::$_sCount->setOptions($options);
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
        self::$_sCount->setOptions($options);
    }

    public function providerSupportedOptionsWithInvalidType()
    {
        $options = array();

        foreach (self::getSupportedOptions() as $option => $type) {
            $options[][] = array($option => $this->getDifferentTypeValue($type));
        }

        return $options;
    }

    private function getSupportedOptions(): array
    {
        return array(
            'query' => 'array',
            'limit' => 'integer',
            'skip' => 'integer',
            'hint' => array('string', 'array'),
            'readConcern' => 'array'
        );
    }
}