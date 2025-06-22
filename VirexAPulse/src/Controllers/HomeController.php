<?php

namespace src\Controllers;

use App\Core\Helpers\View;

class HomeController
{
    private array $parameters;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    public function index(): string
    {
        return isset($this->parameters) ? View::render('home', $this->parameters) : View::render('home');
    }
}
