<?php

namespace App\Core\Facades;
use App\Core\Facades\Facade;

class Route extends Facade
{
    protected static function getAccessor(): string
    {
        return 'router';
    }
}