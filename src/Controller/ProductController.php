<?php

require_once './../Model/Product.php';
class ProductController
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function getAll(): void
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
        } else {
            $result = $this->product->getAll();
        }
        require_once './../View/main.php';
    }
}