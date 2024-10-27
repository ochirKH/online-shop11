<?php

namespace Model;
class UserProduct extends Model
{
    private int $id;
    private User $user;
    private Product $product;
    private int $amount;

    public function addProduct(int $user, int $product, int $amount) // Добавляю в корзину товар и количество
    {
        $stmt = $this->pdo->prepare('INSERT INTO user_products (user_id, product_id, amount) VALUES (:user, :product, :amount)');
        $stmt->execute(['user' => $user, 'product' => $product, 'amount' => $amount]);
    }

    public function getByUserIdAndProductId(int $userId, int $productId): UserProduct|null // Проверка у пользователя  таких продуктов
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user_products WHERE user_id = :user AND product_id = :product');
        $stmt->execute(['user' => $userId, 'product' => $productId]);
        $result = $stmt->fetch();

        if ($result === false) {
            return $result = null;
        }

        $data = $this->hydrate($result);
        return $data;
    }

    public function getByUserId(int $userId): array
    {
        $exec = $this->pdo->prepare('SELECT * FROM user_products WHERE user_id = :user');
        // вытаскиваю Id продуктов у пользователя

        $exec->execute(['user' => $userId]);
        return $products = $exec->fetchAll();

        $cartId = [];

        foreach ($products as $product){

            $user = new User();
            $userFromDb = $user->getById($product['user_id']);

            $product = new Product();
            $productFromDb = $product->getProductById($product['product_id']);

            $cartId[] = $this->hydrate($product);
        }
        return $cartId;
    }


    public function updateAmount(int $user, int $product, int $amount)
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user AND product_id = :product");
        $stmt->execute(['user' => $user, 'product' => $product, 'amount' => $amount]);
    }

    public function deleteProduct(int $user)
    {
        $stmt = $this->pdo->prepare( "DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user]);
    }

    function hydrate($data)
    {
        $obj = new self();

        $obj->id = $data['id'];
        $obj->user = $userFromDb;
        $obj->product = $productFromDb;
        $obj->amount = $data['amount'];

        return $obj;
    }
}