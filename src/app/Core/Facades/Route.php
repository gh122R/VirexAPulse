<?php

namespace App\Core\Facades;
use App\Core\Router;
use Illuminate\Support\Facades\Route;

class Nexus extends Facade
{
    protected static function getAccessor(): string
    {
        return 'router';
    }
}