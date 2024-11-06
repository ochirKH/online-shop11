<?php

namespace Core;


use Request\LoginRequest;
use Request\Request;

class App
{
    private array $routes = [];

    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI']; // создаем переменные для УРИ

        if (isset($this->routes[$requestUri])) { // проверка если такой УРИ
            $routesMethod = $this->routes[$requestUri]; // /login, /registration ......

            $requestMethod = $_SERVER['REQUEST_METHOD']; // создаем переменные для Метода

            if (isset($routesMethod[$requestMethod])) { // проверка на наличие GET или POST или ...
                $handler = $routesMethod[$requestMethod];

                $handleClass = $handler['class'];
                $handleMethod = $handler['method'];
//                $handleRequest = $handler['request'];
//
                $obj = new $handleClass();  // создание объекта
//
//                if (empty($handleRequest)){
                    $obj->$handleMethod();
//                } else {
//                    $request = new LoginRequest($requestUri, $requestMethod, $_POST);
//                    $obj->$handleMethod($request);
//                }


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
