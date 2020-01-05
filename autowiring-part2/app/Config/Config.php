<?php

namespace App\Config;

class Config
{
    protected $config = [
        'host' => 'localhost',
        'database' => 'test',
        'username' => 'root',
        'password' => ''
    ];

    public function __construct()
    {
        echo 'init';
    }

    public function get($key)
    {
        if (!array_key_exists($key, $this->config)) {
            return null;
        }
        return $this->config[$key];
    }
}