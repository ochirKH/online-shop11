<?php

namespace Model;

class Favorite extends Model
{
    private int $id;
    private User $user;
    private Product $product;

    public function addProduct(int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare('INSERT INTO user_favorite_products (user_id, product_id) VALUES (:userId, :productId)');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }

    public function getByUserIdAndProductId(int $userId, int $productId): Favorite|null
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user_favorite_products WHERE user_id = :userId AND product_id = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $result = $stmt->fetch();

        if (empty($result)) {
            return null;
        }

        $user = new User();
        $userFromDb = $user->getById($result['user_id']);

        $product = new Product();
        $productFromDb = $product->getProductById($result['product_id']);

        $obj = $this->hydrate($result);

        return $obj;

    }


    public function getById(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user_favorite_products WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        $data = $stmt->fetchAll();

        $result = [];

        foreach ($data as $elem)
        {
            $result[] = $this->hydrate($elem);
        }
        return $result;
    }

    function hydrate($data): Favorite
    {
        $user = new User();
        $userFromDb = $user->getById($data['user_id']);

        $product = new Product();
        $productFromDb = $product->getProductById($data['product_id']);

        $obj = new self();

        $obj->id = $data['id'];
        $obj->user = $userFromDb;
        $obj->product = $productFromDb;

        return $obj;
    }
}