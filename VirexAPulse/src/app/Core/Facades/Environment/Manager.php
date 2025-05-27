<?php

namespace App\Core\Facades\Environment;

use App\Core\Facades\Facade;

class Manager extends Facade
{
    protected static function getAccessor(): string
    {
        return 'EnvManager';
    }
}