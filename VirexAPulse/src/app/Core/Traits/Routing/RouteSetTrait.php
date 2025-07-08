<?php

namespace App\Core\Traits\Routing;

trait RouteSetTrait
{
    private function setRoute(
        string $route,
        array|callable|string $action,
        string $method,
        array|callable $middleware = []
    ): void {
        $routes = ($this->routeSetter)($this->routeRegister, $this->groupData, $route, $action, $method, $middleware);
        $this->routes = array_merge($routes['routes'], $this->routes);
        $this->dynamicRoutes = array_merge($routes['dynamicRoutes'], $this->dynamicRoutes);
    }
}