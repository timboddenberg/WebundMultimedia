<?php

require_once __DIR__ . "\..\Engine\RequestEngine.php";

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

        $requestRoute = preg_replace("#\?.*#", "",$requestRoute);

        $requestRoute = $this->adjustParametersForProductRequest($requestRoute);

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

    private function adjustParametersForProductRequest(string $requestRoute)
    {
        if (! str_contains($requestRoute,"product") ||
            preg_match("#product/[a-zA-Z]{1,}#", $requestRoute))
                return $requestRoute;

        preg_match("#\/[0-9]*$#",$requestRoute, $foundMatches);
        $requestRoute = str_replace($foundMatches[0],"",$requestRoute);

        if (count($foundMatches) > 0)
        {
            $productId = str_replace("/","",$foundMatches[0]);
            $requestEngine = new RequestEngine();
            $requestEngine->setSESSION("productId",$productId);
        }

        return $requestRoute;
    }

    public function redirect(string $controller, string $action)
    {

        var_dump($this->routes);die;
        foreach ($this->routes as $route)
        {
            if ($route["class"] = $controller && $route["action"] == $action)
            {
                header("Location: http://Localhost/WebundMultimedia/" . $route["route"]);
                die;
            }
        }
    }
}
