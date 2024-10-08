<?php


class UserProductsModel
{
    public function checkStoreProduct($productId): array|false // / Проверяем есть ли такой товар в магазине
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
        $stmt = $pdo->prepare('SELECT id FROM products WHERE id = :product');
        $stmt->execute(['product' => $productId]);
        return $result = $stmt->fetch();
    }

    public function addProductandAmount($user, $product, $amount) // Добавляю в корзину товар и количество
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
        $stmt = $pdo->prepare('INSERT INTO user_products (user_id, product_id, amount) VALUES (:user, :product, :amount)');
        $stmt->execute(['user' => $user, 'product' => $product, 'amount' => $amount]);
    }

    public function checkProductsAndUser($userId, $productId): array|null // Проверка у пользователя  таких продуктов
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
        $stmt = $pdo->prepare('SELECT * FROM user_products WHERE user_id = :user AND product_id = :product');
        $stmt->execute(['user' => $userId, 'product' => $productId]);
        $result = $stmt->fetch();

        if ($result === false) {
            return $result = null;
        } else {
            return $result;
        }
    }

    public function updateAmount($user, $product, $amount)
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user AND product_id = :product");
        $stmt->execute(['user' => $user, 'product' => $product, 'amount' => $amount]);
        return $stmt->fetchAll();
    }
}