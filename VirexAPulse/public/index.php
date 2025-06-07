<?php

declare(strict_types=1);

use App\Core\Facades\Route;

header("Cross-Origin-Opener-Policy: same-origin-allow-popups");
header("Cross-Origin-Embedder-Policy: credentialless");
header("Content-Security-Policy: default-src * 'unsafe-inline' 'unsafe-eval';");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

session_start();

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/src/app/db.php';
require_once dirname(__DIR__) . '/src/web.php';

echo Route::handler($_SERVER['REQUEST_URI']);
