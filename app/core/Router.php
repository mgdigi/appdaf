<?php

namespace App\Core;

require_once "../app/config/middlewares.php";


class Router
{
    public static function resolve(array $routes): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($routes as $route) {
            [$method, $pattern, $handler] = $route;

            $regex = preg_replace('#\{[^/]+\}#', '([^/]+)', $pattern);
            $regex = "#^" . $regex . "$#";

            if ($method === $requestMethod && preg_match($regex, $requestUri, $matches)) {
                array_shift($matches); 
                [$controllerClass, $controllerMethod] = $handler;
                if (class_exists($controllerClass) && method_exists($controllerClass, $controllerMethod)) {
                    $controller = new $controllerClass();
                    $controller->$controllerMethod(...$matches);
                    return;
                }
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode([
                    'data' => null,
                    'statut' => 'error',
                    'code' => 500,
                    'message' => 'Contrôleur ou méthode non trouvée'
                ]);
                return;
            }
        }

        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode([
            'data' => null,
            'statut' => 'error',
            'code' => 404,
            'message' => 'Endpoint non trouvé'
        ]);
    }
}
