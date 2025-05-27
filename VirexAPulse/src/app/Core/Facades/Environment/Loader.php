<?php

namespace App\Core\Facades\Environment;

use App\Core\Facades\Facade;

class Loader extends Facade
{
    protected static function getAccessor(): string
    {
        return 'EnvLoader';
    }
}