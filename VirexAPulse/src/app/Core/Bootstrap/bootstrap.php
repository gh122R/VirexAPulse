<?php

declare(strict_types=1);

use App\Core\cli\CommandsHandler;

use App\Core\Containers\Container;
use App\Core\Environment\EnvLoader;
use App\Core\Environment\EnvManager;
use App\Core\Environment\EnvValidator;
use App\Core\Facades\Facade;
use App\Core\Routing\DynamicRoutesHandler;
use App\Core\Routing\InstanceCreator;
use App\Core\Routing\ProcessRequest;
use App\Core\Routing\Render;
use App\Core\Routing\RouteGrouper;
use App\Core\Routing\Router;
use App\Core\Routing\RouteRegister;
use App\Core\Routing\RouteSetter;

/*
 * +--------------------------+
 * | Инициализация контейнера |
 * +--------------------------+
 * */

$container = new Container();
$container->singleton(
    'router',
    fn() => new Router(
        new InstanceCreator(),
        new RouteGrouper(),
        new RouteSetter(),
        new RouteRegister(),
        new ProcessRequest(new InstanceCreator()),
        new DynamicRoutesHandler(),
        new Render()
    )
);
$container->singleton('command', fn() => new CommandsHandler());
$container->singleton('EnvLoader', fn() => new EnvLoader(BASE_PATH));
$container->singleton('EnvValidator', fn() => new EnvValidator());
$container->singleton('EnvManager', fn() => new EnvManager());
Facade::setContainer($container);