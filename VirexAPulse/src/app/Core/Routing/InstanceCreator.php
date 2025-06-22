<?php

namespace App\Core\Routing;

use App\Core\Helpers\ErrorHandler;

class InstanceCreator
{
    public function __invoke(string $class, mixed $argument = null)
    {
        if (class_exists($class)) {
            return $argument !== null ? new $class($argument) : new $class();
        } else {
            return ErrorHandler::classNotFound($class);
        }
    }
}