<?php

/**
 * Здесь просто объявляю заголовки для CORS, включаю autoloader и web.php, содержащий маршруты.
 */

declare(strict_types=1);

use App\Core\Facades\Nexus;

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/src/app/config.php';
require_once dirname(__DIR__) . '/src/web.php';

header("Cross-Origin-Opener-Policy: same-origin-allow-popups");
header("Cross-Origin-Embedder-Policy: credentialless");
header("Content-Security-Policy: default-src * 'unsafe-inline' 'unsafe-eval';");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

echo Nexus::handler($_SERVER['REQUEST_URI']);