<?php

declare(strict_types=1);

namespace App\Core\Facades;

use App\Core\Containers\Container;

class Facade
{
    protected static Container $container;
    public static function setContainer(Container $container): void
    {
        self::$container = $container;
    }
    protected static function getFacadeFoundation()
    {
        return self::$container->make(static::getAccessor());
    }

    protected static function getAccessor():string
    {
        throw new \Exception('Фасад не реализует метод getAccessor😡');
    }

    public static function __callStatic($method, $parameters)
    {
        return self::getFacadeFoundation()->$method(...$parameters);
    }
}