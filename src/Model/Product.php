<?php

namespace Model;
class Product extends Model
{
    public function getProductById(int $productId): array|false // / Проверяем есть ли такой товар в магазине
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :product');
        $stmt->execute(['product' => $productId]);
        return $result = $stmt->fetch();
    }

    public function getAll(): array
    {
        $exec = $this->pdo->query('SELECT * FROM products');
        return $result = $exec->fetchAll();
    }

    public function getCartUserId(int $userId): array
    {
        $exec = $this->pdo->prepare('SELECT * FROM user_products WHERE user_id = :user');
        // вытаскиваю Id продуктов у пользователя

        $exec->execute(['user' => $userId]);
        return $products = $exec->fetchAll();
    }
}