<?php

namespace App\Models;

use App\Models\ModelInterface;
use Config\DatabaseConfig;
use App\Database\DatabaseAdapterFactory;
use App\Database\SqliteDatabase;
use App\Requests\Request;

class Model implements ModelInterface {
    protected $table;
    private $database_adapter;
    protected $models = [];     // Array of current class instance
    protected $appends = [];        // Append accessor fields to the model class
    private $request;

    function __construct()
    {
        $this->request = new Request();
        // Call database adapter factory which determines database adapter to use on its own and return its instance to use
        $database_adapter = new DatabaseAdapterFactory();
        // Calling adapter method to get the database adapter instance
        $this->database_adapter = $database_adapter->adapter();
        // Load model fields as a class attribute
        $this->loadClassAttributes();
    }

    /**
     * Return all table records
     * @return array
     */
    function all()
    {
        $this->database_adapter->select($this->table, '*', []);
        return $this->get();    // calling execute mthod in the adapter
    }

    /**
     * @param mixed $condition
     * @return object
     */
    function where($condition)
    {
        // Get all arguments as an array
        $condition_params = func_get_args(); 
        // Pass table name and an array that represents the condition operands       
        $this->database_adapter->where($this->table, $condition_params);

        return $this;
    }

    /**
     * @param mixed $condition
     * @return object
     */
    function orWhere($condition)
    {
        // Get all arguments as an array
        $condition_params = func_get_args();
        // Pass table name and an array that represents the condition operands
        $this->database_adapter->orWhere($this->table, $condition_params);

        return $this;
    }

    /**
     * @return object
     */
    function get() {
        // Call execute method on database adapter to execute the resulted query of the query builder
        $records = $this->database_adapter->execute($this->table);

        foreach ($records as $record) {
            // Create an instance from each record of the current class calling the method at runtime (late static binding)
            $model = new static;
            // Add table column as model class fields
            foreach ($record as $field => $value) {
                $model->{$field} = $value;
            }
            // Add appended fields as model class fields
            foreach ($this->appends as $append) {
                $model->{$append} = $model->{'get'.ucfirst($append).'Attribute'}();
            }
            $this->models[] = $model;
        }

        return $this->models;
    }

    /**
     * Same as get function but before calling it paginate function limits data using page query parameter (pagination)
     * @return object
     */
    function paginate($items = 10) {
        $page = 1;

        if (isset($this->request->page) && is_numeric($this->request->page)) {
            $page = $this->request->page;
        }

        // Calculate the number of records to skip
        $offset = ($page * $items) - $items;

        // Call the adapter paginate method which in its turn calls query builder limit and offset methods
        $this->database_adapter->paginate($this->table, $items, $offset);

        // Continue by executing the resulted builder query statement
        return $this->get();
    }

    /**
     * @return object
     */
    function save()
    {
        // todo: Complete the Implementation of this method
        $fields = $this->database_adapter->fetchFields($this->table);
        if (isset($this->id)) {
            return $this->database_adapter->update($this->table, $fields, (array)$this, ['id' => ['=', $this->id, '']]);
        }
        return $this->database_adapter->store($this->table, $fields, (array)$this);
    }

    /**
     * @param $id
     * @return object
     */
    function find($id)
    {
    }

    /**
     * Append model attributes
     * @return null
     */
    function loadClassAttributes()
    {
        // Use adapter fetch fields method that returns an array of columns
        $fields = $this->database_adapter->fetchFields($this->table);

        // Set columns as the current class instance attributes
        foreach ($fields as $field) {
            $this->$field = null;
        }
    }
}