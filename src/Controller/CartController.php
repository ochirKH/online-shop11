<?php


require_once '../Model/UserModel.php';

class CartController
{
    private UserModel $userModel;
    private ProductsModel $productsModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productsModel = new ProductsModel();
    }

    public function getAddProduct()
    {
        require_once '../View/get_add_product.php';
    }

    public function addProductsInCart()
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

        $result = $this->userModel->checkStoreProduct($productId);

        if ($result === false) {
            exit('Такого товара не существует');
        }

        $result = $this->userModel->checkProductsAndUser($userId, $productId); // Проверка у пользователя  таких продуктов

        if ($result === null) { // Если товара нет в корзине, то создаем новый
            $this->userModel->addProductandAmount($userId, $productId, $amount); // Добавляю в корзину товар и количество
        } else {
            $this->userModel->updateAmount($userId, $productId, $result['amount'] + $amount); //если товар уже есть такой, то меняе количество
        }

        header("Location: /main");
    }

    public function checkCart()
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            header("Location: /get_login.php");
        }
        $userId = $_SESSION['userId'];
        $this->productController->checkCart($userId);
        require_once '../View/cart.php';
    }

}