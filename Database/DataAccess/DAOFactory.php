<?php

namespace Database\DataAccess;

use Database\DataAccess\Implementations\PostDAOImpl;
use Database\DataAccess\Interfaces\PostDAO;
use Helpers\Settings;
use Database\DataAccess\Implementations\PostDAOMemcachedImpl;

class DAOFactory{
    public static function getPostDAO(): PostDAO
    {
        $driver = Settings::env('DATABASE_DRIVER');

        return match ($driver) {
            'memcached' => new PostDAOMemcachedImpl(),
            default => new PostDAOImpl(),
        };
    }

}