<?php

namespace tests;
require_once dirname(__DIR__) . '/src/app/Core/Bootstrap/bootstrap.php';

use App\Core\Containers\Container;
use App\Core\Facades\Facade;
use App\Core\Facades\Route;
use App\Core\Router;
use PHPUnit\Framework\TestCase;
use src\Middleware\TestMiddleware;

class RouterTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $container = new Container();
        $container->singleton('router', fn () => new Router());
        Facade::setContainer($container);
    }

    public function testRouteNotFound()
    {
        Route::get('/test', fn() => 'success');
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = Route::handler('/somethingElse');
        $this->assertStringContainsString('404', $result);
    }

    public function testGetRequest()
    {
        Route::get('/test', fn() => 'success');
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = Route::handler('/test');
        $this->assertEquals('success', $result);
    }

    public function testPostRequest()
    {
        Route::post('/test', fn() => 'success');
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $result = Route::handler('/test');
        $this->assertEquals('success', $result);
    }

    public function testMixedRequestsPositive()
    {
        Route::post('/post', fn() => 'post request');
        Route::get('/get', fn() => 'get request');
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $result = Route::handler('/post');
        $this->assertEquals('post request', $result);
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = Route::handler('/get');
        $this->assertEquals('get request', $result);
    }

    public function testMixedRequestsNegative()
    {
        Route::post('/post', fn() => 'post request');
        Route::get('/get', fn() => 'get request');
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $result = Route::handler('/post');
        $this->assertEquals('post request', $result);
        $result = Route::handler('/get');
        $this->assertStringContainsString('Данный метод низя применить на маршруте', $result);
    }

    public function testRequestMethod()
    {
        $router = new Router();
        $router->post('/test', function () {
            return 'success';
        });
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = $router->handler('/test');
        $this->assertStringContainsString('Данный метод низя применить на маршруте', $result);
    }

    public function testMiddlewarePositive()
    {
        $router = new Router();
        $router->get('/test', function () { return 'success';}, [[TestMiddleware::class, 'index']]);
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = $router->handler('/test');
        $this->assertEquals('success', $result);
    }

    public function testMiddlewareNegative()
    {
        $router = new Router();
        $router->get('/test', function () { return 'success';}, [[TestMiddleware::class, 'forTest']]);
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = $router->handler('/test');
        $this->assertNotEquals('test', $result);
        $this->assertStringContainsString('Middleware сработал!', $result);
    }

    public function testMiddlewareMixed()
    {
        $router = new Router();
        $router->get('/test', function (){
            return 'test';
        },
            [
                [TestMiddleware::class, 'index'],
                [TestMiddleware::class, 'forTest'],
            ]);
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = $router->handler('/test');
        $this->assertNotEquals('test', $result);
        $this->assertStringContainsString('Middleware сработал!', $result);
    }
}