<?php

//require_once './../Model/Model.php';

namespace Model;

class UserOrder extends Model
{
    public  function add ($deliveryAddress, $user, $product ): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO user_orders (delivery_address, user_id, produt_id) 
        VALUES (:delivery_address, :user, :product)');
        $stmt->execute(['delivery_address' => $deliveryAddress, 'user' => $user, 'product'=>$product]);
    }

    public function check ($idOrder): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user_orders WHERE user_product = :idUser');
        $stmt->execute(['idUser'=>$idOrder]);
        return $result = $stmt->fetch();
    }

}