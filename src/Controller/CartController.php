<?php
//require_once './../Model/UserProduct.php';
//require_once './../Model/Product.php';
//require_once './../Model/User.php';
//require_once './../Model/UserOrder.php';

namespace Controller;

use \Model\User;
use \Model\Product;
use \Model\UserOrder;
use \Model\UserProduct;

class CartController
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
        $this->validateForCart();

        $result = $this->product->checkStoreProduct($productId);

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

    private function validateForCart()
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
        if (isset($_POST['city'])) {
            $city = $_POST['city'];
        }

        if (isset($_POST['number'])) {
            $number = $_POST['number'];
        }

    }

    public function checkCart(): void
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
        }
        $userId = $_SESSION['userId'];
        $productsInCart = $this->product->checkCart($userId);
//        print_r($productsInCart);
        $sumPrice = 0;

        foreach ($productsInCart as $product) {
//            $getAmount = $this->userProduct->checkIdOrder($userId, $product['id']);
//            $sum = $product['price'] * $getAmount('amount');
            var_dump($product['price']);
            var_dump($userId);
        }

        require_once './../View/cart.php';
    }

}

