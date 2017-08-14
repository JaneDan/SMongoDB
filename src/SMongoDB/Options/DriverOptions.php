<?php

namespace SMongoDB\Options;

final class DriverOptions extends AbstractOptions
{
    private static $_MONGO_DRIVER_OPTIONS = array(
        'allow_invalid_hostname',
        'ca_dir',
        'ca_file',
        'crl_file',
        'pem_file',
        'pem_pwd',
        'context',
        'weak_cert_validation'
    );

    private static $_CURSOR_TYPE_MAP = array('typeMap');

    protected function getValidKeys(): array
    {
        return array_merge(
            self::$_MONGO_DRIVER_OPTIONS,
            self::$_CURSOR_TYPE_MAP
        );
    }
}