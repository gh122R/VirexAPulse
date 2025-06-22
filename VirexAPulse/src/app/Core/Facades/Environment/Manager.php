<?php

namespace App\Core\Facades\Environment;

use App\Core\Facades\Facade;

/**
 * @method static get(string|array $name = ''): string|array
 */
class Manager extends Facade
{
    protected static function getAccessor(): string
    {
        return 'EnvManager';
    }
}