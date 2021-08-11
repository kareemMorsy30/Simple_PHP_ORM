<?php
namespace App\Database;

/**
 * A builder class that defines many steps to build a query
 */ 
class QueryBuilder {
    private $query;  // query statement
    private $condition_applied = false;    // where condition is added before
    private $order_applied = false;     // order by is added before

    /**
     * Initialize the query statement
     * @param string $query
     * @return object $this
     */
    public function init($query) {
        $this->query = $query;

        return $this;
    }

    /**
     * Append where clause to the query statement
     * @param array $condition
     * @return object $this
     */
    public function where($condition) {
        $condition[0] = '`'.$condition[0].'`';

        if (count($condition) === 2) {      // If only two arguments are passed then the condition used is equal (=)
            $condition = array($condition[0], '=', "'$condition[1]'");
        } else if(count($condition) === 3) {        // If three arguments passed then use the second argument as a condition operator
            $condition[2] = "'$condition[2]'";
        }

        // Group array elements to a string having spaces to concate it to the query statement
        $condition_string = implode(" ", $condition);
        
        // If it is the first time to perform a where condition operation
        if (!$this->condition_applied) {
            $this->query .= " WHERE $condition_string";     // Add Where clause
            $this->condition_applied = true;
        } else {
            $this->query .= " AND $condition_string";       // Else add AND operator for more conditions
        }

        return $this;
    }

    /**
     * Append or where clause to the query statement
     * @param array $condition
     * @return object $this
     */
    public function orWhere($condition) {
        $condition[0] = '`'.$condition[0].'`';

        if (count($condition) === 2) {      // If only two arguments are passed then the condition used is equal (=)
            $condition = array($condition[0], '=', "'$condition[1]'");
        } else if(count($condition) === 3) {        // If three arguments passed then use the second argument as a condition operator
            $condition[2] = "'$condition[2]'";
        }

        // Group array elements to a string having spaces to concate it to the query statement
        $condition_string = implode(" ", $condition);
        

        if (!$this->condition_applied) {
            $this->query .= " WHERE $condition_string";     // Add Where clause
            $this->condition_applied = true;
        } else {
            $this->query .= " OR $condition_string";       // Else add OR operator for more conditions
        }

        return $this;
    }

    /**
     * Append order by clause to the query statement
     * @param string $column
     * @param string $order
     * @return object $this
     */
    public function orderBy($column, $order = 'ASC') {
        // If it is the first time to perform a order by operation
        if (!$this->order_applied) {
            $this->query .= " ORDER BY `$column` $order";       // Add order by clause
            $this->order_applied = true;        // Set flag to true for chaining
        } else {
            $this->query .= ", $column $order";         // Else add "," for more columns to order
        }

        return $this;
    }

    /**
     * Append where is null clause to the query statement
     * @param string $column
     * @return object $this
     */
    public function whereNull($column) {
        // If it is the first time to perform a where condition operation
        if (!$this->condition_applied) {
            $this->query .= " WHERE $column IS NULL";       // Add Where clause with IS NULL after column value
            $this->condition_applied = true;
        } else {
            $this->query .= " AND $column IS NULL";         // Else add AND operator for more conditions
        }

        return $this;
    }

    /**
     * Append limit clause to the query statement
     * @param int $limit
     * @return object $this
     */
    public function limit($limit) {
        $this->query .= " LIMIT $limit";

        return $this;
    }

    /**
     * Append offset clause to the query statement
     * @param int $offset
     * @return object $this
     */
    public function offset($offset) {
        $this->query .= " OFFSET $offset";

        return $this;
    }

    /**
     * Get built query (getter for query attribute)
     * @return string
     */
    public function getQueryString() {
        return $this->query;
    }

    /**
     * Used to reset query string after query statement execution (setter for query attribute)
     * @return string
     */
    public function resetQuery() {
        $this->query = null;
    }
}