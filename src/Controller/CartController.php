<?php

namespace Controller;

use \Model\User;
use \Model\Product;
use \Model\Order;
use \Model\UserProduct;

class CartController
{
    private User $user;
    private Product $product;
    private UserProduct $userProduct;
    private Order $userOrder;

    public function __construct()
    {
        $this->user = new User();
        $this->product = new Product();
        $this->userProduct = new UserProduct();
        $this->userOrder = new Order();
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

    public function addProductsInCart(): void
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
        }
        if (isset($_POST['product-id'])) {
            $productId = $_POST['product-id'];
        }
        if (isset($_POST['amount'])) {
            $amount = $_POST['amount'];
        }
        if (!is_numeric($amount)) {
            exit('Такой цифры не существует');
        }
        if (!is_numeric($productId)) {
            exit('Такого товара не существует');
        }


        $result = $this->product->getProductById($productId);

        if ($result === false) {
            exit('Такого товара не существует');
        }

        // Проверка у пользователя  таких продуктов
        $result = $this->userProduct->checkProductsAndUser($userId, $productId);

        if ($result === null) { // Если товара нет в корзине, то создаем новый
            $this->userProduct->addProductandAmount($userId, $productId, $amount);
            // Добавляю в корзину товар и количество
        } else {
            $this->userProduct->updateAmount($userId, $productId, $result['amount'] + $amount);
            //если товар уже есть такой, то меняе количество
        }

        header("Location: /main");
    }


    public function checkCart(): void
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
        }
        $userId = $_SESSION['userId'];

        $cartProductsByUserId = $this->product->getCartUserId($userId); // получаю продукты в корзине пользователя

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

        foreach ($products as &$product) {
            foreach ($cartProductsByUserId as $cartProductByUserId) {
                if ($cartProductByUserId['product_id'] === $product['id']) {
                    $product['amount'] = $cartProductByUserId['amount'];
                    $result[] = $product;
                }
            }
        }

        foreach ($result as $elem) {
            $sumOneProduct[] = $elem['amount'] * $elem['price'];
        }

        $sumAll = 0;
        foreach ($sumOneProduct as $sum) {
            $sumAll += $sum;
        }

        require_once './../View/cart.php';
    }
}



