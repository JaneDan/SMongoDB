<?php

namespace SMongoDB\Tests\Commands\Administration;

use SMongoDB\Commands\Administration\DropDatabase;
use SMongoDB\Exceptions\UnexpectedValueException;
use SMongoDB\Tests\UnitTestCase;

final class DropDatabaseUnitTest extends UnitTestCase
{
    private static $_sDropDatabase;

    public static function setUpBeforeClass()
    {
        self::$_sDropDatabase = new DropDatabase();
    }

    /**
     * @expectedException UnexpectedValueException
     * @dataProvider providerUnsupportedOptions
     * @param array $options
     */
    public function testUnsupportedOptions(array $options)
    {
        self::$_sDropDatabase->setOptions($options);
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