<?php

namespace Database;

use Helpers\Settings;
use Memcached;

class DatabaseManager
{
    protected static array $mysqliConnections = [];
    protected static array $memcachedConnections = [];

    public static function getMysqliConnection(string $connectionName = 'default'): MySQLWrapper
    {
        if (!isset(static::$mysqliConnections[$connectionName])) {
            static::$mysqliConnections[$connectionName] = new MySQLWrapper();
        }

        return static::$mysqliConnections[$connectionName];
    }

    public static function getMemcachedConnection(string $connectionName = 'default'): Memcached
    {
        if (!isset(static::$memcachedConnections[$connectionName])) {
            $memcached = new Memcached();
            $memcached->addServer(Settings::env('MEMCACHED_HOST'), Settings::env('MEMCACHED_PORT'));
            static::$memcachedConnections[$connectionName] = $memcached;
        }

        return static::$memcachedConnections[$connectionName];
    }
}
