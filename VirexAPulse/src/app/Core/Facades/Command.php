<?php

namespace App\Core\Facades;

/**
 * @method static serve():never
 * @method static makeController(string $name, string|null $type): string
 * @method static makeModel(string $name): string
 * @method static getCommandsList()
*/

class Command extends Facade
{
    protected static function getAccessor(): string
    {
        return 'command';
    }
}