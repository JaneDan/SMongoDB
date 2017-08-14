<?php

namespace SMongoDB\Traits;

use SMongoDB\Exceptions\InvalidArgumentException;
use SMongoDB\Exceptions\UnexpectedValueException;

trait OptionChecker
{
    public static function checkOptionName($name, $supportOptions)
    {
        if (!array_key_exists($name, $supportOptions)) {
            throw new UnexpectedValueException(
                sprintf('"%s" is not a valid parameter.  Allowed parameters are "%s"',
                    $name, implode('", "', array_keys($supportOptions)))
            );
        }
    }

    public static function checkOptionValueType($name, $value, $type)
    {
        $ok = false;

        if (is_string($type)) {
            $ok = self::check($type, $value);
        } else if (is_array($type)) {
            foreach ($type as $item) {
                $ok = self::check($item, $value);
                if ($ok) break;
            }
        }

        if (!$ok) {
            throw InvalidArgumentException::InvalidType(
                '\"' . $name .'\" option',
                $value,
                is_string($type) ? $type : implode('" | "', $type));
        }
    }

    private static function check($type, $value)
    {
        $checkMethod = 'is_' . $type;

        if (function_exists($checkMethod)) {
            $ok = $checkMethod($value);
        } else {
            $ok = $value instanceof $type;
        }

        return $ok;
    }

}