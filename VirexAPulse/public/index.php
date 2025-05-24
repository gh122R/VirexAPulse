<?php

declare(strict_types=1);

use App\Core\Facades\Route;

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/src/app/config.php';
require_once dirname(__DIR__) . '/src/web.php';

echo Route::handler($_SERVER['REQUEST_URI']);
