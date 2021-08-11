<?php

namespace App\Database;

use App\Database\DatabaseInterface;
use Config\DatabaseConfig;

// A class factory that is used to get appropriate database adapter based on database configuration
class DatabaseAdapterFactory
{
    protected $adapter;

    public function adapter() : DatabaseInterface  // return a class instance that implements DatabaseInterface interface
    {
        // Constant attribute driver in DatabaseConfig class will detect the adapter required
        switch (DatabaseConfig::DRIVER) {
            case 'sqlite':
                $this->adapter = new SqliteDatabase();
                break;
            case 'mysql':
                $this->adapter = new MysqliDatabase();
                break;
            default:
                throw new \PDOException('Driver not available!.');
        }

        return $this->adapter;
    }
}