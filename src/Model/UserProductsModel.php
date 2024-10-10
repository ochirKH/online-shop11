<?php


class UserProductsModel
{

    public function addProductandAmount(int $user, int $product, int $amount) // Добавляю в корзину товар и количество
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
        $stmt = $pdo->prepare('INSERT INTO user_products (user_id, product_id, amount) VALUES (:user, :product, :amount)');
        $stmt->execute(['user' => $user, 'product' => $product, 'amount' => $amount]);
    }

    public function checkProductsAndUser(int $userId, int $productId): array|null // Проверка у пользователя  таких продуктов
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

    public function updateAmount(int $user, int $product, int $amount): array|false
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=name", "user", "pwd");
        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user AND product_id = :product");
        $stmt->execute(['user' => $user, 'product' => $product, 'amount' => $amount]);
        return $stmt->fetchAll();
    }
}