<?php

class ProductsModel
{
    public function checkStoreProduct(int $productId): array|false // / Проверяем есть ли такой товар в магазине
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
        $stmt = $pdo->prepare('SELECT id FROM products WHERE id = :product');
        $stmt->execute(['product' => $productId]);
        return $result = $stmt->fetch();
    }
    public function getAll(): array
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

        $exec = $pdo->query('SELECT * FROM products');
        return $result = $exec->fetchAll();
    }

    public function checkCart(int $userId): array|false
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");

        $exec = $pdo->prepare('SELECT product_id FROM user_products WHERE user_id = :user');
        // вытаскиваю Id продуктов у пользователя

        $exec->execute(['user' => $userId]);
        $products = $exec->fetchAll();

        $result = [];

        foreach ($products as $product)
        {
            $productId = $product['product_id'];
            $exec = $pdo->prepare('SELECT * FROM products WHERE id = :product');
            // далее смотрим что за именно эти продукты (имя, фото итд)

            $exec->execute(['product' => $productId]);
            $result[] = $exec->fetch();
        }
       return ($result);
    }
}