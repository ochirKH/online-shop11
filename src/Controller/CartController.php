<?php
require_once './../Model/UserProductsModel.php';
require_once './../Model/ProductsModel.php';
require_once '../Model/UserModel.php';

class CartController
{
    private UserModel $userModel;
    private ProductsModel $productsModel;
    private UserProductsModel $userProductsModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productsModel = new ProductsModel();
        $this->userProductsModel = new UserProductsModel();
    }

    public function getAddProduct(): void
    {
        session_start();
        if (!isset($_SESSION['userId'])){
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

        $result = $this->userProductsModel->checkStoreProduct($productId);

        if ($result === false) {
            exit('Такого товара не существует');
        }

        $result = $this->userProductsModel->checkProductsAndUser($userId, $productId); // Проверка у пользователя  таких продуктов

        if ($result === null) { // Если товара нет в корзине, то создаем новый
            $this->userProductsModel->addProductandAmount($userId, $productId, $amount); // Добавляю в корзину товар и количество
        } else {
            $this->userProductsModel->updateAmount($userId, $productId, $result['amount'] + $amount); //если товар уже есть такой, то меняе количество
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
        $result = $this->productsModel->checkCart($userId);
        require_once '../View/cart.php';
    }

}