<?php

namespace SMongoDB;

use SMongoDB\Options\DriverOptions;
use SMongoDB\Options\UriOptions;

final class ClientBuilder
{
    private static $_sDefaultUri = 'mongodb://127.0.0.1:27017/';
    private $_uriOptions;
    private $_driverOptions;
    private $_uri;

    private function __construct()
    {
        $this->_uriOptions = new UriOptions();
        $this->_driverOptions = new DriverOptions();
    }

    public static function create()
    {
        return new static();
    }

    public function build()
    {
        return new Client(
            $this->getUri(),
            $this->_uriOptions->getOptions(),
            $this->_driverOptions->getOptions()
        );
    }

    public function setUriOptions(array $uriOptions)
    {
        $this->_uriOptions->setOptions($uriOptions);

        return $this;
    }

    public function setDriverOptions(array $driverOptions)
    {
        $this->_driverOptions->setOptions($driverOptions);

        return $this;
    }

    public function setUri(string $uri)
    {
        $this->_uri = $uri;

        return $this;
    }

    private function getUri(): string
    {
        return isset($this->_uri)
            ? $this->_uri
            : self::$_sDefaultUri;
    }
}