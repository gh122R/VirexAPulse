<?php

declare(strict_types=1);

namespace App\Core\Routing;

use App\Core\Helpers\ErrorHandler;

class Handler
{
    private Render $render;
    private DynamicRoutesHandler $dynamicRoutesHandler;
    private InstanceCreator $instanceCreator;
    private ProcessRequest $processRequest;
    private array $routes = [];
    private array $dynamicRoutes = [];

    public function __construct(
        Render $render,
        DynamicRoutesHandler $dynamicRoutesHandler,
        InstanceCreator $instanceCreator,
        ProcessRequest $processRequest,
        array $routes,
        array $dynamicRoutes
    ) {
        $this->render = $render;
        $this->dynamicRoutesHandler = $dynamicRoutesHandler;
        $this->instanceCreator = $instanceCreator;
        $this->processRequest = $processRequest;
        $this->routes = $routes;
        $this->dynamicRoutes = $dynamicRoutes;
    }

    public function __invoke(string $uri): mixed
    {
        $route = parse_url($uri, PHP_URL_PATH);
        $routeData = $this->routes[$route] ?? null;
        $parameters = null;
        if ($routeData && array_key_exists('view', $routeData)) {
            return ($this->render)($routeData['view']);
        }
        if (!$routeData) {
            $data = ($this->dynamicRoutesHandler)($route, $this->dynamicRoutes);
            if (is_array($data)) {
                extract($data);
            } else {
                return $data;
            }
        }
        $next = function () use ($routeData, $route, $parameters) {
            if ($routeData !== null && $_SERVER['REQUEST_METHOD'] === $routeData["method"]) {
                if (is_callable($routeData["action"])) {
                    $response = call_user_func($routeData["action"]);
                } elseif (is_array($routeData["action"])) {
                    [$class, $method] = $routeData["action"];
                    $parameters !== null ? $controller = ($this->instanceCreator)(
                        $class,
                        $parameters
                    ) : $controller = ($this->instanceCreator)($class);
                    if (!is_object($controller)) {
                        return ErrorHandler::controllerNotFound($class);
                    } else {
                        method_exists($controller, $method) ? $response = call_user_func([$controller, $method]
                        ) : $response = ErrorHandler::methodNotFound($method, $class);
                    }
                }
            } elseif ($_SERVER['REQUEST_METHOD'] !== $routeData["method"]) {
                return ErrorHandler::failedRequestMethod($route, $routeData["method"], $_SERVER['REQUEST_METHOD']);
            }
            return $response ?? ErrorHandler::failedHandlerResponse();
        };
        $middlewareList = $routeData["middlewareList"] ?? null;
        return ($this->processRequest)($middlewareList, $next);
    }
}