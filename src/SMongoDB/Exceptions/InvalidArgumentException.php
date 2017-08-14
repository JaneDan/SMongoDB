<?php

namespace SMongoDB\Exceptions;

final class InvalidArgumentException
    extends \MongoDB\Driver\Exception\InvalidArgumentException
    implements IException
{
    public static function InvalidType($name, $value, $expectedType)
    {
        return new static(
            sprintf(
                'Expected %s to have type "%s" but found "%s"',
                $name,
                $expectedType,
                is_object($value) ? get_class($value) : gettype($value))
        );
    }
}