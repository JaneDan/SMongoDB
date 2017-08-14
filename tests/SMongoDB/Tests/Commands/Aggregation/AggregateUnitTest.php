<?php

namespace SMongoDB\Tests\Commands\Aggregation;

use SMongoDB\Commands\Aggregation\Aggregate;
use SMongoDB\Exceptions\InvalidArgumentException;
use SMongoDB\Exceptions\UnexpectedValueException;
use SMongoDB\Tests\UnitTestCase;

final class AggregateUnitTest extends UnitTestCase
{
    private static $_sAggregate;

    public static function setUpBeforeClass()
    {
        self::$_sAggregate = new Aggregate();
    }

    /**
     * @expectedException UnexpectedValueException
     * @dataProvider providerUnsupportedOptions
     * @param array $options
     */
    public function testUnsupportedOptions($options)
    {
        self::$_sAggregate->setOptions($options);
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
        self::$_sAggregate->setOptions($options);
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
            'pipeline' => 'array',
            'explain' => 'bool',
            'allowDiskUse' => 'bool',
            'cursor' => 'array',
            'maxTimeMS' => 'int',
            'bypassDocumentValidation' => 'bool',
            'readConcern' => 'array',
            'collation' => 'array',
        );
    }
}