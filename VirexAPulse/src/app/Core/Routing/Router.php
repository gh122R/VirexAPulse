<?php

declare(strict_types=1);

namespace App\Core\Routing;

use App\Core\Helpers\ErrorHandler;
use App\Core\Interfaces\RouterInterface;
use App\Core\Traits\Routing\RouteGroupTrait;
use App\Core\Traits\Routing\RouteMethodsTrait;
use App\Core\Traits\Routing\RouteSetTrait;

/**
 * Вскоре будет написан DI контейнер под это дело :)
 */
class Router implements RouterInterface
{
    use RouteMethodsTrait;
    use RouteSetTrait;
    use RouteGroupTrait;

    private array $routes;
    private array $dynamicRoutes;
    private array $groupData = [];

    private InstanceCreator $instanceCreator;
    private RouteRegister $routeRegister;
    private ProcessRequest $processRequest;
    private Render $render;
    private DynamicRoutesHandler $dynamicRoutesHandler;
    private RouteGrouper $routeGrouper;
    private RouteSetter $routeSetter;

    public function __construct(
        InstanceCreator $instanceCreator,
        RouteGrouper $routeGrouper,
        RouteSetter $routeSetter,
        RouteRegister $routeRegister,
        ProcessRequest $processRequest,
        DynamicRoutesHandler $dynamicRoutesHandler,
        Render $render
    ) {
        $this->classExistChecker([
            get_class($instanceCreator),
            get_class($routeGrouper),
            get_class($routeSetter),
            get_class($routeRegister),
            get_class($processRequest),
            get_class($dynamicRoutesHandler),
            get_class($render),
        ]);
        $this->routes = [];
        $this->dynamicRoutes = [];
        $this->instanceCreator = $instanceCreator;
        $this->routeGrouper = $routeGrouper;
        $this->routeSetter = $routeSetter;
        $this->routeRegister = $routeRegister;
        $this->processRequest = $processRequest;
        $this->dynamicRoutesHandler = $dynamicRoutesHandler;
        $this->render = $render;
    }

    /**
     * Суть роутера проста - он менеджер. Его задача - дёрнуть нужный класс, когда это будет необходимо.
     * Сейчас все те классы, которые переданы в конструктор поставляются всего с одним методом внутри: __invoke
     * Это сделано для обеспечения модульности, ну и закос под функциональщину, само собой :)
     * */

    private function classExistChecker(array $classes = []): void
    {
        foreach ($classes as $class) {
            if (!class_exists($class)) {
                if (!class_exists(ErrorHandler::class)) {
                    echo "Класс <b>$class</b> не найден!  <br> <b>$class</b> необходим для функционирования роутера";
                    exit();
                }
                echo error("Класс $class не найден!", description: "$class необходим для функционирования роутера");
                exit();
            }
        }
    }

    public function handler(string $uri)
    {
        $handler = new Handler(
            $this->render,
            $this->dynamicRoutesHandler,
            $this->instanceCreator,
            $this->processRequest,
            $this->routes,
            $this->dynamicRoutes
        );

        return ($handler)($uri);
    }
}