<?php

declare(strict_types=1);

namespace App\Core\Routing;

class RouteRegister
{
    protected array $routes = [];
    protected array $dynamicRoutes = [];

    private function getRoutes(): array
    {
        return [
            'routes' => $this->routes,
            'dynamicRoutes' => $this->dynamicRoutes,
        ];
    }

    public function __invoke(string $route, array|callable|string $action, string $method, array|callable $middleware = []): array
    {
        if (is_string($action)) {
            $this->routes[$route] = [
                'view' => $action,
                'method' => $method,
            ];
        }
        if (str_contains($route, '{')) {
            $pattern = "#^" . preg_replace('#\{(\w+)\}#', '(\w+)', $route) . "$#";
            preg_match_all('/\{(\w+)\}/', $route, $matches);
            $this->dynamicRoutes[$route] = [
                'action' => $action,
                'method' => $method,
                'middlewareList' => $middleware,
                'matches' => $matches[1],
                'pattern' => $pattern
            ];
        } elseif (!is_string($action)) {
            $this->routes[$route] = [
                'action' => $action,
                'method' => $method,
                'middlewareList' => $middleware
            ];
        }

        return $this->getRoutes();
    }
}