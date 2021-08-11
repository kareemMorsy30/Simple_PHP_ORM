<?php
namespace App\Database;

use App\Database\DatabaseInterface;
use Config\DatabaseConfig;

/**
 * MySQLi database operations
 * This class is added as an example for other database adapters but it is not ready for actual use
 */
class MysqliDatabase implements DatabaseInterface {
    /**
     * PDO instance
     * @var type 
     */
    private $pdo;

    private $host;

    private $username;

    private $password;

    private $database_name;

    private $port;

    /**
     * Generated query instance
     */
    private $query;

    /**
     * Set database configuration using database configuration class
     */
    protected function __construct() {
        // Set class attributes required to connect to the MySQL database based on Database configuration class const attributes
        $this->host = DatabaseConfig::HOST;
        $this->username = DatabaseConfig::USERNAME;
        $this->password = DatabaseConfig::PASSWORD;
        $this->database_name = DatabaseConfig::DATABASE_NAME;
        $this->port = DatabaseConfig::PORT;
    }

    /**
     * return in instance of the PDO object that connects to the MySQL database
     * @return \PDO
     */
    public function connect() {
        /**
         * Only try to connect if the pdo attribute is null which means that the database is disconnected
         */ 
        if ($this->pdo == null) {
            try {
                // Use class attributes initialized in the class constructor to connect to the database
                $this->pdo = new \PDO("mysql:host=$this->host;dbname=$this->database_name", $this->username, $this->password);
                // set the PDO error mode to exception
                $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch(\PDOException $e) {
                $this->pdo = null;
            }
        }
        return $this->pdo;
    }

    function disconnect()
    {
        if (isset($this->pdo) && $this->pdo) {
            $this->pdo = null;
        }
        return $this->pdo;
    }

    /**
     * @param string $tableName
     * @param array $columns
     * @param array $values
     * @return mixed
     */
    function store($tableName, $columns, $values) {

    }

    /**
     * @param string $tableName
     * @param array $conditions
     * @param array $columns
     * @param array $values
     * @return mixed
     */
    function update($tableName, $columns, $values, $conditions) {

    }

    /**
     * @param string $tableName
     * @param string $columns
     * @param array $conditions
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    function select($tableName, $columns, $conditions, $limit = null, $offset = null)
    {

    }

        /**
     * @param string $table
     * @param array $condition
     * @return mixed
     */
    function where($table, $condition)
    {

    }

    /**
     * @param string $tableName
     * @param array $conditions
     * @return mixed
     */
    function delete($tableName, $conditions){
        
    }

    /**
     * Execute query
     * @return array
     */
    function execute() {
        $result = $this->pdo->query($this->query->getQueryString());

        if ($result) {
            return $result->fetchAll();
        } else {
            throw new \PDOException('Query syntax is wrong.');
        }
    }

    /**
     * @param string $tableName
     * @return array
     */
    function fetchFields($tableName){

    }
}