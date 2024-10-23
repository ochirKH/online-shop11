<?php

namespace Model;

class OrderProduct extends Model
{
    public function add (int $id, array $product ): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO order_products (order_id, product_id, amount, price) 
VALUES (:orderId, :productId, :amount, :price)');
        $result = $stmt->execute(['orderId'=>$id,'productId'=>$product['id'],'amount'=>$product['amount'],'price'=>$product['price']]);
    }
}