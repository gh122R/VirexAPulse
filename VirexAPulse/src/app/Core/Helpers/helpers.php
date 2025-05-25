<?php

declare(strict_types=1);

use App\Core\Helpers\ErrorHandler;
use App\Core\Helpers\View;

if (!function_exists('dd'))
{
    function dd(...$args): never
    {
        if (!$args)
        {
            echo "функция dd() выполняет var_dump переданных параметров";
            exit();
        }
        echo '<pre>';
        var_dump(...$args);
        echo '</pre>';
        exit();
    }
}

if(!function_exists('view'))
{
    function view(string $view, array $data = []): string
    {
        return View::render($view, $data);
    }
}

if(!function_exists('error'))
{
    function error(string $message, string $view = '', string $dangerLevel = "Критическая ошибка", string $description = ''): string
    {
        return ErrorHandler::error($message, $view, $dangerLevel, $description);
    }
}

if(!function_exists('redirect'))
{
    function redirect(string $url): never
    {
        header('Location: ' . $url);
        exit();
    }
}