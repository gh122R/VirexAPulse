<?php

declare(strict_types = 1);

namespace App\Core\Routing;

use App\Core\Helpers\View;

class Render
{
    public function __invoke(string $view): string
    {
        if(class_exists(View::class))
        {
            return View::render($view);
        }else
        {
            return error('Класс View не найден!', description: 'Работа роутера невозможна без класса View');
        }
    }
}