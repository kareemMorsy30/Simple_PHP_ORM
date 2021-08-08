<?php
namespace App\Database;

use App\Database\DatabaseInterface;
use Config\DatabaseConfig;
use App\Database\QueryBuilder;
require('DatabaseInterface.php');
/**
 * SQLite database operations
 */
class SqliteDatabase implements DatabaseInterface {
    /**
     * PDO instance
     * @var type 
     */
    private $pdo;

    /**
     * database
     */
    private $database;

    /**
     * Generated query instance
     */
    private $query;

    public function __construct() {
        $this->database = DatabaseConfig::PATH_TO_SQLITE_FILE;
        $this->query = new QueryBuilder();
        $this->connect();
    }

    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect() {
        try {
            if ($this->pdo === null) {
                $this->pdo = new \PDO("sqlite:" . $this->database);
            }
        } catch(\PDOException $e) {
            $this->pdo = null;
        } 
    }

    function disconnect()
    {
        if (isset($this->pdo) && $this->pdo) {
            $this->pdo = null;
        }
        return $this->pdo;
    }

    /**
     * @param string $table
     * @param array $columns
     * @param array $values
     * @return mixed
     */
    function store($table, $columns, $values) {

    }

    /**
     * @param string $table
     * @param array $conditions
     * @param array $columns
     * @param array $values
     * @return mixed
     */
    function update($table, $columns, $values, $conditions) {

    }

    /**
     * @param string $table
     * @param string $columns
     * @param array $conditions
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    function select($table, $columns, $conditions, $limit = null, $offset = null)
    {
        $query_statement = "SELECT $columns FROM `$table`";
        $query = $this->query->init($query_statement);

        foreach($conditions as $condition) {
            $query->where($condition);
        }

        if (isset($limit)) {
            $query->limit($limit);
        }

        if (isset($offset)) {
            $query->offset($offset);
        }
    }

    /**
     * @param string $table
     * @param array $condition
     * @return mixed
     */
    function where($table, $condition)
    {
        $query_statement = "SELECT * FROM `$table`";

        if (empty($this->query->getQueryString())) {
            $this->query->init($query_statement);
        }

        $this->query->where($condition);

        return $this;
    }

    /**
     * @param string $table
     * @param array $conditions
     * @return mixed
     */
    function delete($table, $conditions){
        
    }

    /**
     * Execute query
     * @return array
     */
    function execute() {
        $result = $this->pdo->query($this->query->getQueryString());
        $this->query->resetQuery();

        if ($result) {
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \PDOException('Query syntax is wrong.');
        }
    }

    /**
     * @param string $table
     * @return array
     */
    function fetchFields($table){
        // $result = $this->pdo->query("PRAGMA table_info($table);");

        // $table = $result->fetchAll();
        // print_r($table);
        //     die();

        // $fields = array_keys($result->fetch(\PDO::FETCH_ASSOC));
        // return $fields;

        // if ($result) {
        //     for ($i = 0; $i < $result->columnCount(); $i++) {
        //         $col = $result->getColumnMeta($i);
        //         $fields[] = $col['name'];
        //     }
        // } else {
        //     throw new \PDOException('Query syntax is wrong.');
        // }
        
        // return $fields;

        $result = $this->pdo->query('SELECT * FROM pragma_table_info("'.$table.'")');

        if ($result) {
            $fields = [];
            foreach($result->fetchAll() as $record) {
                $fields[] = $record['name'];
            }

            return $fields;
        } else {
            throw new \PDOException('Query syntax is wrong.');
        }
    }
}