<?php

namespace Controller;

use \Model\User;
use \Model\Product;
use \Model\Order;
use \Model\UserProduct;
use Request\CartRequest;

class CartController
{
    private User $user;
    private Product $product;
    private UserProduct $userProduct;
    private Order $userOrder;
    private CartRequest $cartRequest;

    public function __construct()
    {
        $this->user = new User();
        $this->product = new Product();
        $this->userProduct = new UserProduct();
        $this->userOrder = new Order();
        $this->cartRequest = new CartRequest();
    }

    public function getAddProduct(): void
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
        } else {
            require_once '../View/get_add_product.php';
        }
    }

    public function addProduct(): void
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
        }

        $errors = $this->cartRequest->validate();

        if (empty($errors)) {

            $productId = $_POST['product-id'];
            $amount = $_POST['amount'];
            $userId = $_SESSION['userId'];

            // Проверка у пользователя  таких продуктов
            $userProducts = $this->userProduct->getByUserIdAndProductId($userId, $productId);

            if ($userProducts === null) { // Если товара нет в корзине, то создаем новый
                $this->userProduct->addProduct($userId, $productId, $amount);
                // Добавляю в корзину товар и количество
            } else {
                $this->userProduct->updateAmount($userId, $productId, $userProducts->getAmount() + $amount);
                //если товар уже есть такой, то меняе количество
            }

            header("Location: /main");

        }
        echo 'Такого товара в каталоге нет';
    }



    public function checkCart(): void
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
        }
        $userId = $_SESSION['userId'];

        $cartProductsByUserId = $this->userProduct->getByUserId($userId);// получаю продукты в корзине пользователя

        if ($cartProductsByUserId !== []) {

//            $productIds = [];
//            foreach ($cartProductsByUserId as $product) {
//                $productIds[] = $product['product_id']; //  вытаскиваю id продуктов пользователся
//            }
//
//            $products = [];
//            foreach ($productIds as $productId) {
//                $products[] = $this->product->getProductById($productId);
//                // получаю продукты по id с продуктов
//                // id name price images category ....
//            }
//
//            foreach ($products as &$product) {
//                foreach ($cartProductsByUserId as $cartProductByUserId) {
//                    if ($cartProductByUserId['product_id'] === $product->getId()) {
//                        $product['amount'] = $cartProductByUserId['amount'];
//                        $result[] = $product;
//                    }
//                }
//            }
            $sumOneProduct = [];

            foreach ($cartProductsByUserId as $elem) {
                $sumOneProduct[] = $elem->getAmount() * $elem->getProduct()->getPrice();
            }

            $sumAll = 0;
            foreach ($sumOneProduct as $sum) {
                $sumAll += $sum;
            }

            require_once './../View/cart.php';

        }
        $result = [];
        require_once './../View/cart.php';
    }
}



