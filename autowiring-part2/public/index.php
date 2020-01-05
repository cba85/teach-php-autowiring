<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Container\Container;
use App\Config\Config;
use App\Database\Database;
use App\Controllers\Controller;

$container = new Container;

/*
$container->share(Database::class, function ($container) {
    return new App\Database\Database($container->get(Config::class));
});
*/

//dump((new App\Controllers\Controller($container->get(Config::class), $container->get(Database::class)))->index());
dump($container->get(Controller::class)->index());