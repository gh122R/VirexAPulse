<?php

namespace App\Core\Routing;

class RouteRegister
{
    protected function registerRoute(string $route, array|callable $action ,string $method, array|callable $middleware = []): void
    {
        if (str_contains($route, '{'))
        {
            $pattern = "#^" . preg_replace('#\{(\w+)\}#', '(\w+)', $route) . "$#";
            preg_match_all('/\{(\w+)\}/', $route, $matches);
            $this->dinamicRoutes[$route] = [
                'action' => $action,
                'method' => $method,
                'middlewareList' => $middleware,
                'matches' => $matches[1],
                'pattern'=> $pattern
            ];
        }else
        {
            $this->routes[$route] = [
                'action' => $action,
                'method' => $method,
                'middlewareList' => $middleware
            ];
        }
    }
}