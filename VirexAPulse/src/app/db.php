<?php

use App\Core\Facades\Environment\Manager as EnvironmentManager;
use Illuminate\Database\Capsule\Manager as Capsule;
require_once APP_PATH . '/Core/Bootstrap/bootstrap.php';
/*
 * +---------------------------+
 * | Подключение eloquent orm |
 * +--------------------------+
 * */

$capsule = new Capsule;
$capsule->addConnection([
    'driver' => EnvironmentManager::get('driver'),
    'host' => EnvironmentManager::get('host'),
    'database' => EnvironmentManager::get('database'),
    'username' => EnvironmentManager::get('username'),
    'password' => EnvironmentManager::get('password'),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

