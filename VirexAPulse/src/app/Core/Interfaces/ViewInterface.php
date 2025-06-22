<?php

namespace App\Core\Interfaces;

interface ViewInterface
{
    public static function render(string $view, array $data = []): string;
}