<?php

require_once __DIR__ . "/app/Core/Bootstrap/bootstrap.php";

use App\Core\Facades\Nexus;
use src\Controllers\HomeController;

Nexus::get('/', fn()=> 123);

Nexus::post('/about', [HomeController::class, 'index']);
Nexus::view('/test', 'welcome');