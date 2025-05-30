<?php

require_once __DIR__ . "/app/Core/Bootstrap/bootstrap.php";

use App\Core\Facades\Environment\Manager;
use App\Core\Facades\Route;
use src\Controllers\HomeController;

/*
 * +-------------------------------------------------------------------------------------------------------------+
*  | Здесь происходить регистрация маршрутов. Чтобы зарегистрировать маршрут, обратитесь в Route и его методу    |
 * | Всего у Route есть 3 метода, доступные для вызова: get, post и view.                                        |
 * | Если вы регистрируете маршрут с помощью get или post, то роутер будет обрабатывать маршруты только          |
 * | с тем http-методом, который соответствует названию метода регистрации. Метод view по умолчанию регистрирует |
 * | маршруты с методом get.                                                                                     |
 * | Например, если вы зарегистрировали маршрут так: <<<Route::get('/', fn()=> 123)>>>, то если браузер          |
 * | отправит post http-запрос, вместо get, роутер выбросит исключение.                                          |
 * +-------------------------------------------------------------------------------------------------------------+
 * */

Route::get('/w', fn()=> 'welcome');
Route::get('/home/{id}', [HomeController::class, 'index']);
Route::view('/', 'welcome');
Route::get('/test', fn() => view('test', ['Пример' => '123']));
Route::get('/test2', fn() => redirect('/test', ['error' => 123],1));
Route::get('/test3',function ()
{
 pd(Manager::get(['driver', 'password', 'username']));
});


/*
 * +-----------------------------------------------------------------------------------------------------------------------------------+
 * | Если вы регистрируете маршрут с помощью <<<Route::get>>> или <<<Route::post>>>, то                                                |
 * | первый аргумент маршрута - это строка, которая является конечной точкой выполнения маршрута.                                      |
 * | Второй аргумент - массив из названия класса и его метода, который будет вызван, либо замыкание.                                   |
 * | Третий аргумент - список middleware' ов. Он всегда указывается во вложенном массиве, что-то типа такого:                          |
 * | <<<[                                                                                                                              |
 * |  [GigaMiddleware::class, 'index', 123],                                                                                           |
 * |  [SuperMiddleware::class, 'index']                                                                                                |
 * | ]>>>                                                                                                                              |
 * | То есть, мы открываем массив, внутри которого указываем middleware' ы. Они, как и 2-й аргумент могут быть массивом                |
 * | из указания класса, его метода + можно указать значение, которое будет передано в конструктор middleware' а.                      |
 * | Вы также можете использовать замыкания вместо массивов middleware, тогда вид будет такой:                                         |
 * | <<<[                                                                                                                              |
 * | fn () => "Дальше прохода нет"                                                                                                     |
 * | ]>>>                                                                                                                              |
 * | либо массивы замыканий:                                                                                                           |
 * | <<<[                                                                                                                              |
 * | [fn () => "Дальше прохода нет"],                                                                                                  |
 * | [fn(callable $next) => next()] //Пропускаем на следующий middleware                                                               |
 * | ]>>>                                                                                                                              |
 * |  Каждый метод middleware' а должен принимать callable $next и, при позитивном сценарии, вызывать её в конце: return $next()       |
 * +-----------------------------------------------------------------------------------------------------------------------------------+
 */
