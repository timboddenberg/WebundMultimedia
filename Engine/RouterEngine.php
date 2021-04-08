<?php

class RouterEngine
{
    private $routes = [];

    public function __construct()
    {
        $this->routes = require_once __DIR__ . '\..\config\routes.php';
    }

    public function handleRequest()
    {
        $requestRoute = $_SERVER['REQUEST_URI'];

        $requestRoute = str_replace("/WebundMultimedia","",$requestRoute);

        foreach ($this->routes as $route) {

            if ($route['route'] !== $requestRoute) {
                continue;
            }

            $controllerName = $route['class'];
            $actionName = $route['action'];

            require_once __DIR__ . '\\..\\Controllers\\' . $controllerName . '.php';

            $controller = new $controllerName();
            $controller->$actionName();
        }
    }
}
