<?php

declare(strict_types=1);

namespace App\Core\Interfaces;

interface RouterInterface
{
    public function get(string $route, array|callable $action, array|callable $middleware = []): self;

    public function post(string $route, array|callable $action, array|callable $middleware = []): self;

    public function handler(string $uri);
}