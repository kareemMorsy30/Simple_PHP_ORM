<?php

namespace App\Database;

use App\Database\DatabaseInterface;
use Config\DatabaseConfig;

class DatabaseAdapterFactory
{
    protected $adapter;

    public function adapter() : DatabaseInterface
    {
        switch (DatabaseConfig::DRIVER) {
            case 'sqlite':
                $this->adapter = new SqliteDatabase();
                break;
            case 'mysql':
                $this->adapter = new MysqliDatabase();
                break;
            default:
                 new \PDOException('Driver not athrowvailable!.');
        }

        return $this->adapter;
    }
}