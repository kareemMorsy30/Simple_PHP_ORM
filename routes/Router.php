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
        // trim project root dir name of the passed route action
        $action = trim($action, '/'.$GLOBALS['project_base']);

        // Check if the passed operation is an array
        if (is_array($operation)) {
            // Provide a callback function
            $operation = function () use ($operation) {
                // First arguments represents the class controller
                $classController = $operation[0];
                // Second one represents the method to call
                $function = $operation[1];
                // create an instance of class controller
                $controller = new $classController();
                // call the passed method by the instance and inject the request object to it
                $controller->$function(new Request());
            };
        }
        
        // Append the callback operation of the route to static routes attribute till the dispatcher catches it
        self::$routes[$action] = $operation;
    }

    /**
     * Dispatch the router
     *
     * @param $action string
     */
    static function dispatch($action)
    {
        // Do the same as the route method
        $action = trim($action, '/'.$GLOBALS['project_base']);
        // Remove the query params of the action before compare
        $action = explode('?', $action);
        $action = $action[0];

        // Return the operation by using the action from the static attribute routes
        $operation = self::$routes[$action];

        // Call the callback function returned
        echo call_user_func($operation);
    }

}