<?php

namespace SMongoDB\Options;

use SMongoDB\AbstractOption;

final class UriOptions extends AbstractOption
{
    private static $_REPLICA_SET = array(
        'replicaSet' => 'string'
    );

    private static $_CONNECTION = array(
        'ssl' => 'bool',
        'connectTimeoutMS' => 'integer',
        'socketTimeoutMS' => 'integer'
    );

    private static $_CONNECTION_POOL = array(
        'maxPoolSize' => 'integer',
        'minPoolSize' => 'integer',
        'maxIdleTimeMS' => 'integer',
        'waitQueueMultiple' => 'integer',
        'waitQueueTimeoutMS' => 'integer'
    );

    private static $_WRITE_CONCERN = array(
        'w' => array('string', 'integer'),
        'wtimeoutMS' => 'integer',
        'journal' => 'bool'
    );

    private static $_READ_CONCERN = array(
        'readConcernLevel' => 'integer'
    );

    private static $_READ_PREFERENCE = array(
        'readPreference' => 'string',
        'maxStalenessSeconds' => 'integer',
        'readPreferenceTags' => 'string'
    );

    private static $_AUTHENTICATION = array(
        'authSource' => 'string',
        'authMechanism' => 'string',
        'gssapiServiceName' => 'string'
    );

    private static $_SERVER = array(
        'localThresholdMS' => 'integer',
        'serverSelectionTimeoutMS' => 'integer',
        'serverSelectionTryOnce' => 'bool',
        'heartbeatFrequencyMS' => 'integer'
    );

    private static $_MISCELLANEOUS = array(
        'uuidRepresentation' => 'string'
    );

    private static $_MONGO_DRIVER_OPTIONS = array(
        'appname' => 'string',
        'authMechanismProperties' => 'array',
        'canonicalizeHostname' => 'bool',
        'password' => 'string',
        'safe' => 'bool',
        'slaveOk' => 'bool',
        'socketCheckIntervalMS' => 'integer',
        'username' => 'string'
    );

    protected function getSupportedOptions(): array
    {
        return array_merge(
            self::$_REPLICA_SET,
            self::$_CONNECTION,
            self::$_CONNECTION_POOL,
            self::$_WRITE_CONCERN,
            self::$_READ_CONCERN,
            self::$_READ_PREFERENCE,
            self::$_AUTHENTICATION,
            self::$_SERVER,
            self::$_MISCELLANEOUS,
            self::$_MONGO_DRIVER_OPTIONS
        );
    }
}