<?php

namespace Model;
class Order extends Model
{
    public  function add (string $contactName, int $contactPhone, string $address, int $sum, int $userId): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO orders (contact_name, contact_phone, address, sum, user_id) VALUES (:name, :phone, :address, :sum, :user_id)');
        $stmt->execute(['name' => $contactName, 'phone' => $contactPhone, 'address'=>$address, 'sum' => $sum, 'user_id'=>$userId]);
    }

    public function getAllOfOrders ($userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        return $result = $stmt->fetchAll();
    }
}