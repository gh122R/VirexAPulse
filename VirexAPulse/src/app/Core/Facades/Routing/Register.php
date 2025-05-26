<?php

namespace App\Core\Facades\Routing;

use App\Core\Facades\Facade;

class Register extends Facade
{
    protected static function getAccessor(): string
    {
        return 'register';
    }
}