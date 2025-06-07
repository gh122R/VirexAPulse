<?php

namespace App\Core\Helpers;

use App\Core\Interfaces\ViewInterface;

class View implements ViewInterface
{
    /*
     * +--------------------------------------------------------------------------------------------------------------+
     * В render передаём путь до html-странички относительно папки Views и массив, который в последующем
     * разбивается на переменные по ключам, позволяя удобнее взаимодействовать с ними в самой html' ке.
     * Если файл не найден, то скрипт прекращает работу, а router выкидывает страницу ExceptionsPage.html с ошибкой.
     * +--------------------------------------------------------------------------------------------------------------+
    */
    public static function render(string $view, array $data = []): string
    {
        extract($data);
        ob_start();
        $path =  BASE_PATH . '/src/Views/' . $view . '.html';
        if (file_exists($path))
        {
            include $path;
        }elseif (file_exists(BASE_PATH . '/src/Views/' . $view . '.php'))
        {
            include BASE_PATH . '/src/Views/' . $view . '.php';
        }else
        {
            if (class_exists(ErrorHandler::class))
            {
                return ErrorHandler::error("Файл представления не найден :(", description: "$view.html\(php) не найден");
            }
            return "Файл представления не найден :( | $view.html\(php) не найден";
        }
        return ob_get_clean();
    }
}