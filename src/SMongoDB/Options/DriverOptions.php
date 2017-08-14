<?php

namespace SMongoDB\Options;

use SMongoDB\AbstractOption;

final class DriverOptions extends AbstractOption
{
    private static $_MONGO_DRIVER_OPTIONS = array(
        'allow_invalid_hostname' => 'bool',
        'ca_dir' => 'string',
        'ca_file' => 'string',
        'crl_file' => 'string',
        'pem_file' => 'string',
        'pem_pwd' => 'string',
        'context' => 'resource',
        'weak_cert_validation' => 'bool'
    );

    private static $_CURSOR_TYPE_MAP = array(
        'typeMap' => array('array', null)
    );

    protected function getSupportedOptions(): array
    {
        return array_merge(
            self::$_MONGO_DRIVER_OPTIONS,
            self::$_CURSOR_TYPE_MAP
        );
    }
}