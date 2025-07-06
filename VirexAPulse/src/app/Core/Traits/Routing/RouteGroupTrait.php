<?php

namespace App\Core\Traits\Routing;

trait RouteGroupTrait
{
    public function group(array $parameters, callable $routes): void
    {
        $this->groupData = ($this->routeGrouper)($parameters, $routes);
        $routes();
        unset($this->groupData);
    }
}