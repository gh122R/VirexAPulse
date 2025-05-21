<?php

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * +-------------------------+
 * |   Заголовки для cors   |
 * +------------------------+
 * */

header("Cross-Origin-Opener-Policy: same-origin-allow-popups");
header("Cross-Origin-Embedder-Policy: credentialless");
header("Content-Security-Policy: default-src * 'unsafe-inline' 'unsafe-eval';");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

/**
 * +---------------------------+
 * | Подключение eloquent orm |
 * +--------------------------+
 * */

$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'mysql',
    'database' => 'my_db',
    'username' => 'user',
    'password' => 'password',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

/**
 * +----------------------+
 * | Объявление констант |
 * +---------------------+
 * */

define('PATH', dirname(__DIR__, 2));