<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Apps', ['path' => '/apps'], function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Users', 'action' => 'index']);

    $routes->fallbacks(DashedRoute::class);
});
