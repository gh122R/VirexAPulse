<?php

namespace App\Core\Facades;

class Command extends Facade
{
    protected static function getAccessor(): string
    {
        return 'command';
    }
}