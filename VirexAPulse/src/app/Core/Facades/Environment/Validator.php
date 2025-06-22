<?php

declare(strict_types=1);

namespace App\Core\Facades\Environment;

use App\Core\Facades\Facade;

/**
 * @method static validate(): bool
 */
class Validator extends Facade
{
    protected static function getAccessor(): string
    {
        return 'EnvValidator';
    }
}