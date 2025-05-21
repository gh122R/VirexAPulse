<?php

namespace App\Core\Bootstrap;
use App\Core\Containers\Container;
use App\Core\Facades\Facade;
use App\Core\Router;

$container = new Container();
$container->singleton('router', fn() => new Router());
Facade::setContainer($container);
