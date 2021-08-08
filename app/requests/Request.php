<?php

namespace App\Requests;

class Request {
    public function __construct()
    {
        foreach($_REQUEST as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function all() {
        return $_REQUEST;
    }
}