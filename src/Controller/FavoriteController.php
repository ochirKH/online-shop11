<?php

namespace Controller;

use Model\Favorite;
use Model\Order;
use Model\Product;
use Model\User;
use Model\UserProduct;
use Request\FavoriteRequest;

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

    public function addProductInFavorite(FavoriteRequest $request)
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            header('Location: /login');
        }

        $errors = $request->validate();

        if (empty($errors)) {

            $userId = $_SESSION['userId'];
            $productId = $request->getProductId();

            $checkProductInFavorite = $this->favorite->getByUserIdAndProductId($userId, $productId);

            if ($checkProductInFavorite === null) {
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
}