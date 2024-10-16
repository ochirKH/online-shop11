<?php

namespace Controller;

use \Model\User;
use \Model\Product;
use \Model\UserOrder;
use \Model\UserProduct;

class OrderController
{
    private User $user;
    private Product $product;
    private UserProduct $userProduct;
    private UserOrder $userOrder;

    public function __construct()
    {
        $this->user = new User();
        $this->product = new Product();
        $this->userProduct = new UserProduct();
        $this->userOrder = new UserOrder();
    }
    public function getBuy()
    {
        require_once "./../View/buy.php";
    }

    public function buy()
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
        } else {
            $userId = $_SESSION['userId'];
        }

        if (isset($_POST['address'])) {
            $deliveryAddress = $_POST['address'];
        }
        if (isset($_POST['number']))
        {
            $number = $_POST['number'];
        }

        $products = $this->product->checkCart($userId); // Смотрим корзину

        foreach ($products as $product) {
            $productOrder = $this->userProduct->checkIdOrder($userId, $product['id']); // Выявляем Id заказа в корзине
            $this->userOrder->add($deliveryAddress, $userId, $product['id']); // Покупка зарегестрирована
        }

        echo 'Товар успешно заказан';
    }

    public function validateForBuy()
    {
        if (isset($_POST['city'])) {
            $city = $_POST['city'];
        }
        if (isset($_POST['number']))
        {
            $number = $_POST['number'];
        }
    }
}