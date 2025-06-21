<?php

declare(strict_types = 1);

namespace App\Core\Routing;

use App\Core\Helpers\ErrorHandler;
use App\Core\Interfaces\RouterInterface;

/**
    Вскоре будет написан DI контейнер под это дело :)
 */

class Router implements RouterInterface
{
    private array $routes;
    private array $dynamicRoutes;
    private array $groupData = [];

    private InstanceCreator $instanceCreator;
    private RouteRegister $routeRegister;
    private ProcessRequest $processRequest;
    private Render $render;
    private DynamicRoutesHandler $dynamicRoutesHandler;
    private RouteGrouper $routeGrouper;
    private RouteSetter $routeSetter;

    public function __construct()
    {
      $this->classExistChecker([
            InstanceCreator::class,
            RouteRegister::class,
            ProcessRequest::class,
            DynamicRoutesHandler::class,
            Render::class,
            RouteGrouper::class
        ]);
        $this->routes = [];
        $this->dynamicRoutes = [];
        $this->instanceCreator = new InstanceCreator();
        $this->routeGrouper = new RouteGrouper();
        $this->routeSetter = new RouteSetter();
        $this->routeRegister = new RouteRegister();
        $this->processRequest = new ProcessRequest($this->instanceCreator);
        $this->dynamicRoutesHandler = new DynamicRoutesHandler();
        $this->render = new Render();
    }

    /**
     * Суть роутера проста - он менеджер. Его задача - дёрнуть нужный класс, когда это будет необходимо.
     * Сейчас все те классы, которые переданы в конструктор поставляются всего с одним методом внутри: __invoke
     * Это сделано для обеспечения модульности, ну и закос под функциональщину, само собой :)
     * Именно поэтому вызов зависимостей происходит через круглые скобки, типа: ($this->className), чтобы сразу обратиться
     * к __invoke методу класса
     * */

    private function classExistChecker(array $classes = []): void
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

    public function get(string $route, array|callable|string $action = [], array|callable $middleware = []): self
    {
        $this->setRoute($route, $action, 'GET', $middleware);
        return $this;
    }

    public function post(string $route, array|callable|string $action = [], array|callable $middleware = []): self
    {
        $this->setRoute($route, $action, 'POST',$middleware);
        return $this;
    }

    public function view(string $route, string $path): self
    {
        if(!empty($this->groupData))
        {
            if(!empty($this->groupData['prefix'])) $route = '/' . $this->groupData['prefix'] . $route;
        }
        $routes = ($this->routeRegister)($route, $path, 'GET');
        $this->routes = array_merge($routes['routes'], $this->routes);
        return $this;
    }

    public function group(array $parameters, callable $routes): void
    {
        $this->groupData = ($this->routeGrouper)($parameters, $routes);
        $routes();
        unset($this->groupData);
    }

    private function setRoute(string $route, array|callable|string $action, string $method ,array|callable $middleware = []): void
    {

        $routes = ($this->routeSetter)($this->routeRegister, $this->groupData, $route, $action, $method, $middleware);
        $this->routes = array_merge($routes['routes'], $this->routes);
        $this->dynamicRoutes = array_merge($routes['dynamicRoutes'], $this->dynamicRoutes);
    }

    public function handler(string $uri)
    {
        $handler = new Handler($this->render,
            $this->dynamicRoutesHandler,
            $this->instanceCreator,
            $this->processRequest,
            $this->routes,
            $this->dynamicRoutes);

        return ($handler)($uri);
    }
}