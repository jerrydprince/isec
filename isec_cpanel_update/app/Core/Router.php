<?php

namespace App\Core;

/**
 * Custom MVC Routing Engine
 */
class Router {
    protected array $routes = [];

    /**
     * Register a GET route
     */
    public function get(string $path, $handler, array $middlewares = []): void {
        $this->routes['GET'][$this->convertToRegex($path)] = [
            'handler' => $handler,
            'middlewares' => $middlewares
        ];
    }

    /**
     * Register a POST route
     */
    public function post(string $path, $handler, array $middlewares = []): void {
        $this->routes['POST'][$this->convertToRegex($path)] = [
            'handler' => $handler,
            'middlewares' => $middlewares
        ];
    }

    /**
     * Convert placeholder routes (e.g. /services/{slug}) to Regex matches
     */
    protected function convertToRegex(string $path): string {
        $path = trim($path, '/');
        $path = $path === '' ? '' : $path;
        // Match {paramName} and replace with dynamic regex capture groups
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^/' . $pattern . '$#';
    }

    /**
     * Match current request against registered routes and execute handler
     */
    public function resolve(Request $request, Response $response): mixed {
        $path = $request->getPath();
        $method = $request->getMethod();

        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $routeRegex => $routeInfo) {
            if (preg_match($routeRegex, $path, $matches)) {
                // Filter string keys for parameters
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                // Execute Middlewares
                foreach ($routeInfo['middlewares'] as $middlewareClass) {
                    if (class_exists($middlewareClass)) {
                        $middleware = new $middlewareClass();
                        $middleware->execute($request, $response);
                    }
                }

                $handler = $routeInfo['handler'];

                if (is_array($handler)) {
                    $controllerClass = $handler[0];
                    $action = $handler[1];

                    if (class_exists($controllerClass)) {
                        $controller = new $controllerClass();
                        if (method_exists($controller, $action)) {
                            return call_user_func_array([$controller, $action], [$request, $response, $params]);
                        }
                    }
                } elseif (is_callable($handler)) {
                    return call_user_func_array($handler, [$request, $response, $params]);
                }
            }
        }

        // 404 Not Found
        $response->setStatusCode(404);
        return View::render('errors/404', ['title' => 'Page Not Found']);
    }
}
