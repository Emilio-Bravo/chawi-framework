<?php

use Core\Http\Router;

$router = new Router;

$router->get('/', function () {
    echo 'Hello world';
});

$router->resolve(); //Runs routes