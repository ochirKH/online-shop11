<?php

namespace Model;
class Order extends Model
{
    private int $id;
    private string $contactName;
    private int $contactPhone;
    private string $address;
    private float $sum;
    private User $user;

    public function add(string $contactName, int $contactPhone, string $address, float $sum, int $userId): array|null
    {
        $stmt = $this->pdo->prepare('INSERT INTO orders (contact_name, contact_phone, address, sum, user_id) 
VALUES (:name, :phone, :address, :sum, :user_id) returning id');
        $stmt->execute(['name' => $contactName, 'phone' => $contactPhone, 'address' => $address, 'sum' => $sum, 'user_id' => $userId]);
        $data = $stmt->fetch();

        if (empty($data)) {
            return null;
        }

        $obj = new self();

        return $obj->id = $data['id'];
    }

    public function getById(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        $data = $stmt->fetchAll();

        $result = [];

        foreach ($data as $elem) {
            $obj = $this->hydrate($elem);
            $result = $obj;
        }

        return $result;
    }

    private function hydrate($data): Order
    {
        $user = new User();
        $userFromDb = $user->getById($data['user_id']);

        $obj = new self();

        $obj->id = $data['id'];
        $obj->contactName = $data['contact_name'];
        $obj->contactPhone = $data['contact_phone'];
        $obj->address = $data['address'];
        $obj->sum = $data['sum'];
        $obj->user = $userFromDb;

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function getContactPhone(): int
    {
        return $this->contactPhone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}