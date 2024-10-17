<?php

namespace Core;

use Controller\CartController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;

class App
{
    private array $routes = [
        '/login' => [
            'GET' => [
                'class' => UserController::class, // UserController::class это тоже самое как и '/Controller/UserController'
                'method' => 'getLogin',
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'login',
            ]
        ],
        '/registration' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getRegistration',
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'registration',
            ]
        ],
        '/main' => [
            'GET' => [
                'class' => ProductController::class,
                'method' => 'getAll',
            ],
        ],
        '/add-product' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'getAddProduct',
            ],
            'POST' => [
                'class' => CartController::class,
                'method' => 'addProductsInCart',
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'checkCart',
            ],
        ],
        '/logout' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'logout',
            ],
        ],
        '/profile' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'myProfile',
            ],
        ],
        '/buy' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getBuy',
            ],
            'POST' => [
                'class' => OrderController::class,
                'method' => 'buy',
            ]
        ],
    ];

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
}
