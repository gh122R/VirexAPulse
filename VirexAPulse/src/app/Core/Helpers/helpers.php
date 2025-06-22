<?php

declare(strict_types=1);

use App\Core\Helpers\ErrorHandler;
use App\Core\Helpers\View;

define('BASE_PATH', dirname(__DIR__, 4));
define('VIEWS_PATH', dirname(__DIR__, 4) . '/src/Views');
define('CONTROLLERS_PATH', dirname(__DIR__, 4) . '/src/Controllers');
define('MODELS_PATH', dirname(__DIR__, 4) . '/src/Models');
define('MIDDLEWARE_PATH', dirname(__DIR__, 4) . '/src/Middleware');
define('APP_PATH', dirname(__DIR__, 4) . '/src/app');
define('SRC_PATH', dirname(__DIR__, 4) . '/src');

if (!function_exists('dd')) {
    function dd(...$args): never
    {
        if (!$args) {
            echo "функция dd() выполняет var_dump переданных параметров";
            exit();
        }
        echo '<pre>';
        var_dump(...$args);
        echo '</pre>';
        exit();
    }
}

if (!function_exists('pd')) {
    function pd(...$args): never
    {
        if (!$args) {
            echo "функция pd() выполняет print_r переданных параметров";
            exit();
        }
        echo '<pre>';
        print_r(...$args);
        echo '</pre>';
        exit();
    }
}

if (!function_exists('view')) {
    function view(string $view, array $data = []): string
    {
        if (class_exists(View::class)) {
            return View::render($view, $data);
        }
        return "Класс View не найден!";
    }
}

if (!function_exists('error')) {
    function error(
        string $message,
        string $view = '',
        string $dangerLevel = "Критическая ошибка",
        string $description = ''
    ): string {
        if (class_exists(ErrorHandler::class)) {
            return ErrorHandler::error($message, $view, $dangerLevel, $description);
        }
        return "Класс ErrorHandler не найден!";
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url, array $data = [], int $messageLifetime = 5): never
    {
        if (!empty($data)) {
            $_SESSION['message'] = $data;
            $_SESSION['message_expire'] = time() + $messageLifetime;
        }
        header('Location: ' . $url);
        exit();
    }
}

if (!function_exists('getMessage')) {
    function getMessage(string $key = ''): null|string
    {
        unsetMessage();
        if (isset($_SESSION['message'])) {
            if (isset($key)) {
                return key_exists(
                    $key,
                    $_SESSION['message']
                ) ? $_SESSION['message'][$key] : "Ключ <b><i>$key</i></b> не найден";
            }
            return $_SESSION['message'];
        }
        return null;
    }
}

if (!function_exists('unsetMessage')) {
    function unsetMessage(): void
    {
        if (isset($_SESSION['message'])) {
            if (time() > $_SESSION['message_expire']) {
                unset($_SESSION['message']);
                unset($_SESSION['message_expire']);
            }
        }
    }
}
