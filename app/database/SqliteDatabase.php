<?php
namespace App\Database;

use App\Database\DatabaseInterface;
use Config\DatabaseConfig;
use App\Database\QueryBuilder;

/**
 * SQLite database operations
 * This class is considered to be a director for the query builder which defines the order of execution of builder functions to build a query
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

    /**
     * Set database configuration using database configuration class
     */
    public function __construct() {
        // Set the actual path to the database file using database configuration class
        $this->database = DatabaseConfig::PATH_TO_SQLITE_FILE;
        // get a query builder object
        $this->query = new QueryBuilder();
        // connect to the database using class connect method
        $this->connect();
        // Registers a REGEX User Defined annonymous Function for use in SQL statements
        $this->pdo->sqliteCreateFunction('regexp', function ($pattern, $string) {
            if(preg_match('/'.$pattern.'/', $string)) {
                return true;
            }
            return false;
        }, 2);
    }

    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect() {
        try {
            // If pdo is null (not connected) then create a new connection by PDO class instanciation
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
            $this->pdo = null;      // Setting pdo object to null to disconnect
        }
        return $this->pdo;
    }

    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @param string $table
     * @return null
     */
    function prepareSelect($table) {
        $query_statement = "SELECT * FROM `$table`";

        if (empty($this->query->getQueryString())) {
            // If no query statement yet then initialize a select query
            $this->query->init($query_statement);
        }
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
        // Initialize select query
        $query = $this->query->init($query_statement);

        // Based on an array of arrays that represent each condition
        foreach($conditions as $condition) {
            $query->where($condition);      // Add where clause to each one of the queries
        }

        // Set a limit to the query result
        if (isset($limit)) {
            $query->limit($limit);
        }

        // Set an offset to the query result
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
        // Prepare select statement if not already initialized
        $this->prepareSelect($table);

        // Apply where clause to the query
        $this->query->where($condition);

        return $this;
    }

    /**
     * @param string $table
     * @param array $condition
     * @return mixed
     */
    function orWhere($table, $condition)
    {
        // Prepare select statement if not already initialized
        $this->prepareSelect($table);

        // Apply or where clause to the query
        $this->query->orWhere($condition);

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
    function execute($table = null) {
        // Prepare select statement if not already initialized
        $this->prepareSelect($table);

        // Get final query statement and execute it with PDO
        $result = $this->pdo->query($this->query->getQueryString());
        $this->query->resetQuery();

        if ($result) {
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \PDOException('Query syntax is wrong.');
        }
    }

    /**
     * Paginate data using query builder class methods limit and offset
     * @return array
     */
    function paginate($table, $limit, $offset) {
        // Prepare select statement if not already initialized
        $this->prepareSelect($table);

        // use limit and offset functions of query adapter to paginate data
        $this->query->limit($limit)->offset($offset);
    }

    /**
     * Fetch passed table fields
     * @param string $table
     * @return array
     */
    function fetchFields($table){
        // Execute this query in sqlite to get table columns
        $result = $this->pdo->query('SELECT * FROM pragma_table_info("'.$table.'")');

        if ($result) {
            $fields = [];
            foreach($result->fetchAll() as $record) {
                // return columns as records its name is "name" and append it to fields array
                $fields[] = $record['name'];
            }

            return $fields;
        } else {
            throw new \PDOException('Query syntax is wrong.');
        }
    }
}