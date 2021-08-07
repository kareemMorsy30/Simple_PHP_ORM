<?php

namespace App\Database;

interface DatabaseInterface{

    /**
     * @return bool
     */
    function connect();

    /**
     * @return void
     */
    function disconnect();

    /**
     * @param string $table
     * @param array $columns
     * @param array $values
     * @return mixed
     */
    function store($table, $columns, $values);

    /**
     * @param string $table
     * @param array $conditions
     * @param array $columns
     * @param array $values
     * @return mixed
     */
    function update($table, $columns, $values, $conditions);

    /**
     * @param string $table
     * @param string $columns
     * @param array $conditions
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    function select($table, $columns,  $conditions, $limit = null, $offset = null);

        /**
     * @param string $table
     * @param array $condition
     * @return mixed
     */
    function where($table, $condition);

    /**
     * @param string $table
     * @param array $conditions
     * @return mixed
     */
    function delete($table, $conditions);

    /**
     * @param string $table
     * @return array
     */
    function fetchFields($table);

    /**
     * Execute query
     * @return array
     */
    function execute();
}