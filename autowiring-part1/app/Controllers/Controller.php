<?php
namespace App\Controllers;

use App\Database\Database;
use App\Config\Config;

class Controller
{
    protected $config;

    protected $database;

    public function __construct(Config $config, Database  $database)
    {
        $this->config = $config;
        $this->database = $database;
    }

    public function index()
    {
        return [
            $this->config->get('host'),
            $this->database->connect()
        ];
    }

}