<?php

declare(strict_types=1);

namespace App\Core\Environment;

use App\Core\Facades\Environment\Validator as EnvironmentValidator;

class EnvManager
{
    public function get(string|array $name = ''): string|array
    {
        $items = null;
        if (!$name)
        {
            return 'Введите идентификатор для получения содержимого';
        }
        if(!EnvironmentValidator::validate())
        {
            return '.env не прошёл валидацию. Проверьте обязательные поля';
        }
        if (is_array($name))
        {
            foreach ($name as $item)
            {
                $items[strtoupper($item)] = $_ENV[strtoupper($item)];
            }
            return $items;
        }
        return $_ENV[strtoupper($name)];
    }
}