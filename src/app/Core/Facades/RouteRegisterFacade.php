<?php

namespace App\Core\Facades;

class RouteRegisterFacade extends Facade
{
    protected static function getAccessor(): string
    {
        return 'routeRegister';
    }
}