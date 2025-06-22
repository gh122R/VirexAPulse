<?php

namespace App\Core\Routing;

class RouteGrouper
{

    public function __invoke(array $parameters, callable $routes): array
    {
        $middleware = null;
        $controller = null;
        $prefix = null;
        if (array_key_exists('middleware', $parameters)) {
            if (is_array($parameters['middleware'][0])) {
                count($parameters['middleware']) === 2 ? $middleware = [$parameters['middleware'][0], $parameters['middleware'][1]] : $middleware = [$parameters['middleware'][0]];
            } else {
                count($parameters['middleware']) === 2 ? $middleware = [[$parameters['middleware'][0], $parameters['middleware'][1]]] : $middleware = [[$parameters['middleware'][0]]];
            }
        }
        if (array_key_exists('controller', $parameters)) {
            if (is_array($parameters['controller'])) {
                count($parameters['controller']) === 2 ? $controller = [$parameters['controller'][0], $parameters['controller'][1]] : $controller = [$parameters['controller'][0]];
            }
            if (is_string($parameters['controller'])) {
                $controller = $parameters['controller'];
            }
        }
        if (array_key_exists('prefix', $parameters)) {
            $prefix = $parameters['prefix'];
        }
        return [
            'prefix' => $prefix,
            'middleware' => $middleware,
            'controller' => $controller,
        ];
    }
}