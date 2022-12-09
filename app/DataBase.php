<?php

namespace App;

use Doctrine\DBAL\{DriverManager, Connection};

class DataBase
{
    private static ?Connection $connection = null;

    public static function getConnection(): ?Connection
    {
        if (self::$connection == null) {
            $connectionParams = [
                'dbname' => $_ENV['DATA_BASE_NAME'],
                'user' => $_ENV['USER'],
                'password' => $_ENV['PASSWORD'],
                'host' => $_ENV['HOST'],
                'driver' => $_ENV['DRIVER'],
            ];

            self::$connection = DriverManager::getConnection($connectionParams);
        }
        return self::$connection;
    }
}
