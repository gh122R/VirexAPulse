<?php

namespace App\Core\Routing;

class RouteRegister
{
    protected $routes = [];
    protected $dynamicRoutes = [];

    public function getRoutes()
    {
        return $this->routes;
    }
    public function registerRoute(string $route, array|callable|string $action ,string $method, array|callable $middleware = []): void
    {
        if(is_string($action))
        {
            $this->routes[$route] = [
                'view' => $action,
                'method' => $method,
            ];
        }
        if (str_contains($route, '{'))
        {
            $pattern = "#^" . preg_replace('#\{(\w+)\}#', '(\w+)', $route) . "$#";
            preg_match_all('/\{(\w+)\}/', $route, $matches);
            $this->dynamicRoutes[$route] = [
                'action' => $action,
                'method' => $method,
                'middlewareList' => $middleware,
                'matches' => $matches[1],
                'pattern'=> $pattern
            ];
        }elseif(!is_string($action))
        {
            $this->routes[$route] = [
                'action' => $action,
                'method' => $method,
                'middlewareList' => $middleware
            ];
        }
    }
}