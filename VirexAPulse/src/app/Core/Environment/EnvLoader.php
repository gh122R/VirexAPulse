<?php

namespace App\Core\Environment;

use Dotenv\Dotenv;

class EnvLoader
{
    private Dotenv $dotenv;
    public function __construct($path)
    {
        $this->dotenv = Dotenv::createImmutable($path);
        $this->dotenv->load();
    }
}