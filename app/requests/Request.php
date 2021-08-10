<?php

namespace App\Requests;

class Request {
    public function __construct()
    {
        foreach($_REQUEST as $key => $value) {
            $this->{$key} = $value;
        }
        parse_str($_SERVER['QUERY_STRING'], $this->query_params);
    }

    public function all() {
        return $_REQUEST;
    }
}