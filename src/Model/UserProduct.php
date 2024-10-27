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
        $userProduct = $stmt->fetch();

        if ($userProduct === false) {
            return $result = null;
        }

        $data = $this->hydrate($userProduct);
        return $data;
    }

    public function getByUserId(int $userId): array
    {
        $exec = $this->pdo->prepare('SELECT * FROM user_products WHERE user_id = :user');
        // вытаскиваю Id продуктов у пользователя

        $exec->execute(['user' => $userId]);
        $userProducts = $exec->fetchAll();

        $data = [];

        foreach ($userProducts as $userProduct){
            $data[] = $this->hydrate($userProduct);
        }
        return $data;
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

    function hydrate(array $data)
    {
        $user = new User();
        $userFromDb = $user->getById($data['user_id']);

        $product = new Product();
        $productFromDb = $product->getProductById($data['product_id']);

        $obj = new self();

        $obj->id = $data['id'];
        $obj->user = $userFromDb;
        $obj->product = $productFromDb;
        $obj->amount = $data['amount'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}