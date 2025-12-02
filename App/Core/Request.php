<?php

namespace App\Core;

class Request
{
    protected $data;

    public function __construct()
    {
        // Merge GET and POST data
        $this->data = array_merge($_GET, $_POST);
    }

    // Get all input data
    public function all()
    {
        return $this->data;
    }

    // Get only selected keys
    public function only($keys)
    {
        $filtered = [];

        foreach ($keys as $key) {
            if (isset($this->data[$key])) {
                $filtered[$key] = $this->data[$key];
            }
        }

        return $filtered;
    }

    // Get a single value
    public function input($key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    // Detect request method
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    // Check if POST
    public function isPost()
    {
        return $this->method() === 'POST';
    }

    // Check if GET
    public function isGet()
    {
        return $this->method() === 'GET';
    }
}
