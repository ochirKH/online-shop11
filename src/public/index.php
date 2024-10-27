<?php

require_once './../Core/Autoload.php';

use Controller\CartController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use Core\Autoload;
use Core\App;

Autoload::registrate("/var/www/html/src/");

$app = new App();

$app->createRoute('/login', 'GET', UserController::class, 'getLogin');
$app->createRoute('/login', 'POST', UserController::class,'login');

$app->createRoute('/registration', 'GET', UserController::class, 'getRegistration');
$app->createRoute('/registration', 'POST', UserController::class, 'registration');

$app->createRoute('/buy', 'GET', OrderController::class, 'getOrder');
$app->createRoute('/buy', 'POST', OrderController::class, 'order');

$app->createRoute('/add-product', 'GET', CartController::class, 'getAddProduct');
$app->createRoute('/add-product', 'POST', CartController::class, 'addProductsInCart');

$app->createRoute('/add-product-favorite', 'GET', FavoriteController::class, 'addProduct');
$app->createRoute('/add-product-favorite', 'POST', FavoriteController::class, 'addProductInFavorite');

$app->createRoute('/favorite', 'GET', FavoriteController::class, 'getProduct');
$app->createRoute('/main', 'GET', ProductController::class, 'getAll');
$app->createRoute('/logout', 'GET', UserController::class, 'logout');
$app->createRoute('/cart', 'GET', CartController::class, 'checkCart');
$app->createRoute('/profile', 'GET', UserController::class, 'myProfile');


$app->run();
