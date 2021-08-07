<?php

namespace Config;

final class DatabaseConfig {
    /**
    * Database drivers
    */
    const DRIVER = 'sqlite';

    /* 
    possible available drivers [
        'sqlite',
        'mysql'
    ] 
    */

    /**
    * path to the sqlite file
    */
    const PATH_TO_SQLITE_FILE = 'db/sample.db';

    /**
    * database host
    */
    const HOST = 'localhost';

    /**
    * database username
    */
    const USERNAME = 'root';

    /**
    * database user password
    */
    const PASSWORD = '';

    /**
    * database name
    */
    const DATABASE_NAME = '';

    /**
    * database port
    */
    const PORT = 3306;

    private function __construct() {}
}