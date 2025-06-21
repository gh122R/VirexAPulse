<?php

namespace App\Core\Facades;

/**
 * @method static get(string $route, array|callable $action, array|callable $middleware = []): self
 * @method static post(string $route, array|callable $action, array|callable $middleware = []): self
 * @method static view(string $route, string $path): self
 * @method static handler(string $uri)
 * @method static group(array $parameters, callable|array $routes):void
 */
class Route extends Facade
{
    protected static function getAccessor(): string
    {
        return 'router';
    }
}