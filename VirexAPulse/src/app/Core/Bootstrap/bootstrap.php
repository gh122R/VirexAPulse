<?php

declare(strict_types=1);

use App\Core\cli\CommandsHandler;

use App\Core\Containers\Container;
use App\Core\Environment\EnvLoader;
use App\Core\Environment\EnvManager;
use App\Core\Environment\EnvValidator;
use App\Core\Facades\Facade;
use App\Core\Routing\Router;

/*
 * +--------------------------+
 * | Инициализация контейнера |
 * +--------------------------+
 * */

$container = new Container();
$container->singleton('router', fn() => new Router());
$container->singleton('command', fn() => new CommandsHandler());
$container->singleton('EnvLoader', fn() => new EnvLoader(BASE_PATH));
$container->singleton('EnvValidator', fn() => new EnvValidator());
$container->singleton('EnvManager', fn() => new EnvManager());
Facade::setContainer($container);