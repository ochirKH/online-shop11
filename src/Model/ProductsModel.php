<?php

class ProductsModel
{
    public function getAll(): array
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

        $exec = $pdo->query('SELECT * FROM products');
        return $result = $exec->fetchAll();
    }

    public function checkCart($userId)
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

        $exec = $pdo->prepare('SELECT product_id FROM user_products WHERE user_id = :user'); // вытаскиваю Id продуктов у пользователя
        $exec->execute(['user' => $userId]);
        $products = $exec->fetchAll();

        $result = [];

        foreach ($products as $product) {
            $productId = $product['product_id'];
            $exec = $pdo->prepare('SELECT * FROM products WHERE id = :product'); // далее смотрим что за именно эти продукты (имя, фото итд)
            $exec->execute(['product' => $productId]);
            return $result[] = $exec->fetch();
        }
    }
}