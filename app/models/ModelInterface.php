<?php

namespace App\Models;

interface ModelInterface {
    function loadClassAttributes();

    function find($id);

    function save();

    function all();
}