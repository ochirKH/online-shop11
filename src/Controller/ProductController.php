<?php

require_once './../Model/ProductsModel.php';
class ProductController
{
    private ProductsModel $productsModel;

    public function __construct()
    {
        $this->productsModel = new ProductsModel();
    }

    public function getAll(): void
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
        } else {
            $result = $this->productsModel->getAll();
        }
        require_once '../View/main.php';
    }
}