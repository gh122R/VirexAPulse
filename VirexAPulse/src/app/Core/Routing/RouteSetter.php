<?php

namespace App\Core\Routing;

class RouteSetter
{
    public function __invoke(RouteRegister $routeRegister, array $groupData, string $route, array|callable|string $action, string $method ,array|callable $middleware = []): array
    {
        if(!empty($groupData))
        {
            if(!empty($groupData['prefix'])) $route =  '/' . $groupData['prefix'] . $route;
            if(!empty($groupData['controller']))
            {
                if(is_array($action))
                {
                    $action = $groupData['controller'];
                }
                if(is_string($action))
                {
                    $action = [$groupData['controller'], $action];
                }
            }
            if(!empty($groupData['middleware'])) $middleware = $groupData['middleware'];
        }
        return ($routeRegister)($route, $action, $method, $middleware);
    }
}