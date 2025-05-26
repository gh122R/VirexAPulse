<?php

namespace App\Core\Facades;

class Route extends Facade
{
    protected static function getAccessor(): string
    {
        return 'router';
    }
}