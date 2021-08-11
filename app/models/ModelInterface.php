<?php

namespace App\Models;

interface ModelInterface {
    /**
     * @return null
     */
    function loadClassAttributes();

    /**
     * @param $id
     * @return object
     */
    function find($id);

    /**
     * @return object
     */
    function save();

    /**
     * @return array
     */
    function all();
}