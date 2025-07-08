<?php

namespace App\Core\Traits\Routing;

trait RouteMethodsTrait
{
    public function get(string $route, array|callable|string $action = [], array|callable $middleware = []): self
    {
        $this->setRoute($route, $action, 'GET', $middleware);
        return $this;
    }

    public function post(string $route, array|callable|string $action = [], array|callable $middleware = []): self
    {
        $this->setRoute($route, $action, 'POST', $middleware);
        return $this;
    }

    public function view(string $route, string $path): self
    {
        if (!empty($this->groupData)) {
            if (!empty($this->groupData['prefix'])) {
                $route = '/' . $this->groupData['prefix'] . $route;
            }
        }
        $routes = ($this->routeRegister)($route, $path, 'GET');
        $this->routes = array_merge($routes['routes'], $this->routes);
        return $this;
    }
}