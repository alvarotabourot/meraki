<?php

namespace Lib;

class Router {

    private static array $routes = [];
    private static string $baseUri = '/blogfotografiasTFG/public/'; // Cambia esto según el entorno

    public static function setBaseUri(string $baseUri): void {
        self::$baseUri = $baseUri;
    }

    public static function add(string $method, string $action, Callable $controller): void {
        $action = trim($action, '/');
        self::$routes[$method][$action] = $controller;
    }

    public static function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $action = preg_replace("#" . self::$baseUri . "#", '', $_SERVER['REQUEST_URI']);
        $action = trim($action, '/');

        $param = null;
        preg_match('/[0-9]+$/', $action, $match);

        if (!empty($match)) {
            $param = $match[0];
            $action = preg_replace('/' . $match[0] . '/', ':id', $action);
        }

        if (isset(self::$routes[$method][$action])) {
            $callback = self::$routes[$method][$action];
            echo call_user_func($callback, $param);
        } else {
            // Manejar rutas no encontradas
            http_response_code(404);
            echo "404 - Not Found";
        }
    }
}
