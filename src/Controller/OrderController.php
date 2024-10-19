<?php

namespace Controller;

use \Model\OrderProduct;
use \Model\User;
use \Model\Product;
use \Model\Order;
use \Model\UserProduct;

class OrderController
{
    private User $user;
    private Product $product;
    private UserProduct $userProduct;
    private Order $userOrder;
    private CartController $cartController;
    private OrderProduct $orderProduct;

    public function __construct()
    {
        $this->user = new User();
        $this->product = new Product();
        $this->userProduct = new UserProduct();
        $this->userOrder = new Order();
        $this->cartController = new CartController();
        $this->orderProduct = new OrderProduct();
    }

    public function getBuy()
    {
        require_once "./../View/order.php";
    }

    public function buy()
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
        } else {
            $userId = $_SESSION['userId'];
        }
        if (isset($_POST['contact-name'])) {
            $contactName = $_POST['contact-name'];
        }
        if (isset($_POST['contact-phone'])) {
            $contactPhone = $_POST['contact-phone'];
        }
        if (isset($_POST['address'])) {
            $address = $_POST['address'];
        }


        $cartProductsByUserId = $this->cartController->getProductsUserId(); // получаю продукты в корзине пользователя
        $productIds = $this->cartController->getIdProduct(); // вытаскиваю id продуктов пользователся
        $products = $this->cartController->getFullInfProductInCart(); // Общая инф о товарах
        $this->cartController->getAndAddAmount();
        $sumAll = $this->cartController->getAllSumInCart(); //Общая сумма в коозине

        $addInOrder = $this->userOrder->add($contactName, $contactPhone, $address, $sumAll, $userId);

        $getOrderOfUserIds = $this->userOrder->getAllOfOrders($userId);


        $arr = [];

//        for ($i = 0; $i < count($productId); $i++) {
//            foreach ($productIds as $productId) {
//                $arr['productId'] = $productId;
//            }
//            foreach ($getOrderOfUserIds as $getOrderOfUserId) {
//                $arr['orderId'] = $getOrderOfUserId['id'];
//            }
//            foreach ($cartProductsByUserId as $cartProductByUserId) {
//                $arr['amount'] = $cartProductByUserId['amount'];
//            }
//            foreach ($products as $product) {
//                $arr['price'] = $product['price'];
//            }
        }

        $this->orderProduct->addInTable($arr);
        $arr = [];
        echo 'Товар успешно заказан';
    }
}

