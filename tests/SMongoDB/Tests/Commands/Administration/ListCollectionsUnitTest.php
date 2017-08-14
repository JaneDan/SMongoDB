<?php

namespace SMongoDB\Tests\Commands\Administration;

use SMongoDB\Commands\Administration\ListCollections;
use SMongoDB\Exceptions\InvalidArgumentException;
use SMongoDB\Exceptions\UnexpectedValueException;
use SMongoDB\Tests\UnitTestCase;

final class ListCollectionsUnitTest extends UnitTestCase
{
    private static $_sListCollections;

    public static function setUpBeforeClass()
    {
        self::$_sListCollections = new ListCollections();
    }

    /**
     * @expectedException UnexpectedValueException
     * @dataProvider providerUnsupportedOptions
     * @param array $options
     */
    public function testUnsupportedOptions(array $options)
    {
        self::$_sListCollections->setOptions($options);
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
        self::$_sListCollections->setOptions($options);
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
        return array('filter' => 'array');
    }
}