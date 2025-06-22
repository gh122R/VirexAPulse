<?php

declare(strict_types=1);

namespace App\Core\Routing;

use App\Core\Helpers\ErrorHandler;

class DynamicRoutesHandler
{
    public function __invoke($route, $dynamicRoutes): string|array
    {
        foreach ($dynamicRoutes as $matchRoute => $data) {
            if (preg_match($data['pattern'], $route, $matches)) {
                array_shift($matches);
                $parameters = array_combine($data['matches'], $matches);
                $routeData = $data;
                break;
            }
        }
        if (!isset($routeData)) {
            return ErrorHandler::routeNotFound($route);
        }
        return [
            'routeData' => $routeData,
            'parameters' => $parameters,
        ];
    }
}