<?php

namespace Model;

class OrderProduct extends Model
{
    public function addInTable (array $arr )
    {
        $stmt = $this->pdo->prepare('INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:orderId, :productId, :amount, :price)');
        $result = $stmt->execute(['orderId'=>$arr['orderId'],'productId'=>$arr['productId'],'amount'=>$arr['amount'],'price'=>$arr['price']]);
    }
}