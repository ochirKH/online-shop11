<?php

namespace Core;

use Controller\CartController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;

class App
{
    private array $routes = [];

    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI']; // создаем переменные для УРИ

        if (isset($this->routes[$requestUri])) { // проверка если такой УРИ
            $routesMethod = $this->routes[$requestUri]; // GET or POST or .....

            $requestMethod = $_SERVER['REQUEST_METHOD']; // создаем переменные для Метода

            if (isset($routesMethod[$requestMethod])) { // проверка на наличие GET или POST или ...
                $handler = $routesMethod[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];

                $obj = new $class();  // создание объекта
                $obj->$method();
            } else {
                echo "$requestUri не поддерживается с методом $requestMethod";
            }
        } else {
            http_response_code(404);
            require_once './../View/404.php';
        }
    }

    public function createRoute(string $route, string $method, string $className, string $methodName): void
    {
        $this->routes[$route][$method] = [
            'class' => $className,
            'method' => $methodName
        ];
    }
}
