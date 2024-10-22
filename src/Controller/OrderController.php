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

        $cartProductsByUserId = $this->userProduct->getCartUserId($userId); // получаю продукты в корзине пользователя

        $productIds = [];
        foreach ($cartProductsByUserId as $product) {
            $productIds[] = $product['product_id']; //  вытаскиваю id продуктов пользователся
        }

        $products = [];
        foreach ($productIds as $productId) {
            $products[] = $this->product->getProductById($productId);
            // получаю продукты по id с продуктов
            // id name price images category ....
        }

        $result = [];

        foreach ($products as &$product) {
            foreach ($cartProductsByUserId as $cartProductByUserId) {
                if ($cartProductByUserId['product_id'] === $product->getId()) {
                    $product['amount'] = $cartProductByUserId['amount'];
                    $result[] = $product;
                }
            }
        }

        foreach ($result as $elem) {
            $sumOneProduct[] = $elem['amount'] * $elem->getPrice();
        }

        $sumAll = 0;
        foreach ($sumOneProduct as $sum) {
            $sumAll += $sum;
        }

        $orderId = $this->userOrder->add($contactName, $contactPhone, $address, $sumAll, $userId); // id


        foreach ($result as $product) {
            $this->orderProduct->addInTable($orderId, $product);
        }

        $this->userProduct->deleteProduct($userId);

        echo 'Товар успешно заказан';
    }
}

