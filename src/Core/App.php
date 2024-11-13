<?php

namespace Core;


use Controller\CartController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\UserController;
use Request\CartRequest;
use Request\FavoriteRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;
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

                $className = $handler['class'];
                $methodName = $handler['method'];
//                $handleRequest = $handler['request'];
//
                $firstObj = new $className();

//
                if ($className === UserController::class && $methodName === 'registration') {
                    $objRequest = new RegistrateRequest($requestUri, $requestMethod, $_POST);  // создание объекта
                    $firstObj->$methodName($objRequest);
                } elseif ($className === UserController::class && $methodName === 'login') {
                    $objRequest = new LoginRequest($requestUri, $requestMethod, $_POST);
                    $firstObj->$methodName($objRequest);
                } elseif ($className === CartController::class && $methodName === 'addProduct') {
                    $objRequest = new CartRequest($requestUri, $requestMethod, $_POST);
                    $firstObj->$methodName($objRequest);
                } elseif ($className === OrderController::class && $methodName === 'order') {
                    $objRequest = new OrderRequest($requestUri, $requestMethod, $_POST);
                    $firstObj->$methodName($objRequest);
                } elseif ($className === FavoriteController::class && $methodName === 'addProductInFavorite') {
                    $objRequest = new FavoriteRequest($requestUri, $requestMethod, $_POST);
                    $firstObj->$methodName($objRequest);
                } else {
                    $firstObj->$methodName();
                }

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
            'method' => $methodName,
//            'request' => $requestName
        ];
    }
}
