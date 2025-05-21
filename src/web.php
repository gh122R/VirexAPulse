<?php

require_once __DIR__ . "/app/Core/Bootstrap/bootstrap.php";

use App\Core\Facades\Nexus;
use src\Controllers\HomeController;

/**
 * +--------------------------------------------------------------------------------------------------+
 * | Каждый метод middleware' а должен принимать callable $next и вызывать её в конце @return $next() |
 * +--------------------------------------------------------------------------------------------------+
 * */

Nexus::get('/', fn()=> 123);

Nexus::get('/home/{id}', [HomeController::class, 'index']);
Nexus::view('/test', 'welcome');