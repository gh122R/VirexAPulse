<?php

declare(strict_types = 1);

namespace App\Core\Routing;

use App\Core\Helpers\ErrorHandler;
use App\Core\Helpers\View;
use App\Core\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    private array $routes;
    private array $dynamicRoutes;

    private InstanceCreator $instanceCreator;
    private RouteRegister $routeRegister;
    private ProcessRequest $processRequest;
    private Render $render;
    private DynamicRoutesHandler $dynamicRoutesHandler;
    private Handler $handler;

    public function __construct()
    {
      $this->classExistChecker([
            InstanceCreator::class,
            RouteRegister::class,
            ProcessRequest::class,
            DynamicRoutesHandler::class,
            Render::class,
        ]);
        $this->routes = [];
        $this->dynamicRoutes = [];
        $this->instanceCreator = new InstanceCreator();
        $this->routeRegister = new RouteRegister();
        $this->processRequest = new ProcessRequest(($this->instanceCreator));
        $this->dynamicRoutesHandler = new DynamicRoutesHandler();
        $this->render = new Render();
    }


    private function classExistChecker(array $classes): void
    {
        foreach ($classes as $class)
        {
            if (!class_exists($class))
            {
                if (!class_exists(ErrorHandler::class))
                {
                    echo "Класс <b>$class</b> не найден!  <br> <b>$class</b> необходим для функционирования роутера";
                    exit();
                }
                echo error("Класс $class не найден!", description: "$class необходим для функционирования роутера");
                exit();
            }
        }
    }

    public function get(string $route, array|callable $action, array|callable $middleware = []): self
    {
        $routes = ($this->routeRegister)($route, $action, 'GET', $middleware);
        $this->routes = array_merge($routes['routes']);
        $this->dynamicRoutes = array_merge($routes['dynamicRoutes']);
        return $this;
    }

    public function post(string $route, array|callable $action, array|callable $middleware = []): self
    {
        $routes = ($this->routeRegister)($route, $action, 'POST', $middleware);
        $this->routes = array_merge($routes['routes']);
        $this->dynamicRoutes = array_merge($routes['dynamicRoutes']);
        return $this;
    }

    public function view(string $route, string $path): self
    {
        $routes = ($this->routeRegister)($route, $path, 'GET');
        $this->routes = array_merge($routes['routes']);
        return $this;
    }
    public function handler(string $uri)
    {
        $this->handler = new Handler($this->render,
            $this->dynamicRoutesHandler,
            $this->instanceCreator,
            $this->processRequest,
            $this->routes,
            $this->dynamicRoutes);

        return ($this->handler)($uri);
    }
}