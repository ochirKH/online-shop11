<?php

namespace Controller;

use \Model\OrderProduct;
use \Model\User;
use \Model\Product;
use \Model\Order;
use \Model\UserProduct;
use Request\OrderRequest;

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

    public function getOrder()
    {
        require_once "./../View/order.php";
    }

    public function order(OrderRequest $request)
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
        }

        $errors = $request->validate();

        if (empty($errors)){

            $userId = $_SESSION['userId'];
            $contactName = $request->getContactName();
            $contactPhone = $request->getContactPhone();
            $address = $request->getAddress();

            $cartProductsByUserId = $this->userProduct->getByUserId($userId); // получаю продукты в корзине пользователя

            $sumOneProduct = [];

            foreach ($cartProductsByUserId as $elem) {
                $sumOneProduct[] = $elem->getAmount() * $elem->getProduct()->getPrice();
            }

            $sumAll = 0;
            foreach ($sumOneProduct as $sum) {
                $sumAll += $sum;
            }

            $orderId = $this->userOrder->add($contactName, $contactPhone, $address, $sumAll, $userId); // id


            foreach ($cartProductsByUserId as  $product) {
                $this->orderProduct->add($orderId, $product->getProduct()->getId(), $product->getAmount(), $product->getProduct()->getPrice());
            }

            $this->userProduct->deleteProduct($userId);

            echo 'Товар успешно заказан';
        }
    }
}

