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
    protected $models = [];
    protected $appends = [];
    private $request;

    function __construct()
    {
        $this->request = new Request();
        $database_adapter = new DatabaseAdapterFactory();
        $this->database_adapter = $database_adapter->adapter();
        $this->loadClassAttributes();
    }

    /**
     * @return array
     */
    function all()
    {
        $this->database_adapter->select($this->table, '*', []);
        return $this->get();
    }

    /**
     * @return object
     */
    function where($condition)
    {
        $condition_params = func_get_args();
        $this->database_adapter->where($this->table, $condition_params);

        return $this;
    }

    function get() {
        $records = $this->database_adapter->execute($this->table);

        foreach ($records as $record) {
            $model = new static;
            foreach ($record as $field => $value) {
                $model->{$field} = $value;
            }
            foreach ($this->appends as $append) {
                $model->{$append} = $model->{'get'.ucfirst($append).'Attribute'}();
            }
            $this->models[] = $model;
        }

        return $this->models;
    }

    function paginate($items = 10) {
        $page = 1;

        if (isset($this->request->page) && is_numeric($this->request->page)) {
            $page = $this->request->page;
        }

        $offset = ($page * $items) - $items;
        $this->database_adapter->paginate($this->table, $items, $offset);
        return $this->get();
    }

    /**
     * @return mixed
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
        $fields = $this->database_adapter->fetchFields($this->table);

        foreach ($fields as $field) {
            $this->$field = null;
        }
    }
}