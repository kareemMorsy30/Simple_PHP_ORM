<?php

namespace Routes;

use App\Requests\Request;

class Router {

    /**
     * Holds the registered routes
     *
     * @var array $routes
     */
    protected static $routes = [];

    /**
     * Register a new route
     *
     * @param $action string
     * @param \Closure $callback Called when current URL matches provided action
     */
    static function route($action, $operation)
    {
        $action = trim($action, '/'.$GLOBALS['project_base']);

        if (is_array($operation)) {
            $operation = function () use ($operation) {
                $classController = $operation[0];
                $function = $operation[1];
    
                $controller = new $classController();
                $controller->$function(new Request());
            };
        }
        
        self::$routes[$action] = $operation;
    }

    /**
     * Dispatch the router
     *
     * @param $action string
     */
    static function dispatch($action)
    {
        $action = trim($action, '/'.$GLOBALS['project_base']);
        $action = explode('?', $action);
        $action = $action[0];

        $operation = self::$routes[$action];

        echo call_user_func($operation);
    }

}