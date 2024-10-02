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
        echo "$requestUri не поддерживает с методом $requestMethod";
    }
} elseif ($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        require_once './get_registration.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_registration.php';
    } else {
        echo "$requestUri не поддерживает с методом $requestMethod";
    }
} elseif ($requestUri === '/main') {
    if ($requestMethod === 'GET') {
        require_once './main.php';
    } else {
        echo "$requestUri не поддерживает с методом $requestMethod";
    }
} else {
    require_once './404.php';
}
