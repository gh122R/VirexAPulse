<?php

    require_once dirname(__DIR__,4) . '/vendor/autoload.php';
    require_once dirname(__DIR__,3) . '/app/config.php';

    use App\Core\cli\CommandsHandler;
    use App\Core\Containers\Container;
    use App\Core\Facades\Facade;
    use App\Core\Router;
    use App\Core\Routing\RouteRegister;

    $container = new Container();
    $container->singleton('router', fn() => new Router());
    $container->singleton('command', fn() => new CommandsHandler());
    $container->singleton('register', fn() => new RouteRegister());
    Facade::setContainer($container);
