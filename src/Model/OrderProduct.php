<?php

namespace Model;

class OrderProduct extends Model
{
    public function addInTable (int $orderId, int $productId, int $amount, int $price )
    {
        $stmt = $this->pdo->prepare('INSERT INTO orders VALUES (:orderId, :productId, :amount, :price');
        $stmt->execute(['orderId'=>$orderId, 'productId'=>$productId, 'amount'=> $amount, 'price'=>$price]);
    }
}