<?php

namespace SMongoDB\Tests\Commands\Administration;

use SMongoDB\Commands\Administration\DropCollection;
use SMongoDB\Exceptions\UnexpectedValueException;
use SMongoDB\Tests\UnitTestCase;

final class DropCollectionUnitTest extends UnitTestCase
{
    private static $_sDropCollection;

    public static function setUpBeforeClass()
    {
        self::$_sDropCollection = new DropCollection();
    }

    /**
     * @expectedException UnexpectedValueException
     * @dataProvider providerUnsupportedOptions
     * @param array $options
     */
    public function testUnsupportedOptions(array $options)
    {
        self::$_sDropCollection->setOptions($options);
    }

    public function providerUnsupportedOptions()
    {
        $options = array();

        foreach ($this->getUnsupportedOptions() as $option) {
            $options[][] = array($option => $option);
        }

        return $options;
    }

}