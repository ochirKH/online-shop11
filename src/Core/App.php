<?php

namespace Core;
class App
{
    private array $routes = [
        '/login' => [
            'GET' => [
                'class' => '/Controller/UserController',
                'method' => 'getLogin',
            ],
            'POST' => [
                'class' => '/Controller/UserController',
                'method' => 'login',
            ]
        ],
        '/registration' => [
            'GET' => [
                'class' => '/Controller/UserController',
                'method' => 'getRegistration',
            ],
            'POST' => [
                'class' => '/Controller/UserController',
                'method' => 'registration',
            ]
        ],
        '/main' => [
            'GET' => [
                'class' => '/Controller/ProductController',
                'method' => 'getAll',
            ],
        ],
        '/add-product' => [
            'GET' => [
                'class' => '/Controller/CartController',
                'method' => 'getAddProduct',
            ],
            'POST' => [
                'class' => '/Controller/CartController',
                'method' => 'addProductsInCart',
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => '/Controller/CartController',
                'method' => 'checkCart',
            ],
        ],
        '/logout' => [
            'GET' => [
                'class' => '/Controller/UserController',
                'method' => 'logout',
            ],
        ],
        '/profile' => [
            'GET' => [
                'class' => '/Controller/UserController',
                'method' => 'myProfile',
            ],
        ],
        '/buy' => [
            'GET' => [
                'class' => '/Controller/OrderController',
                'method' => 'getBuy',
            ],
            'POST' => [
                'class' => '/Controller/OrderController',
                'method' => 'buy',
            ]
        ],
    ];

    public function run()
    {

// создаем переменные для УРИ и Метода

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $route = $this->routes;
        foreach ($route as $location => $method) {
            if ($requestUri === $location) {
                if (isset($method[$requestMethod])) {
                    $getController = $method[$requestMethod]['class'];
                    $getMethod = $method[$requestMethod]['method'];
                    require_once './..' . $getController . '.php';
                    $class = new $getController;
                    return $class->$getMethod();
                } else {
                    return "$requestUri не поддерживается с методом $requestMethod";
                }
            }
        }
        http_response_code(404);
        require_once './../View/404.php';
    }
}
//        if ($requestUri === '/login') {
//            if ($requestMethod === 'GET') {
//                $user = new UserController();
//                $user->getLogin();
//            } elseif ($requestMethod === 'POST') {
//                $user = new UserController();
//                $user->login();
//            } else {
//                echo "$requestUri не поддерживается с методом $requestMethod";
//            }
//        } elseif ($requestUri === '/registration') {
//            if ($requestMethod === 'GET') {
//                $user = new UserController();
//                $user->getRegistration();
//            } elseif ($requestMethod === 'POST') {
//                $user = new UserController();
//                $user->registration();
//            } else {
//                echo "$requestUri не поддерживается с методом $requestMethod";
//            }
//        } elseif ($requestUri === '/main') {
//            if ($requestMethod === 'GET') {
//                $mainUser = new ProductController();
//                $mainUser->getAll();
//            } else {
//                echo "$requestUri не поддерживается с методом $requestMethod";
//            }
//        } elseif ($requestUri === '/add-product') {
//            if ($requestMethod === 'GET') {
//                $product = new CartController();
//                $product->getAddProduct();
//            } elseif ($requestMethod === 'POST') {
//                $product = new CartController();
//                $product->addProductsInCart();
//            } else {
//                echo "$requestUri не поддерживается с методом $requestMethod";
//            }
//        } elseif ($requestUri === '/cart') {
//            if ($requestMethod === 'GET') {
//                $cart = new CartController();
//                $cart->checkCart();
//            } else {
//                echo "$requestUri не поддерживается с методом $requestMethod";
//            }
//        } elseif ($requestUri === '/logout') {
//            if ($requestMethod === 'GET') {
//                $user = new UserController();
//                $user->logout();
//            }
//        } elseif ($requestUri === '/profile') {
//            if ($requestMethod === 'GET') {
//                $user = new UserController();
//                $user->myProfile();
//            } else {
//                echo "$requestUri не поддерживается с методом $requestMethod";
//            }
//        } elseif ($requestUri === '/buy') {
//            if ($requestMethod === 'GET') {
//                $buy = new OrderController();
//                $buy->getBuy();
//            } elseif ($requestMethod === 'POST') {
//                $buy = new OrderController();
//                $buy->buy();
//            } else {
//                echo "$requestUri не поддерживается с методом $requestMethod";
//            }
//        } else {
//            require_once './../View/404.php';
//        }
//
//    }
