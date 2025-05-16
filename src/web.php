<?php

require_once __DIR__ . "/app/Core/Bootstrap/bootstrap.php";
use App\Core\Facades\Nexus;
use src\Controllers\HomeController;


Nexus::get('/home', fn()=> 123);
Nexus::get('/about', [HomeController::class, 'index']);