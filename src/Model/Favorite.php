<?php

namespace Model;

class Favorite extends Model
{
    public function addProduct($userId, $productId)
    {
        $stmt = $this->pdo->prepare('INSERT INTO user_favorite_products (user_id, product_id) VALUES (:userId, :productId)');
        $stmt->execute(['userId' => $userId, 'productId'=>$productId]);
    }

    public function getByUserIdAndProductId($userId, $productId): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user_favorite_products WHERE user_id = :userId AND product_id = :productId');
        $stmt->execute(['userId' => $userId, 'productId'=> $productId]);
        return $stmt->fetch();

    }

    public function getById($userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user_favorite_products WHERE user_id = :userId');
        $stmt->execute(['userId'=>$userId]);
        return $stmt->fetchAll();
    }
}