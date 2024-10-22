<?php

namespace Model;
class UserProduct extends Model
{

    public function addProductandAmount(int $user, int $product, int $amount) // Добавляю в корзину товар и количество
    {
        $stmt = $this->pdo->prepare('INSERT INTO user_products (user_id, product_id, amount) VALUES (:user, :product, :amount)');
        $stmt->execute(['user' => $user, 'product' => $product, 'amount' => $amount]);
    }

    public function checkProductsAndUser(int $userId, int $productId): array|null // Проверка у пользователя  таких продуктов
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user_products WHERE user_id = :user AND product_id = :product');
        $stmt->execute(['user' => $userId, 'product' => $productId]);
        $result = $stmt->fetch();

        if ($result === false) {
            return $result = null;
        } else {
            return $result;
        }
    }

    public function getCartUserId(int $userId): array
    {
        $exec = $this->pdo->prepare('SELECT * FROM user_products WHERE user_id = :user');
        // вытаскиваю Id продуктов у пользователя

        $exec->execute(['user' => $userId]);
        return $products = $exec->fetchAll();

//        $cartId = [];
//        foreach ($products as $product){
//            $cartId = $this->hydrate($product);
//        }
//        return $cartId;
    }

    public function updateAmount(int $user, int $product, int $amount): array|false
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user AND product_id = :product");
        $stmt->execute(['user' => $user, 'product' => $product, 'amount' => $amount]);
        return $stmt->fetchAll();
    }

    public function deleteProduct(int $user)
    {
        $stmt = $this->pdo->prepare( "DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user]);
    }
}