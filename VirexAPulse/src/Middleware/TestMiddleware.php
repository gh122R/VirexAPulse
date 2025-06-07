<?php

declare(strict_types=1);

namespace src\Middleware;
use App\Core\Helpers\ErrorHandler;

class TestMiddleware
{

    /*
     *  +---------------------------------------------------------------------------------------------------------------------------+
     *  | Вы можете проверить работоспособность этого middleware' а, раскомментировав код ниже, и убрав последний "return $next();" |
     *  | Каждый метод middleware' а должен принимать callable $next и вызывать её в конце return $next().                          |
*       | $next() нужен для перехода к следующему middleware'у или контроллеру                                                     |
     *  +---------------------------------------------------------------------------------------------------------------------------+
     * */
    public function index(callable|string $next):callable|string
    {
/*        if (!empty($_COOKIE['token']))
        {
            return $next();
        }else
        {
           return ErrorHandler::error("Middleware сработал!");
        }*/
        return $next();
    }

    public function empty(callable|string $next):callable|string|int
    {
        return $next();
    }

    public function forTest(callable $next):callable|string
    {
        if (!empty($_COOKIE['token']))
        {
            return $next();
        }else
        {
           return ErrorHandler::error("Middleware сработал!");
        }
    }
}