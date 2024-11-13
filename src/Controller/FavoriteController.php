<?php

namespace Controller;

use Model\Favorite;
use Model\Order;
use Model\Product;
use Model\User;
use Model\UserProduct;

class FavoriteController
{
    private User $user;
    private Product $product;
    private UserProduct $userProduct;
    private Order $userOrder;
    private Favorite $favorite;

    public function __construct()
    {
        $this->user = new User();
        $this->product = new Product();
        $this->userProduct = new UserProduct();
        $this->userOrder = new Order();
        $this->favorite = new Favorite();
    }

    public function addProduct()
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
        } else {
            require_once './../View/add_favorite_products.php';
        }
    }

    public function addProductInFavorite()
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
        }

        $errors = $this->validate();

        if (empty($errors)) {

            $userId = $_SESSION['userId'];
            $productId = $_POST['product-id'];

            $checkProductInFavorite = $this->favorite->getByUserIdAndProductId($userId, $productId);

            if ($checkProductInFavorite === false) {
                $this->favorite->addProduct($userId, $productId);
                header('Location: /main');
            } else {
                echo 'Товар уже в избранном';
            }
        }

    }

    public function getProduct()
    {
        session_start();


        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['userId'];

        $favoritesProduct = $this->favorite->getById($userId);

//        $idProducts = [];
//        foreach ($favoritesProduct as $favoriteProduct) {
//            $idProducts[] = $favoriteProduct['product_id'];
//        }
//
//        $fullInfProduct = [];
//        foreach ($idProducts as $idProduct) {
//            $fullInfProduct[] = $this->product->getProductById($idProduct);
//        }

        require_once './../View/favorite.php';

    }

    private function validate(): array
    {
        $errors = [];

        if (isset($_POST['product-id'])) {
            $productId = $_POST['product-id'];

            $product = $this->product->getProductById($productId);

            if (empty($productId)) {
                $errors['product-id'] = 'поле продукта не должен быть пустым';
            } elseif (!is_numeric($productId)) {
                $errors['product-id'] = 'такого товара не существует';
            } elseif ($productId < 0) {
                $errors['product-id'] = 'поле продукта id не должен быть отрицательным';
            } elseif ($product->getId() === null) {
                $errors['product-id'] = 'продукта с таки ID не существует';
            }
        } else {
            $errors['product-id'] = 'id продукта должен быть указан';
        }
        return $errors;
    }
}