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
        if (!isset($_SESSION['userId'])){
            header('Location: /login');
        } else {
            require_once './../View/add_favorite_products.php';
        }
    }

    public function addProductInFavorite()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
        }
        if (isset($_POST['product-id'])) {
            $productId = $_POST['product-id'];
        }


        $checkProductInFavorite = $this->favorite->checkProductInFavorite($userId, $productId);

        if ($checkProductInFavorite === false){
            $this->favorite->addProductInFavorite($userId, $productId);
            header('Location: /main');
        } else {
            echo 'Товар уже в избранном';
        }
    }

    public function checkFavorite()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
        }

        $favoritesProduct = $this->favorite->getAllUserId($userId);


        $idProducts = [];
        foreach ($favoritesProduct as $favoriteProduct)
        {
            $idProducts[] = $favoriteProduct['product_id'];
        }

        $fullInfProduct = [];
        foreach ($idProducts as $idProduct )
        {
           $fullInfProduct[]  = $this->product->getProductById($idProduct);
        }

        require_once './../View/favorite.php';

    }
}