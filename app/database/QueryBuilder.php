<?php
namespace App\Database;

class QueryBuilder {
    private $query;
    private $condition_applied = false;
    private $order_applied = false;

    public function init($query) {
        $this->query = $query;

        return $this;
    }

    public function where($condition) {
        $condition[0] = '`'.$condition[0].'`';

        if (count($condition) === 2) {
            $condition = array($condition[0], '=', "'$condition[1]'");
        } else if(count($condition) === 3) {
            $condition[2] = "'$condition[2]'";
        }

        $condition_string = implode(" ", $condition);
        

        if (!$this->condition_applied) {
            $this->query .= " WHERE $condition_string";
            $this->condition_applied = true;
        } else {
            $this->query .= " AND $condition_string";
        }

        return $this;
    }

    public function orWhere($condition) {
        $condition[0] = '`'.$condition[0].'`';

        if (count($condition) === 2) {
            $condition = array($condition[0], '=', "'$condition[1]'");
        } else if(count($condition) === 3) {
            $condition[2] = "'$condition[2]'";
        }

        $condition_string = implode(" ", $condition);
        

        if (!$this->condition_applied) {
            $this->query .= " WHERE $condition_string";
            $this->condition_applied = true;
        } else {
            $this->query .= " OR $condition_string";
        }

        return $this;
    }

    public function orderBy($column, $order = 'ASC') {
        if (!$this->order_applied) {
            $this->query .= " ORDER BY `$column` $order";
            $this->order_applied = true;
        } else {
            $this->query .= ", $column $order";
        }

        return $this;
    }

    public function whereNull($column) {
        if (!$this->condition_applied) {
            $this->query .= " WHERE $column IS NULL";
            $this->condition_applied = true;
        } else {
            $this->query .= " AND $column IS NULL";
        }

        return $this;
    }

    public function limit($limit) {
        $this->query .= " LIMIT $limit";

        return $this;
    }

    public function offset($offset) {
        $this->query .= " OFFSET $offset";

        return $this;
    }

    public function getQueryString() {
        return $this->query;
    }

    public function resetQuery() {
        $this->query = null;
    }
}