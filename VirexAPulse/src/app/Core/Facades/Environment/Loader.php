<?php

namespace App\Core\Facades\Environment;

use App\Core\Facades\Facade;

/**
 * @method static Dotenv(): Dotenv
 */
class Loader extends Facade
{
    protected static function getAccessor(): string
    {
        return 'EnvLoader';
    }
}