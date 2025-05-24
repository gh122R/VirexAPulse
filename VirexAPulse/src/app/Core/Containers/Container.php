<?php

declare(strict_types=1);

namespace App\Core\Containers;

class Container
{
    protected array $bindings = [];
    protected array $instances = [];

    public function bind(string $key, callable $action): void
    {
        $this->bindings[$key] = $action;
    }

    public function singleton(string $key, callable $action): void
    {
        $this->instances[$key] = $action();
    }

    public function make(string $key)
    {
        if (isset($this->instances[$key]))
        {
            return $this->instances[$key];
        }
        return call_user_func($this->bindings[$key]);
    }
}