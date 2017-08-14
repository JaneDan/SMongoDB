<?php

namespace SMongoDB\Options;

final class UriOptions extends AbstractOptions
{
    private static $_REPLICA_SET = array('replicaSet');

    private static $_CONNECTION = array(
        'ssl',
        'connectTimeoutMS',
        'socketTimeoutMS'
    );

    private static $_CONNECTION_POOL = array(
        'maxPoolSize',
        'minPoolSize',
        'maxIdleTimeMS',
        'waitQueueMultiple',
        'waitQueueTimeoutMS'
    );

    private static $_WRITE_CONCERN = array(
        'w',
        'wtimeoutMS',
        'journal'
    );

    private static $_READ_CONCERN = array('readConcernLevel');

    private static $_READ_PREFERENCE = array(
        'readPreference',
        'maxStalenessSeconds',
        'readPreferenceTags'
    );

    private static $_AUTHENTICATION = array(
        'authSource',
        'authMechanism',
        'gssapiServiceName'
    );

    private static $_SERVER = array(
        'localThresholdMS',
        'serverSelectionTimeoutMS',
        'serverSelectionTryOnce',
        'heartbeatFrequencyMS'
    );

    private static $_MISCELLANEOUS = array('uuidRepresentation');

    private static $_MONGO_DRIVER_OPTIONS = array(
        'appname',
        'authMechanismProperties',
        'canonicalizeHostname',
        'password',
        'safe',
        'slaveOk',
        'socketCheckIntervalMS',
        'username'
    );

    protected function getValidKeys(): array
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