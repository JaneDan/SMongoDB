<?php

namespace SMongoDB\Exceptions;

final class UnexpectedValueException
    extends \MongoDB\Driver\Exception\UnexpectedValueException
    implements IException
{
}