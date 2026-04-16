<?php

namespace App\Core;

class Router {
    protected $routes = [];

    public function add($method, $uri, $controller) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
        ];
    }

    public function handle() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = urldecode($uri);
        
        // Dynamically detect the base path (e.g., /project-folder or empty for root)
        $scriptPath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $basePath = rtrim($scriptPath, '/');
        
        // Remove base path from URI
        if ($basePath !== '' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        // Ensure URI starts with / and handle empty string
        $uri = '/' . ltrim($uri, '/');

        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->match($route['uri'], $uri)) {
                $parts = explode('@', $route['controller']);
                $controllerName = "App\\Controllers\\" . $parts[0];
                $action = $parts[1];

                $controller = new $controllerName();
                return $controller->$action();
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    protected function match($routeUri, $uri) {
        return $routeUri === $uri;
    }
}
