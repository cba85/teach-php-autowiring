<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Container\Container;

$container = new Container;

/*
$container->set('config', function () {
    return new App\Config\Config;
});
*/

//dump($container->get('config'));
//dump($container->has('config'));

//dump($container->get('config'));
//dump($container->config);

$container->share('config', function () {
    return new App\Config\Config;
});

/*
dump($container->config->get('app'));
dump($container->config->get('app'));
dump($container->config->get('app'));
dump($container->config->get('app'));
*/

$container->share('database', function ($container) {
    return new App\Database\Database($container->config);
});

//dump($container->get('database')->connect());

dump((new App\Controllers\Controller($container->config, $container->database))->index());