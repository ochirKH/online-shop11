<?php
require_once '../Controller/CartController.php';
require_once '../Controller/ProductController.php';
require_once '../Controller/UserController.php';

// создаем переменные для УРИ и Метода

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        $user = new UserController();
        $user->getLogin();
    } elseif ($requestMethod === 'POST') {
        $user = new UserController();
        $user->login();
    } else {
        echo "$requestUri не поддерживается с методом $requestMethod";
    }
} elseif ($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        $user = new UserController();
        $user->getRegistration();
    } elseif ($requestMethod === 'POST') {
        $user = new UserController();
        $user->registration();
    } else {
        echo "$requestUri не поддерживается с методом $requestMethod";
    }
} elseif ($requestUri === '/main') {
    if ($requestMethod === 'GET') {
        $mainUser = new ProductController();
        $mainUser->getAll();
    } else {
        echo "$requestUri не поддерживается с методом $requestMethod";
    }
} elseif ($requestUri === '/add-product') {
    if ($requestMethod === 'GET') {
        $product = new CartController();
        $product->getAddProduct();
    } elseif ($requestMethod === 'POST') {
        $product = new CartController();
        $product->addProductsInCart();
    } else {
        echo "$requestUri не поддерживается с методом $requestMethod";
    }
} elseif ($requestUri === '/cart') {
    if ($requestMethod === 'GET') {
        $cart = new CartController();
        $cart->checkCart();
    } else {
        echo "$requestUri не поддерживается с методом $requestMethod";
    }
} elseif ($requestUri === '/logout') {
    if ($requestMethod === 'GET') {
        $user = new UserController();
        $user->logout();
    }
} elseif ($requestUri === '/profile'){
    if ($requestMethod === 'GET'){
        $user = new UserController();
        $user->myProfile();
    } else {
        echo "$requestUri не поддерживается с методом $requestMethod";
    }
} else {
    require_once './../View/404.php';
}
