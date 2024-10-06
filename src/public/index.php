<?php

// создаем переменные для УРИ и Метода

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        require_once './get_login.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_login.php';
    } else {
        echo "$requestUri не поддерживается с методом $requestMethod";
    }
} elseif ($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        require_once './get_registration.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_registration.php';
    } else {
        echo "$requestUri не поддерживается с методом $requestMethod";
    }
} elseif ($requestUri === '/main') {
    if ($requestMethod === 'GET') {
        require_once './main.php';
    } else {
        echo "$requestUri не поддерживается с методом $requestMethod";
    }
} elseif ($requestUri === '/add-product'){
    if ($requestMethod === 'GET'){
        require_once './get_add_product.php';
    } elseif ($requestMethod === 'POST'){
        require_once './handle_add_product.php';
    } else {
        echo "$requestUri не поддерживается с методом $requestMethod";
    }
} elseif ($requestUri === '/cart'){
    if ($requestMethod === 'GET'){
        require_once './cart.php';
    } else {
        echo "$requestUri не поддерживается с методом $requestMethod";
    }
} elseif ($requestUri === '/logout'){
    if ($requestMethod === 'GET'){
        require_once './logout.php';
    }
}
else {
    require_once './404.php';
}
