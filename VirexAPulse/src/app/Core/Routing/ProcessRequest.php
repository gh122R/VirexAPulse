<?php

declare(strict_types=1);

namespace App\Core\Routing;

use App\Core\Helpers\ErrorHandler;

class ProcessRequest
{

    /**
     * @var callable
     */
    private $instanceCreator;

    public function __construct(callable $instanceCreator)
    {
        $this->instanceCreator = $instanceCreator;
    }

    public function __invoke(callable|array $parameters, callable $next): mixed
    {
        if (is_callable($parameters)) {
            $parameters = [$parameters];
        }
        foreach (array_reverse($parameters) as $parameter) {
            if (is_array($parameter)) {
                if (count($parameter) === 3) {
                    [$class, $method, $argument] = $parameter;
                    $classInstance = ($this->instanceCreator)($class, $argument) ?? ErrorHandler::brokenClassInstance(
                        $class
                    );
                } elseif (count($parameter) === 2) {
                    [$class, $method] = $parameter;
                    $classInstance = ($this->instanceCreator)($class) ?? ErrorHandler::brokenClassInstance($class);
                }
                if (isset($classInstance, $class, $method) && is_object($classInstance)) {
                    if (method_exists($class, $method)) {
                        $next = function () use ($classInstance, $next, $method) {
                            return $classInstance->$method($next);
                        };
                    } else {
                        return ErrorHandler::methodNotFound($method, $class);
                    }
                } else {
                    return $classInstance ?? null;
                }
            } elseif (is_callable($parameter)) {
                $next = function () use ($parameter, $next) {
                    return $parameter($next);
                };
            }
        }
        return $next();
    }
}